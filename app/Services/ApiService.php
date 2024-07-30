<?php
// app/Services/ApiService.php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class ApiService
{
    protected $client;
    protected $baseUrl;
    protected $apiKey;

    public function __construct()
    {
        $this->client = new Client();
        $this->baseUrl = config('services.api.base_url');
        $this->apiKey = config('services.api.api_key');
    }

    public function login($username, $password)
    {
        $url = $this->baseUrl . '/sso/login.json';

        $headers = [
            'x-api-key' => $this->apiKey,
            'Content-Type' => 'application/json',
        ];

        $body = [
            'username' => $username,
            'password' => $password,
        ];

        try {
            $response = $this->client->post($url, [
                'headers' => $headers,
                'json' => $body,
            ]);

            $data = json_decode($response->getBody(), true);
            return $data;
        } catch (\Exception $e) {
            Log::error('API Login Error: ' . $e->getMessage());
            return null;
        }
    }
}
