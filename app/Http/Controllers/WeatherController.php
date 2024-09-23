<?php

namespace App\Http\Controllers;

use App\Services\WeatherApi\Endpoints\Forecast;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class WeatherController extends Controller
{
    private Forecast $forecastService;

    public function __construct(Forecast $forecastService)
    {
        $this->forecastService = $forecastService;
    }

    public function show(): View
    {
        $postalCode = Auth::user()->postal_code;
        
        \Log::info('Postal Code:', ['postal_code' => $postalCode]);

        if (is_null($postalCode)) {
            $error = 'Nenhum código postal encontrado para o usuário.';
            return view('weather.previsao-tempo', compact('error'));
        }

        $weatherData = $this->forecastService->get($postalCode, 3);

        if ($weatherData->isEmpty() || $weatherData->contains('error', true)) {
            $cityName = $this->getCityFromPostalCode($postalCode);
            if ($cityName) {
                $weatherData = $this->forecastService->get($cityName, 3);
            }
            if ($weatherData->isEmpty() || $weatherData->contains('error', true)) {
                $error = 'Não foi possível obter as informações de previsão do tempo. Tente um CEP mais específico ou uma cidade.';
                return view('weather.previsao-tempo', compact('error'));
            }
        }

        $iconMap = [
            113 => 'sunny.png',
            116 => 'partly_cloudy.png',
            119 => 'cloudy.png',
            395 => 'heavy_snow_thunder.png',
            302 => 'moderate_rain.png',
        ];
        
        return view('weather.previsao-tempo', compact('weatherData', 'iconMap'));
    }

    private function getCityFromPostalCode(string $postalCode): string
    {
        $postalCodeMapping = [
            '89560-000' => 'Videira',
            '89560-009' => 'Floresta',
        ];
        return $postalCodeMapping[$postalCode] ?? '';
    }
}
