<?php

namespace App\Services\PostalCode;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PostalCodeService
{
    protected string $baseUrl;

    public function __construct()
    {
        $this->baseUrl = 'https://brasilapi.com.br/api/cep/v1/';
    }

    /**
     * Obtém informações do CEP a partir da BrasilAPI.
     *
     * @param string $postalCode
     * @return array|null
     */
    public function getPostalCodeInfo(string $postalCode): ?array
    {
        // Remover caracteres não numéricos
        $postalCode = preg_replace('/\D/', '', $postalCode);

        // Logar o CEP processado
        Log::info("Consultando CEP na BrasilAPI:", ['processed_cep' => $postalCode]);

        // Verificar se o CEP está no cache (por 1 dia)
        return Cache::remember("cep_{$postalCode}", now()->addDay(), function () use ($postalCode) {
            try {
                $response = Http::timeout(5)->get("{$this->baseUrl}{$postalCode}");

                // Logar o status da resposta
                Log::info("Resposta da BrasilAPI:", ['status' => $response->status(), 'body' => $response->body()]);

                if ($response->successful()) {
                    return $response->json();
                }

                if ($response->status() === 404) {
                    // CEP não encontrado
                    return null;
                }

                // Outros erros
                Log::error("Erro ao consultar CEP {$postalCode}: " . $response->body());
                return null;
            } catch (\Exception $e) {
                // Logar o erro para análise
                Log::error("Exceção ao consultar CEP {$postalCode}: " . $e->getMessage());
                return null;
            }
        });
    }

    /**
     * Obtém o nome da cidade a partir do CEP.
     *
     * @param string $postalCode
     * @return string
     */
    public function getCityFromPostalCode(string $postalCode): string
    {
        $info = $this->getPostalCodeInfo($postalCode);

        // Logar os dados recebidos
        Log::info('Dados obtidos do CEP:', ['info' => $info]);

        return $info['city'] ?? '';
    }
}
