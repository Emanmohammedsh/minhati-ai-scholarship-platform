<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use RuntimeException;

class ScholarshipApiClient
{
    protected string $baseUrl = 'https://api.scholarshipapi.com/v1';
    protected string $apiKey;

    public function __construct()
    {
        $this->apiKey = (string) config('services.scholarship_api.key');

        if ($this->apiKey === '') {
            throw new RuntimeException('SCHOLARSHIP_API_KEY is not set. Add it to your .env file.');
        }
    }

    public function search(string $query = '', int $limit = 50, int $offset = 0): array
    {
        $response = Http::withToken($this->apiKey)
            ->timeout(20)
            ->post("{$this->baseUrl}/search", [
                'q' => $query,
                'limit' => $limit,
                'offset' => $offset,
            ]);

        if ($response->failed()) {
            throw new RuntimeException("ScholarshipAPI request failed [{$response->status()}]: {$response->body()}");
        }

        return $response->json() ?? [];
    }
}