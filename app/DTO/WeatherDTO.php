<?php

namespace App\DTO;

class WeatherDTO
{
    public function __construct(
        public readonly string $date,
        public readonly string $condition,
        public readonly string $iconUrl,
        public readonly float $minTemp,
        public readonly float $maxTemp,
        public readonly float $avgTemp,
        public readonly float $maxWind,
        public readonly float $totalPrecip,
        public readonly int $avgHumidity,
        public readonly int $chanceOfRain
    ) {}

    public static function fromApi(array $data): self
    {
        // Garante URL completa do ícone (HTTPS)
        $icon = $data['day']['condition']['icon'] ?? '';
        if (str_starts_with($icon, '//')) {
            $icon = 'https:' . $icon;
        }

        return new self(
            date: date('d/m/Y', strtotime($data['date'] ?? 'now')),
            condition: $data['day']['condition']['text'] ?? 'N/A',
            iconUrl: $icon,
            minTemp: $data['day']['mintemp_c'] ?? 0,
            maxTemp: $data['day']['maxtemp_c'] ?? 0,
            avgTemp: $data['day']['avgtemp_c'] ?? 0,
            maxWind: $data['day']['maxwind_kph'] ?? 0,
            totalPrecip: $data['day']['totalprecip_mm'] ?? 0,
            avgHumidity: $data['day']['avghumidity'] ?? 0,
            chanceOfRain: $data['day']['daily_chance_of_rain'] ?? 0
        );
    }
}