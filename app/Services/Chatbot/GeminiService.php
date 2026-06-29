<?php

/** Goal: Gemini API service with function calling using Interactions API, Caller: Chatbot Livewire, Deps: config/services.php */

namespace App\Services\Chatbot;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeminiService
{
    /** @var array<int, string> */
    private array $apiKeys;

    private string $model;

    private string $baseUrl = 'https://generativelanguage.googleapis.com/v1beta';

    public function __construct()
    {
        $this->apiKeys = config('services.gemini.api_keys', []);
        $this->model = config('services.gemini.model', 'gemini-2.0-flash');
    }

    /**
     * Pilih API key secara round-robin menggunakan Cache atomic counter.
     * Jika $pinnedIndex diberikan, gunakan key tersebut langsung (conversation lama).
     * Jika $skipIndexes diberikan, key pada index tersebut akan dilewati (fallback 429).
     *
     * @param  array<int, int>  $skipIndexes
     * @return array{key: string, index: int}|null
     */
    private function resolveApiKey(?int $pinnedIndex = null, array $skipIndexes = []): ?array
    {
        $total = count($this->apiKeys);

        if ($total === 0) {
            return null;
        }

        // Jika conversation sudah ada pinned key, gunakan itu (tidak increment counter)
        if ($pinnedIndex !== null && isset($this->apiKeys[$pinnedIndex]) && ! in_array($pinnedIndex, $skipIndexes, true)) {
            return ['key' => $this->apiKeys[$pinnedIndex], 'index' => $pinnedIndex];
        }

        // Conversation baru — round-robin via atomic increment
        $counter = Cache::increment('gemini.key_index');
        $startIndex = ($counter - 1) % $total;

        // Cari key yang belum di-skip (untuk fallback 429)
        for ($i = 0; $i < $total; $i++) {
            $index = ($startIndex + $i) % $total;
            if (! in_array($index, $skipIndexes, true)) {
                return ['key' => $this->apiKeys[$index], 'index' => $index];
            }
        }

        return null;
    }

