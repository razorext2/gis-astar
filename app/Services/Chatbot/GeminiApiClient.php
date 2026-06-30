<?php

/** Goal: Manage Gemini API keys (round-robin + 429 fallback) and fire HTTP requests, Caller: GeminiService, Deps: config/services.php, Cache */

namespace App\Services\Chatbot;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class GeminiApiClient
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

    public function getModel(): string
    {
        return $this->model;
    }

    public function hasKeys(): bool
    {
        return ! empty($this->apiKeys);
    }

    /**
     * POST a payload to the Gemini Interactions endpoint using the given API key.
     */
    public function post(string $activeKey, array $payload): Response
    {
        return Http::timeout(60)
            ->post("{$this->baseUrl}/interactions?key={$activeKey}", $payload);
    }

    /**
     * Resolve an API key via round-robin or pinned index.
     * Keys in $skipIndexes are skipped (used for 429 fallback rotation).
     *
     * @param  array<int, int>  $skipIndexes
     * @return array{key: string, index: int}|null
     */
    public function resolveApiKey(?int $pinnedIndex = null, array $skipIndexes = []): ?array
    {
        $total = count($this->apiKeys);

        if ($total === 0) {
            return null;
        }

        if ($pinnedIndex !== null && isset($this->apiKeys[$pinnedIndex]) && ! in_array($pinnedIndex, $skipIndexes, true)) {
            return ['key' => $this->apiKeys[$pinnedIndex], 'index' => $pinnedIndex];
        }

        $counter = Cache::increment('gemini.key_index');
        $startIndex = ($counter - 1) % $total;

        for ($i = 0; $i < $total; $i++) {
            $index = ($startIndex + $i) % $total;
            if (! in_array($index, $skipIndexes, true)) {
                return ['key' => $this->apiKeys[$index], 'index' => $index];
            }
        }

        return null;
    }
}
