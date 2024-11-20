<?php

namespace App\DTO;

class ScrapeCategoryDTO
{
    public function __construct(
        public readonly string $scraperType,
        public readonly string $category,
        public readonly int $pages,
    ) {}
}