    /**
     * Kirim pesan ke Gemini API menggunakan Interactions API.
     *
     * @param  array<int, array{role: string, content: string}>  $history
     * @param  array{id: int, name: string, kode_pegawai: string|null, roles: array<string>, permissions: array<string>}  $userContext
     * @return array{content: string, interaction_id: string|null, api_key_index: int|null, error: string|null}
     */
    public function sendMessage(array $history, string $userMessage, ?string $previousInteractionId = null, array $userContext = [], ?int $pinnedKeyIndex = null, string $persona = 'professional'): array
    {
        if (empty($this->apiKeys)) {
            return [
                'content' => '',
                'interaction_id' => $previousInteractionId,
                'api_key_index' => null,
                'error' => 'GEMINI_API_KEYS belum dikonfigurasi. Silakan tambahkan di file .env',
            ];
        }

        $systemInstruction = $this->buildSystemInstruction($userContext, $persona);
        $tools = $this->buildTools();
        $model = $this->model;

        // Payload turn awal
        $payload = [
            'model' => $model,
            'input' => $userMessage,
            'tools' => $tools,
            'system_instruction' => $systemInstruction,
            'generation_config' => [
                'temperature' => 0.7,
            ],
            'store' => true,
        ];

        if ($previousInteractionId) {
            $payload['previous_interaction_id'] = $previousInteractionId;
        }

        $interactionId = $previousInteractionId;
        $maxRounds = 5;

        // Resolve key awal via round-robin (atau pinned jika conversation lama)
        $skippedKeyIndexes = [];
        $resolved = $this->resolveApiKey($pinnedKeyIndex, $skippedKeyIndexes);

        if (! $resolved) {
            return [
                'content' => '',
                'interaction_id' => $interactionId,
                'api_key_index' => null,
                'error' => 'Tidak ada API key Gemini yang tersedia.',
            ];
        }

        $activeKey = $resolved['key'];
        $activeKeyIndex = $resolved['index'];

        for ($round = 0; $round < $maxRounds; $round++) {
            $response = Http::timeout(60)
                ->post("{$this->baseUrl}/interactions?key={$activeKey}", $payload);

            if (! $response->successful()) {
                $errorBody = $response->json();
                $errorMsg = $errorBody['error']['message'] ?? 'API request failed';
                $status = $response->status();

                // Fallback ke key berikutnya jika 429 Rate Limit
                if ($status === 429) {
                    Log::warning('Gemini API 429 Rate Limit, rotating key', [
                        'key_index' => $activeKeyIndex,
                        'round' => $round,
                    ]);

                    $skippedKeyIndexes[] = $activeKeyIndex;
                    $fallback = $this->resolveApiKey(null, $skippedKeyIndexes);

                    if ($fallback) {
                        $activeKey = $fallback['key'];
                        $activeKeyIndex = $fallback['index'];
                        continue;
                    }

                    return [
                        'content' => '',
                        'interaction_id' => $interactionId,
                        'api_key_index' => null,
                        'error' => 'Semua API key Gemini sedang terkena rate limit (429). Coba beberapa saat lagi.',
                    ];
                }

                Log::error('Gemini Interactions API error', ['status' => $status, 'body' => $errorBody]);

                return [
                    'content' => '',
                    'interaction_id' => $interactionId,
                    'api_key_index' => null,
                    'error' => "Gemini API Error: {$errorMsg}",
                ];
            }

            $data = $response->json();
            $interactionId = $data['id'] ?? $interactionId;
            $steps = $data['steps'] ?? [];

            // Cari jika ada step bertipe function_call
            $functionCall = collect($steps)->firstWhere('type', 'function_call');

            if ($functionCall) {
                $fnName = $functionCall['name'] ?? '';
                $fnArgs = $functionCall['arguments'] ?? $functionCall['args'] ?? [];
                $callId = $functionCall['id'] ?? '';

                $fnResult = $this->executeFunction($fnName, $fnArgs);

                // Payload untuk membalas function call
                $payload = [
                    'model' => $model,
                    'previous_interaction_id' => $interactionId,
                    'input' => [
                        [
                            'type' => 'function_result',
                            'name' => $fnName,
                            'call_id' => $callId,
                            'result' => [
                                [
                                    'type' => 'text',
                                    'text' => json_encode(['result' => $fnResult]),
                                ],
                            ],
                        ],
                    ],
                    'tools' => $tools,
                    'system_instruction' => $systemInstruction,
                    'generation_config' => [
                        'temperature' => 0.7,
                    ],
                    'store' => true,
                ];

                continue;
            }

            // Cari step bertipe model_output terakhir
            $modelOutputStep = collect($steps)->where('type', 'model_output')->last();
            if ($modelOutputStep && ! empty($modelOutputStep['content'])) {
                $textParts = [];
                foreach ($modelOutputStep['content'] as $content) {
                    if (($content['type'] ?? '') === 'text' && isset($content['text'])) {
                        $textParts[] = $content['text'];
                    }
                }
                $text = implode('', $textParts);

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

        return [
            'content' => '',
            'interaction_id' => $interactionId,
            'api_key_index' => null,
            'error' => 'Terlalu banyak function call rounds',
        ];
    }

    private const PROMPT_BASE_PATH = 'prompts/chatbot';

    private const VALID_PERSONAS = ['professional', 'cheerful', 'strict'];

    /**
     * Load a prompt file from resources/prompts/chatbot/.
     */
    private function loadPromptFile(string $relativePath): string
    {
        $path = resource_path(self::PROMPT_BASE_PATH . '/' . $relativePath);

        if (! file_exists($path)) {
            Log::error('Chatbot prompt file not found', ['path' => $path]);

            return '';
        }

        return file_get_contents($path);
    }

    /**
     * Build the full system instruction by loading modular MD files and replacing placeholders.
     *
     * @param  array{id: int, name: string, kode_pegawai: string|null, roles: array<string>, permissions: array<string>}  $userContext
     */
    private function buildSystemInstruction(array $userContext = [], string $persona = 'professional'): string
    {
        $currentTime = now()->setTimezone('Asia/Jakarta')->translatedFormat('l, d F Y H:i:s');
        $baseUrl = rtrim(config('app.url', 'https://indodacin.dev'), '/');

        $validatedPersona = in_array($persona, self::VALID_PERSONAS, true) ? $persona : 'professional';

        $template = $this->loadPromptFile('system.md');
        $schema = $this->loadPromptFile('schema.md');
        $navigation = $this->loadPromptFile('navigation.md');
        $personaContent = $this->loadPromptFile("personas/{$validatedPersona}.md");
        $permissionBlock = $this->buildPermissionContextBlock($userContext);

        return str_replace(
            ['{{ currentTime }}', '{{ baseUrl }}', '{{ schema }}', '{{ navigation }}', '{{ persona }}', '{{ permissionBlock }}'],
            [$currentTime, $baseUrl, $schema, $navigation, $personaContent, $permissionBlock],
            $template,
        );
    }

    /**
     * @return array<int, array{functionDeclarations: array}>
     */
    private function buildTools(): array
    {
        return [
            [
                'type' => 'function',
                'name' => 'query_database',
                'description' => 'Execute a READ-ONLY SQL query against the system database. Only SELECT statements are allowed. Use this to search, filter, aggregate, or analyze data.',
                'parameters' => [
                    'type' => 'object',
                    'properties' => [
                        'sql' => [
                            'type' => 'string',
                            'description' => 'The SELECT SQL query to execute. Must start with SELECT. Max 50 rows (add LIMIT 50 if not present).',
                        ],
                    ],
                    'required' => ['sql'],
                ],
            ],
        ];
    }

    /**
     * @return array{success: bool, data?: array, error?: string, rows_count?: int}
     */
    private function executeFunction(string $name, array $args): array
    {
        if ($name !== 'query_database') {
            return ['success' => false, 'error' => "Unknown function: {$name}"];
        }

        $sql = trim($args['sql'] ?? '');

        // Validate SELECT only
        if (! preg_match('/^\s*SELECT\b/i', $sql)) {
            return ['success' => false, 'error' => 'Only SELECT queries are allowed'];
        }

        // Block dangerous keywords
        $blocked = ['INSERT', 'UPDATE', 'DELETE', 'DROP', 'ALTER', 'CREATE', 'TRUNCATE', 'REPLACE', 'GRANT', 'REVOKE', 'EXEC', 'EXECUTE', 'CALL'];
        foreach ($blocked as $keyword) {
            if (preg_match('/\b'.$keyword.'\b/i', $sql)) {
                return ['success' => false, 'error' => "Blocked keyword detected: {$keyword}"];
            }
        }

        // Enforce LIMIT
        if (! preg_match('/\bLIMIT\b/i', $sql)) {
            $sql = rtrim($sql, '; ').' LIMIT 50';
        }

        try {
            $results = DB::select($sql);
            $data = array_map(fn ($row) => (array) $row, $results);

            return [
                'success' => true,
                'data' => $data,
                'rows_count' => count($data),
            ];
        } catch (\Exception $e) {
            Log::warning('Chatbot SQL error', ['sql' => $sql, 'error' => $e->getMessage()]);

            return ['success' => false, 'error' => 'Query error: '.$e->getMessage()];
        }
    }

    /**
     * Build the permission context block injected into the system prompt.
     *
     * Maps application Spatie permissions to table-level access rules so the AI
     * knows which data categories the current user can query.
     *
     * @param  array{id: int, name: string, kode_pegawai: string|null, roles: array<string>, permissions: array<string>}  $userContext
     */
    private function buildPermissionContextBlock(array $userContext): string
    {
        $permissions = $userContext['permissions'] ?? [];
        $roles = $userContext['roles'] ?? [];
        $isAdmin = in_array('super-admin', $roles, true) || in_array('admin', $roles, true);
        $userId = $userContext['id'] ?? 0;
        $kodePegawai = $userContext['kode_pegawai'] ?? null;

        /** @var array<string, array{tables: array<string>, permission: string|null}> $tableGroups */
        $tableGroups = [
            'Attendance Data (tb_attendance, tb_attendance_out, tb_attendance_inquiries)' => [
                'tables' => ['tb_attendance', 'tb_attendance_out', 'tb_attendance_inquiries'],
                'permission' => 'attendance-view',
            ],
            'Employee Data (tb_pegawai, tb_jabatan, tb_golongan, tb_division, tb_placement, tb_jadwal)' => [
                'tables' => ['tb_pegawai', 'tb_jabatan', 'tb_golongan', 'tb_division', 'tb_placement', 'tb_jadwal'],
                'permission' => 'pegawai-list',
            ],
            'SPK / Work Orders (tb_spk, tb_produksi, tb_purchasing_request, tb_laporan_fondasi, tb_packing_list, tb_packing_list_kit)' => [
                'tables' => ['tb_spk', 'tb_produksi', 'tb_purchasing_request', 'tb_laporan_fondasi', 'tb_packing_list', 'tb_packing_list_kit'],
                'permission' => 'spk-list',
            ],
            'Invoice / Receivables (tb_invoice, tb_collect, tb_collect_tasks, tb_collect_tasks_ppn, tb_collect_idy_ppn)' => [
                'tables' => ['tb_invoice', 'tb_collect', 'tb_collect_tasks', 'tb_collect_tasks_ppn', 'tb_collect_idy_ppn'],
                'permission' => 'invoice-list',
            ],
            'Driver Reports (tb_drivers)' => [
                'tables' => ['tb_drivers'],
                'permission' => 'driver-list',
            ],
            'Sales Reports (tb_sales)' => [
                'tables' => ['tb_sales'],
                'permission' => 'sales-list',
            ],
            'Technician & Points (tb_technician, tb_technician_points, tb_point_transactions, tb_teams, tb_team_members)' => [
                'tables' => ['tb_technician', 'tb_technician_points', 'tb_point_transactions', 'tb_teams', 'tb_team_members'],
                'permission' => 'technician-list',
            ],
            'System Announcements (tb_announcements, tb_announcement_reads)' => [
                'tables' => ['tb_announcements', 'tb_announcement_reads'],
                'permission' => 'announcement-list',
            ],
            'Notifications (notifications)' => [
                'tables' => ['notifications'],
                'permission' => null,
            ],
        ];

        $lines = [];
        $lines[] = '## User Context & Access Rights';
        $lines[] = '';
        $lines[] = "- **User ID**: {$userId}";
        $lines[] = '- **Name**: '.($userContext['name'] ?? 'Unknown');
        $lines[] = '- **Kode Pegawai**: '.($kodePegawai ?? 'N/A');
        $lines[] = '- **Roles**: '.(! empty($roles) ? implode(', ', $roles) : 'none');
        $lines[] = '';
        $lines[] = '### Table Access Control';
        $lines[] = '';

        foreach ($tableGroups as $label => $config) {
            $granted = $isAdmin || $config['permission'] === null || in_array($config['permission'], $permissions, true);
            $lines[] = $this->buildPermissionGrantLine($label, $granted);
        }

        $lines[] = '';
        $lines[] = '### Data Scope Rules';
        $lines[] = '';

        if ($isAdmin) {
            $lines[] = '- You have **admin access** — you may query ALL rows across all accessible tables without user-level filtering.';
        } else {
            $lines[] = "- **Attendance**: You may only view attendance records where `kode_pegawai = '{$kodePegawai}'` unless you have the `attendance-view` permission, in which case you may view all employees' attendance.";
            $lines[] = '- **Notifications**: Only query notifications where `notifiable_id = '.$userId."'.";
            $lines[] = '- For all other permitted tables: you may view all data within that category, but NEVER expose salary, password, token, or credential fields.';
        }

        return implode("\n", $lines);
    }

    private function buildPermissionGrantLine(string $label, bool $granted): string
    {
        $icon = $granted ? '✅' : '❌';
        $status = $granted ? 'ACCESS GRANTED' : 'ACCESS DENIED';

        return "- {$icon} **{$label}** — {$status}";
    }

    /**
     * Generate a short title from a user message.
     */
    public function generateTitle(string $message): string
    {
        $clean = strip_tags($message);
        $clean = preg_replace('/\s+/', ' ', $clean);

        return mb_strlen($clean) > 50 ? mb_substr($clean, 0, 47).'...' : $clean;
    }
}
