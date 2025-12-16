<?php

namespace App\Services\WeatherApi;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;

class WeatherApiService
{
    public PendingRequest $api;

    public function __construct()
    {
        $apiKey = config('services.weatherapi.key');

        $this->api = Http::withOptions([
            'base_uri' => 'https://api.weatherapi.com/v1/',
            'verify' => false, // Mantemos false para o Docker não reclamar de SSL
            'timeout' => 10,
        ])
        ->withQueryParameters([
            'key' => $apiKey, // A chave agora vai na URL automaticamente em todas as requisições
        ]);
    }
}