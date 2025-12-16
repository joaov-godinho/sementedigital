<?php

namespace App\Http\Controllers;

use App\Services\Market\CepeaScraperService;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class MarketController extends Controller
{
    public function __construct(
        private readonly CepeaScraperService $scraperService
    ) {}

    public function index(): View
    {
        // Cache por 12 horas para evitar bloqueio do CEPEA
        $commodities = Cache::remember('market_prices_v1', 43200, function () {
            return $this->scraperService->getAllPrices();
        });

        $error = $commodities->isEmpty() ? 'Sistema temporariamente indisponível (Fonte: CEPEA).' : null;

        // Nota: Certifique-se que o arquivo resources/views/weather/mercado.blade.php existe
        return view('mercado', compact('commodities', 'error'));
    }
}