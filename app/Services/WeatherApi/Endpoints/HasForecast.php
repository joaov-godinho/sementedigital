<?php

namespace App\Services\WeatherApi\Endpoints;

trait HasForecast
{
    public function forecast()
    {
        return new Forecast();
    }
}