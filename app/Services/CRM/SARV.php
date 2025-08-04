<?php

namespace App\Services\CRM;

use Illuminate\Support\Facades\Http;

class SARV
{
    public int $limit;
    public int $offset;
    public mixed $data;
    public string $module;
    public string $utype = 'persol';

    private string $loginUrl = 'https://app.sarvcrm.com/API.php?method=Login';
    private string $baseUrl = 'https://app.sarvcrm.com/API.php';

    public function login($request)
    {
        $credentials = $this->validateCredentials($request);
        if (is_array($credentials) && isset($credentials['error'])) return response()->json($credentials, 400);

        $loginData = $this->prepareLoginData(...$credentials);
        try {
            $response = Http::withOptions(['verify' => false])->post($this->loginUrl, $loginData);

            if ($response->failed()) return response()->json(['error' => 'Error occurred during login'], $response->status());

            return $this->handleLoginResponse($response, $request);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Network error or service unavailable'], 503);
        }
    }


    public function validateCredentials($request)
    {
        $data = $request->only('username', 'password');

        if (empty($data['username']) || empty($data['password'])) return response()->json(['error' => 'Invalid credentials'], 422);

        return [$data['username'], $data['password']];
    }

    public function prepareLoginData($username, $password): array
    {
        return [
            'utype' => $this->utype,
            'user_name' => $username,
            'password' => md5($password),
            'language' => 'en_US',
        ];
    }

    public function handleLoginResponse($response, $request)
    {
        if ($response->failed()) return response()->json(['error' => 'Error occurred during login: ' . $response->body()], $response->status());

        $responseData = $response->json();
        if ($responseData['status'] != '200' || empty($responseData['data']['token'])) {
            $errorMessage = is_array($responseData['message'])
                ? implode(', ', $responseData['message'])
                : $responseData['message'];

            return response()->json(['error' => 'Login failed: ' . $errorMessage], 401);
        }

        $request->session()->put('crm_token', $responseData['data']['token']);
        return redirect()->route('crm-login');
    }

    public function getModuleData($request)
    {
        $this->module = $request->input('module');
        $this->offset = $request->input('offset') ?? 0;
        $this->limit = $request->input('limit') ?? 10;

        if (!$token = session('crm_token')) return response()->json(['error' => 'Token not found in session'], 401);

        return $this->fetchData($token);
    }

    public function fetchData($token)
    {
        try {
            $response = Http::withOptions(['verify' => false])
                ->withHeaders($this->prepareAuthorizationHeaders($token))
                ->get($this->getModulesUrl());

            if ($response->failed()) return response()->json(['error' => 'Error retrieving contacts'], $response->status());

            return $this->handleModuleResponse($response);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Network error or service unavailable'], 503);
        }
    }

    public function prepareAuthorizationHeaders($token)
    {
        return ['Authorization' => 'Bearer ' . $token];
    }

    public function getModulesUrl()
    {
        return $this->baseUrl . "?method=Retrieve&module={$this->module}&offset={$this->offset}&limit={$this->limit}";
    }

    public function handleModuleResponse($response)
    {
        if ($response->status() !== 200) return response()->json(['error' => 'Error retrieving contacts: ' . $response->json('message')], $response->status());

        $this->data = $response->json('data');
        if (empty($this->data)) return response()->json(['error' => 'No data retrieved'], 204);

        // Uncomment if filtering is needed
        // $filteredData = $this->filterRecords($this->data);
        return response()->json($this->data);
    }

    private function filterRecords(array $input)
    {
        $filtered = [];

        foreach ($input as $key => $value) {
            if (is_array($value)) {
                $filtered[$key] = $this->filterRecords($value);
            } else {
                if ($this->isValidValue($value)) {
                    $filtered[$key] = $value;
                }
            }
        }

        return $filtered;
    }
    private function isValidValue($value)
    {
        if (is_string($value)) return trim($value) !== '' && $value === strip_tags($value);

        return $value !== null && $value !== [] && $value !== '';
    }
}
