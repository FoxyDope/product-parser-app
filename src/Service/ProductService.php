<?php

namespace App\Service;

use App\DTO\ProductDetailsDTO;
use App\DTO\ScrapedProductDTO;
use App\Entity\Product;
use App\Message\ProductWriteMessage;
use App\Repository\ProductRepository;
use Symfony\Component\Messenger\MessageBusInterface;

class ProductService
{
    public function __construct(
        private readonly ProductRepository $productRepository,
        private readonly MessageBusInterface $messageBus,
        private readonly string $csvDirectory,
    ) {}

    public function getAllProducts(): array
    {
        $products = $this->productRepository->findAll();

        return array_map(
            fn(Product $product) => new ProductDetailsDTO(
                id: $product->id,
                name: $product->name,
                price: $product->price,
                imageUrl: $product->imageUrl,
                productUrl: $product->productUrl,
                createdAt: $product->createdAt,
            ),
            $products
        );
    }

    /**
     * @param ScrapedProductDTO[] $scrapedProducts
     */
    public function saveScrapedProducts(array $scrapedProducts, string $category, string $source): void
    {
        $products = array_map(
            fn(ScrapedProductDTO $dto) => new Product(
                name: $dto->name,
                price: $dto->price,
                imageUrl: $dto->imageUrl,
                productUrl: $dto->productUrl,
            ),
            $scrapedProducts
        );

        $this->productRepository->saveMany($products);

        // Dispatch message for async CSV writing
        $this->messageBus->dispatch(
            new ProductWriteMessage($scrapedProducts, $category, $source)
        );
    }

    /**
     * @param ScrapedProductDTO[] $products
     */
    public function writeProductsToCsv(array $products, string $category, string $source): void
    {
        $filename = sprintf(
            '%s/%s_%s_%s.csv',
            $this->csvDirectory,
            $source,
            $category,
            date('Y-m-d_H-i-s')
        );

        $handle = fopen($filename, 'w');

        // Write headers
        fputcsv($handle, ['Name', 'Price', 'Product URL', 'Image URL']);

        // Write product data
        foreach ($products as $product) {
            fputcsv($handle, [
                $product->name,
                $product->price,
                $product->productUrl,
                $product->imageUrl,
            ]);
        }

        fclose($handle);
    }
}
