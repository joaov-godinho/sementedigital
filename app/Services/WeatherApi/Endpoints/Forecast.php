<?php

namespace App\Services\WeatherApi\Endpoints;

use App\Services\WeatherApi\Entities\EForecast;
use App\Services\WeatherApi\WeatherApiService;
use Illuminate\Database\Eloquent\Collection;

class Forecast
{
    private WeatherApiService $service;

    public function __construct()
    {
        $this->service = new WeatherApiService();
    }

    public function get(string $location, int $days = 1): Collection
    {
        $response = $this->service
            ->api
            ->get('/forecast.json', [
                'q' => $location,
                'days' => $days
            ]);

        return $this->transform($response->json('forecast.forecastday', []));
    }

    private function transform(array $json): Collection
    {
        $data = collect($json)->map(fn ($forecast) => new EForecast($forecast));
        return new Collection($data->toArray());
    }
}
