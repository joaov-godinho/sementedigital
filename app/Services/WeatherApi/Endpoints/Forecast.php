<?php

namespace App\Services\WeatherApi\Endpoints;

use App\Services\WeatherApi\WeatherApiService;
use App\DTO\WeatherDTO; // <--- Importamos o DTO aqui
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class Forecast
{
    public function __construct(
        private readonly WeatherApiService $service
    ) {}

    public function get(string $location, int $days = 1): Collection
    {
        $response = $this->service->api->get('/forecast.json', [
            'q' => $location,
            'days' => $days,
            'lang' => 'pt'
        ]);

        if ($response->failed()) {
            $rawResponse = $response->body();
            Log::error("Erro WeatherAPI: {$rawResponse}");
            // Em vez de explodir erro, podemos retornar coleção vazia para não quebrar a tela inteira
            return collect([]);
        }

        // Passamos o array cru 'forecastday' para o método de transformação
        return $this->transform($response->json('forecast.forecastday', []));
    }

    private function transform(array $json): Collection
    {
        if (empty($json)) {
            return collect([]);
        }

        // AQUI É A CORREÇÃO:
        // Mapeamos direto do Array da API para o WeatherDTO.
        // O $day aqui é um array associativo, exatamente o que o DTO espera.
        return collect($json)->map(fn ($day) => WeatherDTO::fromApi($day));
    }
}