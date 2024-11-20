<?php

namespace App\Scraper;

use App\DTO\ScrapedProductDTO;
use App\Service\ProductService;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class EbayCategoryScraper implements CategoryScraperInterface
{
    public function __construct(
        private readonly HttpClientInterface $httpClient,
        private readonly ProductService $productService,
        private readonly string $baseUrl
    ) {}

    public function getType(): ScraperType
    {
        return ScraperType::EBAY;
    }

    /**
     * @return ScrapedProductDTO[]
     */
    public function scrapeCategory(string $category, int $maxPages = 3): array
    {
        $baseUrl = $this->baseUrl . urlencode($category);
        $allProducts = [];

        for ($page = 1; $page <= $maxPages; $page++) {
            $url = $baseUrl . "&_pgn=$page";
            $html = $this->fetchPage($url);
            /** @var ScrapedProductDTO[] $pageProducts */
            $pageProducts = $this->parseProducts($html);
            $allProducts = [...$allProducts, ...$pageProducts];
        }

        return $allProducts;
    }

    private function fetchPage(string $url): string
    {
        $response = $this->httpClient->request('GET', $url, [
            'headers' => [
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)',
            ],
        ]);

        if (200 !== $response->getStatusCode()) {
            throw new \RuntimeException("Failed to fetch URL: $url. HTTP Code: " . $response->getStatusCode());
        }

        return $response->getContent();
    }

    /**
     * @return ScrapedProductDTO[]
     */
    private function parseProducts(string $html): array
    {
        $crawler = new Crawler($html);
        return $crawler
            ->filter('ul.srp-results.srp-list')->first()
            ->filter('li.s-item')->each(function (Crawler $node) {
                return new ScrapedProductDTO(
                    name: $node->filter('.s-item__title')->count() ?
                        $node->filter('.s-item__title')->text() : 'N/A',
                    price: $this->normalizePrice(
                        $node->filter('.s-item__price')->count() ?
                            $node->filter('.s-item__price')->text() : '0'
                    ),
                    productUrl: $node->filter('.s-item__link')->count() ?
                        $node->filter('.s-item__link')->attr('href') : 'N/A',
                    imageUrl: $node->filter('.s-item__image-wrapper img')->count() ?
                        $node->filter('.s-item__image-wrapper img')->attr('src') : ''
                );
            });
    }

    private function normalizePrice(string $price): string
    {
        return preg_replace('/,/', '', preg_replace('/^\$([\d,]+\.\d+).*/', '$1', $price));
    }
}
