<?php

namespace App\Message;

class ProductWriteMessage
{
    public function __construct(
        private readonly array $products,
        private readonly string $category,
        private readonly string $source
    ) {}

    public function getProducts(): array
    {
        return $this->products;
    }

    public function getCategory(): string
    {
        return $this->category;
    }

    public function getSource(): string
    {
        return $this->source;
    }
}
