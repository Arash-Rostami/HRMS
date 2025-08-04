<?php

namespace App\Services\CRM;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class SarvCrmService
{
    private const LOGIN_URL = 'https://app.sarvcrm.com/API.php?method=Login';
    private const BASE_API_URL = 'https://app.sarvcrm.com/API.php';
    private const USER_TYPE = 'persol';

    /**
     * Attempt to log in to the CRM and return a token.
     *
     * @throws \Exception
     */
    public function login(string $username, string $password): string
    {
        $payload = [
            'utype' => self::USER_TYPE,
            'user_name' => $username,
            'password' => md5($password),
            'language' => 'en_US',
        ];

        try {
            $response = Http::withOptions(['verify' => false])->post(self::LOGIN_URL, $payload);
            return $this->handleLoginResponse($response);
        } catch (\Throwable $e) {
            throw new \Exception('Network error or CRM service unavailable.', 503, $e);
        }
    }

    /**
     * Fetch data for a given module.
     *
     * @throws \Exception
     */
    public function getModuleData(string $token, ?string $module, int $limit, int $offset): array
    {
        $url = $this->buildModuleUrl($module, $offset, $limit);
        $headers = ['Authorization' => 'Bearer ' . $token];

        try {
            $response = Http::withOptions(['verify' => false])->withHeaders($headers)->get($url);
            return $this->handleModuleResponse($response);
        } catch (\Throwable $e) {
            throw new \Exception('Network error or CRM service unavailable.', 503, $e);
        }
    }


    /**
     * Create a new record in a given module.
     *
     * @throws \Exception
     */
    public function createModuleData(string $token, string $module, array $data): array
    {
        $url = $this->buildCreateModuleUrl();
        $headers = ['Authorization' => 'Bearer ' . $token];
        $payload = [
            'module' => $module,
            'values' => json_encode($data),
        ];

        try {
            $response = Http::withOptions(['verify' => false])->withHeaders($headers)->post($url, $payload);
            return $this->handleCreateModuleResponse($response);
        } catch (\Throwable $e) {
            throw new \Exception('Network error or CRM service unavailable.', 503, $e);
        }
    }

    /**
     * Process the API response for a login request.
     *
     * @throws \Exception
     */
    private function handleLoginResponse(Response $response): string
    {
        if ($response->failed()) {
            throw new \Exception('CRM API returned an error: ' . $response->status(), $response->status());
        }

        $data = $response->json();

        if (($data['status'] ?? null) != '200' || empty($data['data']['token'] ?? null)) {
            $errorMessage = is_array($data['message'] ?? '') ? implode(', ', $data['message']) : ($data['message'] ?? 'Unknown login error');
            throw new \Exception('Login failed: ' . $errorMessage, 401);
        }

        return $data['data']['token'];
    }

    /**
     * Process the API response for a module data request.
     *
     * @throws \Exception
     */
    private function handleModuleResponse(Response $response): array
    {
        if ($response->failed()) {
            throw new \Exception('Error retrieving module data: ' . $response->json('message', 'API Error'), $response->status());
        }

        $data = $response->json('data');

        return $data ?? [];
    }

    /**
     * Build the URL for fetching module data.
     */
    private function buildModuleUrl(string $module, int $offset, int $limit): string
    {
        $queryParams = http_build_query([
            'method' => 'Retrieve',
            'module' => $module,
            'offset' => $offset,
            'limit' => $limit,
        ]);

        return self::BASE_API_URL . '?' . $queryParams;
    }

    /**
     * Process the API response for a create module data request.
     *
     * @throws \Exception
     */
    private function handleCreateModuleResponse(Response $response): array
    {
        if ($response->failed()) {
            throw new \Exception('Error creating module data: ' . $response->json('message', 'API Error'), $response->status());
        }

        $data = $response->json();

        if (($data['status'] ?? null) != '200') {
            $errorMessage = is_array($data['message'] ?? '') ? implode(', ', $data['message']) : ($data['message'] ?? 'Unknown error');
            throw new \Exception('Failed to create record: ' . $errorMessage, 400);
        }

        return $data['data'] ?? [];
    }

    /**
     * Build the URL for creating module data.
     */
    private function buildCreateModuleUrl(): string
    {
        return self::BASE_API_URL . '?method=Save';
    }
}
