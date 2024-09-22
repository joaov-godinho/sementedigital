<?php

namespace App\Console\Commands;

use App\Services\WeatherApi\WeatherApiService;
use Illuminate\Console\Command;

class Playground extends Command
{
    protected $signature = 'app:play';

    protected $description = 'Playground Command';

    public function handle(): int    
    {
        $service = new WeatherApiService();
        $forecast = $service->forecast()->get('89560000', 1);
        dump($forecast);

        return Command::SUCCESS;
    }
}
