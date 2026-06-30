<?php

/** Goal: Orchestrate Gemini Interactions API conversation loop with function calling, Caller: ProcessChatMessage Job, Deps: GeminiApiClient, ChatbotPromptBuilder, ChatbotSqlGuard */

namespace App\Services\Chatbot;

use App\Jobs\GenerateExportFileJob;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class GeminiService
{
    public function __construct(
        private readonly GeminiApiClient $client,
        private readonly ChatbotPromptBuilder $promptBuilder,
        private readonly ChatbotSqlGuard $sqlGuard,
    ) {}

    /**
     * Send a user message through the Gemini Interactions API, handling function-calling rounds.
     *
     * @param  array<int, array{role: string, content: string}>  $history
     * @param  array{id: int, name: string, kode_pegawai: string|null, roles: array<string>, permissions: array<string>}  $userContext
     * @return array{content: string, interaction_id: string|null, api_key_index: int|null, error: string|null}
     */
    public function sendMessage(array $history, string $userMessage, ?string $previousInteractionId = null, array $userContext = [], ?int $pinnedKeyIndex = null, string $persona = 'professional'): array
    {
        if (! $this->client->hasKeys()) {
            return $this->errorResponse($previousInteractionId, 'GEMINI_API_KEYS belum dikonfigurasi. Silakan tambahkan di file .env');
        }

        $systemInstruction = $this->promptBuilder->buildSystemInstruction($userContext, $persona);
        $tools = $this->promptBuilder->buildTools();
        $model = $this->client->getModel();

        $payload = [
            'model' => $model,
            'input' => $userMessage,
            'tools' => $tools,
            'system_instruction' => $systemInstruction,
            'generation_config' => ['temperature' => 0.7],
            'store' => true,
        ];

        if ($previousInteractionId) {
            $payload['previous_interaction_id'] = $previousInteractionId;
        }

        $interactionId = $previousInteractionId;
        $skippedKeyIndexes = [];
        $resolved = $this->client->resolveApiKey($pinnedKeyIndex, $skippedKeyIndexes);

        if (! $resolved) {
            return $this->errorResponse($interactionId, 'Tidak ada API key Gemini yang tersedia.');
        }

        $activeKey = $resolved['key'];
        $activeKeyIndex = $resolved['index'];

        for ($round = 0; $round < 5; $round++) {
            $response = $this->client->post($activeKey, $payload);

            if (! $response->successful()) {
                $errorBody = $response->json();
                $status = $response->status();

                if ($status === 429) {
                    Log::warning('Gemini API 429 Rate Limit, rotating key', ['key_index' => $activeKeyIndex, 'round' => $round]);
                    $skippedKeyIndexes[] = $activeKeyIndex;
                    $fallback = $this->client->resolveApiKey(null, $skippedKeyIndexes);

                    if ($fallback) {
                        $activeKey = $fallback['key'];
                        $activeKeyIndex = $fallback['index'];
                        continue;
                    }

                    return $this->errorResponse($interactionId, 'Semua API key Gemini sedang terkena rate limit (429). Coba beberapa saat lagi.');
                }

                Log::error('Gemini Interactions API error', ['status' => $status, 'body' => $errorBody]);

                return $this->errorResponse($interactionId, 'Gemini API Error: '.($errorBody['error']['message'] ?? 'API request failed'));
            }

            $data = $response->json();
            $interactionId = $data['id'] ?? $interactionId;
            $steps = $data['steps'] ?? [];

            $functionCall = collect($steps)->firstWhere('type', 'function_call');

            if ($functionCall) {
                $fnName = $functionCall['name'] ?? '';
                $fnArgs = $functionCall['arguments'] ?? $functionCall['args'] ?? [];
                $callId = $functionCall['id'] ?? '';

                $fnResult = $this->executeFunction($fnName, $fnArgs, $userContext);

                $payload = [
                    'model' => $model,
                    'previous_interaction_id' => $interactionId,
                    'input' => [[
                        'type' => 'function_result',
                        'name' => $fnName,
                        'call_id' => $callId,
                        'result' => [['type' => 'text', 'text' => json_encode(['result' => $fnResult])]],
                    ]],
                    'tools' => $tools,
                    'system_instruction' => $systemInstruction,
                    'generation_config' => ['temperature' => 0.7],
                    'store' => true,
                ];

                continue;
            }

            $modelOutputStep = collect($steps)->where('type', 'model_output')->last();

            if ($modelOutputStep && ! empty($modelOutputStep['content'])) {
                $text = implode('', array_column(
                    array_filter($modelOutputStep['content'], fn ($c) => ($c['type'] ?? '') === 'text' && isset($c['text'])),
                    'text'
                ));

                return [
                    'content' => $text ?: 'Tidak ada respons teks dari AI.',
                    'interaction_id' => $interactionId,
                    'api_key_index' => $activeKeyIndex,
                    'error' => null,
                ];
            }

            return [
                'content' => 'Tidak ada output dari AI.',
                'interaction_id' => $interactionId,
                'api_key_index' => $activeKeyIndex,
                'error' => null,
            ];
        }

        return $this->errorResponse($interactionId, 'Terlalu banyak function call rounds');
    }

    /**
     * Generate a short title from a user message.
     */
    public function generateTitle(string $message): string
    {
        $clean = preg_replace('/\s+/', ' ', strip_tags($message));

        return mb_strlen($clean) > 50 ? mb_substr($clean, 0, 47).'...' : $clean;
    }

    /**
     * @return array{success: bool, data?: array, error?: string, rows_count?: int, download_url?: string, format?: string, file_name?: string}
     */
    private function executeFunction(string $name, array $args, array $userContext = []): array
    {
        return match ($name) {
            'query_database' => $this->runQueryDatabase($args, $userContext),
            'export_data_file' => $this->runExportDataFile($args),
            default => ['success' => false, 'error' => "Unknown function: {$name}"],
        };
    }

    /** @return array{success: bool, data?: array, error?: string, rows_count?: int} */
    private function runQueryDatabase(array $args, array $userContext): array
    {
        $sql = trim($args['sql'] ?? '');

        $validation = $this->sqlGuard->validateSqlAccess($sql, $userContext);
        if (! $validation['allowed']) {
            return ['success' => false, 'error' => $validation['error']];
        }

        if (! preg_match('/\bLIMIT\b/i', $sql)) {
            $sql = rtrim($sql, '; ').' LIMIT 50';
        }

        try {
            $results = DB::select($sql);

            return [
                'success' => true,
                'data' => array_map(fn ($row) => (array) $row, $results),
                'rows_count' => count($results),
            ];
        } catch (\Exception $e) {
            Log::warning('Chatbot SQL error', ['sql' => $sql, 'error' => $e->getMessage()]);

            return ['success' => false, 'error' => 'Query error: '.$e->getMessage()];
        }
    }

    /** @return array{success: bool, download_url?: string, format?: string, file_name?: string, error?: string} */
    private function runExportDataFile(array $args): array
    {
        $dataJson = $args['data_json'] ?? '[]';
        $format = strtolower($args['format'] ?? 'xlsx');
        $title = $args['title'] ?? 'Laporan Export';

        $data = json_decode($dataJson, true);

        if (! is_array($data)) {
            return ['success' => false, 'error' => 'Invalid data_json format. Must be a JSON array of objects.'];
        }

        if (empty($data)) {
            return ['success' => false, 'error' => 'Cannot export an empty dataset.'];
        }

        try {
            $result = GenerateExportFileJob::dispatchSync($data, $format, $title);

            return [
                'success' => true,
                'download_url' => $result['download_url'],
                'format' => $result['format'],
                'file_name' => $result['file_name'],
            ];
        } catch (\Exception $e) {
            Log::error('Chatbot export error', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);

            return ['success' => false, 'error' => 'Failed to generate file: '.$e->getMessage()];
        }
    }

    /** @return array{content: string, interaction_id: string|null, api_key_index: null, error: string} */
    private function errorResponse(?string $interactionId, string $message): array
    {
        return [
            'content' => '',
            'interaction_id' => $interactionId,
            'api_key_index' => null,
            'error' => $message,
        ];
    }
}
