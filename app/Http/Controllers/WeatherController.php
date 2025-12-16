<?php

namespace App\Http\Controllers;

use App\Services\WeatherApi\Endpoints\Forecast;
use App\Services\PostalCode\PostalCodeService;
use App\DTO\WeatherDTO; // Certifique-se de ter criado esse DTO no passo anterior
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache; // <--- Importação correta
use Illuminate\Support\Str;

class WeatherController extends Controller
{
    public function __construct(
        private readonly Forecast $forecastService,
        private readonly PostalCodeService $postalCodeService
    ) {}

    public function show(): View
    {
        $user = Auth::user();
        $postalCode = $user->postal_code;

        // 1. Validações básicas (Fail Fast)
        if (empty($postalCode)) {
            return view('weather.previsao-tempo', ['error' => 'Cadastre seu CEP no perfil.']);
        }

        try {
            // 2. Busca a Cidade (Isso é rápido, geralmente banco local, não precisa de cache agressivo)
            $cityName = $this->postalCodeService->getCityFromPostalCode($postalCode);

            if (empty($cityName)) {
                throw new \Exception('Cidade não encontrada para este CEP.');
            }

            // --- AQUI ENTRA O CACHE (O PULO DO GATO) ---
            
            // Criamos uma chave única para essa cidade (ex: "weather_videira-sc")
            $cacheKey = 'weather_' . Str::slug($cityName);

            // O Cache::remember faz 3 coisas:
            // 1. Tenta achar a chave no Redis.
            // 2. Se achar, devolve a variável $forecastDays direto (sem rodar o código de dentro).
            // 3. Se NÃO achar, roda a função, busca na API, salva no Redis por 6 horas (21600s) e devolve.
            $forecastDays = Cache::remember($cacheKey, 60 * 60 * 6, function () use ($cityName) {
                
                Log::info("Cache MISS: Buscando dados frescos na API para {$cityName}");
                
                return $this->forecastService->get($cityName, 3);
            });

            // --- FIM DO CACHE ---

            return view('weather.previsao-tempo', compact('forecastDays'));

        } catch (\Exception $e) {
            Log::error('Erro no WeatherController: ' . $e->getMessage());
            // Em caso de erro (ex: API caiu), mostramos a mensagem amigável
            return view('weather.previsao-tempo', ['error' => 'Serviço temporariamente indisponível.']);
        }
    }
}