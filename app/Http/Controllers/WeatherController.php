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

        if (is_null($postalCode)) {
            $error = 'Nenhum código postal encontrado para o usuário.';
            return view('weather.previsao-tempo', compact('error'));
        }

        $weatherData = $this->forecastService->get($postalCode, 3);

        return view('weather.previsao-tempo', compact('weatherData'));
    }
}
