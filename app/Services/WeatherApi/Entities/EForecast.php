<?php

namespace App\Services\WeatherApi\Entities;

class EForecast
{  
    public string $date;
    //public array $hour;
    public float $maxtemp_c;
    public float $mintemp_c;
    public float $avgtemp_c;
    public float $maxwind_kph;
    public float $totalprecip_mm;
    public int $avghumidity;
    public int $daily_chance_of_rain;

    public function __construct(array $data)
    {
        $this->date = data_get($data, 'date', '');
        //$this->hour = data_get($data, 'hour', []);
        $this->maxtemp_c = data_get($data, 'day.maxtemp_c', 0.0);
        $this->mintemp_c = data_get($data, 'day.mintemp_c', 0.0);
        $this->avgtemp_c = data_get($data, 'day.avgtemp_c', 0.0);
        $this->maxwind_kph = data_get($data, 'day.maxwind_kph', 0.0);
        $this->totalprecip_mm = data_get($data, 'day.totalprecip_mm', 0.0);
        $this->avghumidity = data_get($data, 'day.avghumidity', 0);
        $this->daily_chance_of_rain = data_get($data, 'day.daily_chance_of_rain', 0);
    }
}
