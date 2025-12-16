<?php

namespace App\DTO;

class CommodityDTO
{
    public function __construct(
        public readonly string $name,      // Ex: Soja
        public readonly string $price,     // Ex: R$ 135,50
        public readonly string $unit,      // Ex: saca 60kg
        public readonly string $city,      // Ex: Paranaguá/PR
        public readonly string $date,      // Ex: 16/12/2025
        public readonly string $variation  // Ex: +0.5% (Opcional)
    ) {}
}