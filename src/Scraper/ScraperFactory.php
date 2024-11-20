<?php

namespace App\Factory;

use App\Scraper\CategoryScraperInterface;
use App\Scraper\ScraperType;

class ScraperFactory
{
    public function __construct(private iterable $scrapers) {}

    public function getScraper(ScraperType $type): CategoryScraperInterface
    {
        if (!isset($this->scrapers[$type->value])) {
            throw new \InvalidArgumentException("No scraper registered for type: {$type->value}");
        }

        return $this->scrapers[$type->value];
    }
}
