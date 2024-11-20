<?php

namespace App\Service;

use App\DTO\ScrapeCategoryDTO;
use App\Factory\ScraperFactory;
use App\Scraper\ScraperType;

class ScrapingService
{
    public function __construct(
        private readonly ScraperFactory $scraperFactory,
        private readonly ProductService $productService
    ) {}

    public function scrapeCategory(ScrapeCategoryDTO $dto): void
    {
        $scraper = $this->scraperFactory->getScraper(ScraperType::from($dto->scraperType));
        $scrapedProducts = $scraper->scrapeCategory($dto->category, $dto->pages);
        $this->productService->saveScrapedProducts($scrapedProducts, $dto->category, $scraper->getType()->value);
    }
}
