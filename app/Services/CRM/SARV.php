<?php

namespace App\Services\CRM;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class SARV
{
    public int $limit;
    public int $offset;
    public mixed $data;
    public string $module;
    public string $utype = 'persol';

    public string $loginUrl = 'https://app.sarvcrm.com/API.php?method=Login';
    public string $baseUrl = 'https://app.sarvcrm.com/API.php';

    public function login($request)
    {
        [$username, $password] = $this->validateCredentials($request);

        $loginData = $this->prepareLoginData($username, $password);

        try {
            $response = Http::withOptions(['verify' => false])->post($this->loginUrl, $loginData);

            if ($response->failed()) {
                return response()->json(['error' => 'Error occurred during login'], $response->status());
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Network error or service unavailable'], 503);
        }

        return $this->handleLoginResponse($response, $request);
    }

    public function getModuleData($request)
    {
        $this->getModuleCredentials($request);

        $token = session('crm_token');

        if (!$token) {
            return response()->json(['error' => 'Token not found in session'], 401);
        }

        return $this->fetchData($token);
    }

    public function validateCredentials($request)
    {
        $username = $request->input('username');
        $password = $request->input('password');

        if (empty($username) || empty($password)) {
            return response()->json([
                'error' => 'Invalid credentials'
            ], 400);
        }

        return [$username, $password];
    }

    public function prepareLoginData($username, $password)
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
        if ($response->clientError() || $response->serverError()) {
            return response()->json([
                'error' => 'Error occurred during login: ' . $response->body()
            ], $response->status());
        }

        $responseData = $response->json();

        if ($responseData['status'] != '200' || empty($responseData['data']['token'])) {
            $errorMessage = is_array($responseData['message']) ? implode(', ', $responseData['message']) : $responseData['message'];
            return response()->json(['error' => 'Login failed: ' . $errorMessage], 401);
        }

        $request->session()->put('crm_token', $responseData['data']['token']);

        return redirect()->route('crm-login');
    }

    public function getModuleCredentials($request)
    {
        $this->module = $request->input('module');
        $this->offset = $request->input('offset') ?? 0;
        $this->limit = $request->input('limit') ?? 10;
    }

    public function fetchData($token)
    {
        $contactsUrl = $this->getModulesUrl();

        try {
            $response = Http::withOptions(['verify' => false])
                ->withHeaders($this->prepareAuthorizationHeaders($token))
                ->get($contactsUrl);

            if ($response->failed()) {
                return response()->json([
                    'error' => 'Error retrieving contacts'
                ], $response->status());
            }
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Network error or service unavailable'
            ], 503);
        }

        return $this->handleModuleResponse($response);
    }

    public function getModulesUrl()
    {
        return $this->baseUrl . "?method=Retrieve&module={$this->module}&offset={$this->offset}&limit={$this->limit}";
    }

    public function prepareAuthorizationHeaders($token)
    {
        return ['Authorization' => 'Bearer ' . $token];
    }

    public function handleModuleResponse($response)
    {
        if ($response->status() !== 200) {
            return response()->json([
                'error' => 'Error retrieving contacts: ' . $response->json('message')
            ], $response->status());
        }

        $this->data = $response->json('data');

        if (!empty($this->data)) {

//            $filteredData = $this->filterRecords($this->data);

            return response()->json($this->data);
        }

        return response()->json(['error' => 'No data retrieved'], 204);
    }

//    private function filterRecords(array $input)
//    {
//        $filtered = [];
//
//        foreach ($input as $key => $value) {
//            if (is_array($value)) {
//                $filtered[$key] = $this->filterRecords($value);
//            } else {
//                if ($this->isValidValue($value)) {
//                    $filtered[$key] = $value;
//                }
//            }
//        }
//
//        return $filtered;
//    }

    public function isValidValue($value)
    {
        if (is_string($value)) {
            return trim($value) !== '' && $value === strip_tags($value);
        }
        return $value !== null && $value !== [] && $value !== '';
    }
}
