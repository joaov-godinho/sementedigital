<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EForecast extends Model
{
    protected $fillable = [
        'date', 'maxtemp_c', 'mintemp_c', 'avgtemp_c',
        'maxwind_kph', 'totalprecip_mm', 'avghumidity', 'daily_chance_of_rain'
    ];
}
