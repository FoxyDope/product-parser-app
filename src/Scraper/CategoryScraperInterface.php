<?php

namespace App\Scraper;

interface CategoryScraperInterface
{
    public function getType(): ScraperType;

    /**
     * @return ScrapedProductDTO[]
     */
    public function scrapeCategory(string $category, int $pages): array;
}
