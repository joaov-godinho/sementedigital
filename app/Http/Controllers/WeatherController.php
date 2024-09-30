<?php

namespace App\Http\Controllers;

use App\Services\WeatherApi\Endpoints\Forecast;
use App\Services\PostalCode\PostalCodeService;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Support\Facades\Validator;

class WeatherController extends Controller
{
    private Forecast $forecastService;
    private PostalCodeService $postalCodeService;

    public function __construct(Forecast $forecastService, PostalCodeService $postalCodeService)
    {
        $this->forecastService = $forecastService;
        $this->postalCodeService = $postalCodeService;
    }

    public function show(): View
    {
        $postalCode = Auth::user()->postal_code;
        
        \Log::info('Postal Code:', ['postal_code' => $postalCode]);

        if (is_null($postalCode)) {
            $error = 'Nenhum código postal encontrado para o usuário.';
            return view('weather.previsao-tempo', compact('error'));
        }

        // Validação do formato do CEP
        $validator = Validator::make(['cep' => $postalCode], [
            'cep' => ['required', 'regex:/^\d{5}-?\d{3}$/'],
        ]);

        if ($validator->fails()) {
            $error = 'Formato de CEP inválido.';
            return view('weather.previsao-tempo', compact('error'));
        }

        // Obter a cidade a partir do CEP
        $cityName = $this->postalCodeService->getCityFromPostalCode($postalCode);
        
        // Logar o nome da cidade obtida
        \Log::info('City Name Obtained:', ['city_name' => $cityName]);

        if (empty($cityName)) {
            $error = 'CEP inválido ou não encontrado.';
            return view('weather.previsao-tempo', compact('error'));
        }

        // Consultar a WeatherAPI com o nome da cidade
        $weatherData = $this->forecastService->get($cityName, 3);

        if ($weatherData->isEmpty() || $weatherData->contains('error', true)) {
            $error = 'Não foi possível obter as informações de previsão do tempo. Tente um CEP mais específico ou uma cidade.';
            return view('weather.previsao-tempo', compact('error'));
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
}
