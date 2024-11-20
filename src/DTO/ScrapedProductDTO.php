<?php

namespace App\DTO;

class ScrapedProductDTO
{
    public function __construct(
        public readonly string $name,
        public readonly string $price,
        public readonly string $imageUrl,
        public readonly string $productUrl,
    ) {}
}
