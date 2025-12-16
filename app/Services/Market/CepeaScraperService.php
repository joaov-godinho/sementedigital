<?php

namespace App\Services\Market;

use App\DTO\CommodityDTO;
use Illuminate\Support\Facades\Http;
use Symfony\Component\DomCrawler\Crawler;
use Illuminate\Support\Facades\Log;

class CepeaScraperService
{
    // URLs dos Indicadores (Hardcoded conforme site do CEPEA)
    private const PRODUTOS = [
        'milho' => [
            'url' => 'https://www.cepea.esalq.usp.br/br/indicador/milho.aspx',
            'nome' => 'Milho (Saca 60kg)',
            'cidade' => 'Campinas/SP'
        ],
        'soja' => [
            'url' => 'https://www.cepea.esalq.usp.br/br/indicador/soja.aspx',
            'nome' => 'Soja (Saca 60kg)',
            'cidade' => 'Paranaguá/PR'
        ],
        'boi' => [
            'url' => 'https://www.cepea.esalq.usp.br/br/indicador/boi-gordo.aspx',
            'nome' => 'Boi Gordo (Arroba)',
            'cidade' => 'São Paulo/SP'
        ],
        'cafe' => [
            'url' => 'https://www.cepea.esalq.usp.br/br/indicador/cafe.aspx',
            'nome' => 'Café Arábica (Saca 60kg)',
            'cidade' => 'São Paulo/SP'
        ],
    ];

    /**
     * Retorna todos os preços de uma vez.
     * @return \Illuminate\Support\Collection<CommodityDTO>
     */
    public function getAllPrices()
    {
        $results = collect();

        foreach (self::PRODUTOS as $key => $config) {
            $dto = $this->scrapeCommodity($config['url'], $config['nome'], $config['cidade']);
            if ($dto) {
                $results->push($dto);
            }
        }

        return $results;
    }

    private function scrapeCommodity(string $url, string $name, string $city): ?CommodityDTO
    {
        try {
            $response = Http::withHeaders([
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36'
            ])->timeout(10)->get($url);

            if ($response->failed()) {
                return null;
            }

            $crawler = new Crawler($response->body());

            // O padrão do site do CEPEA é sempre ter uma tabela com id "imagenet-indicador1"
            $tableRow = $crawler->filter('#imagenet-indicador1 tbody tr')->first();

            if ($tableRow->count() === 0) {
                return null;
            }

            // Coluna 1: Data, Coluna 2: Preço
            $date = trim($tableRow->filter('td')->eq(0)->text());
            $price = trim($tableRow->filter('td')->eq(1)->text());

            return new CommodityDTO(
                name: $name,
                price: "R$ " . $price,
                unit: 'À vista', // Simplifiquei aqui
                city: $city,
                date: $date,
                variation: 'N/A'
            );

        } catch (\Exception $e) {
            Log::error("Erro scraping {$name}: " . $e->getMessage());
            return null;
        }
    }
}