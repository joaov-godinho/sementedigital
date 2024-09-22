<?php

namespace App\Services\WeatherApi;
use App\Services\WeatherApi\Endpoints\HasForecast;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;

/**
 * WeatherApiService
 * https://www.weatherapi.com/docs/#apis-realtime
 * https://rapidapi.com/weatherapi/api/weatherapi-com
 */
class WeatherApiService
{
    use HasForecast;
    public PendingRequest $api;

    public function __construct()
    {
        $this->api = Http::withHeaders([
            'X-Rapidapi-Key'=> '523f111825msha2a9f369088aef2p157fd4jsnd0cf38ada7ce',
            'X-Rapidapi-Host'=> 'weatherapi-com.p.rapidapi.com',
        ])->baseUrl('https://weatherapi-com.p.rapidapi.com');
    }
}