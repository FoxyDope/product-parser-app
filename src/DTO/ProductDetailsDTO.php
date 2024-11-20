<?php

namespace App\DTO;

use Symfony\Component\Serializer\Annotation\Groups;

class ProductDetailsDTO
{
    public function __construct(
        #[Groups(['product_list'])]
        public readonly int $id,

        #[Groups(['product_list'])]
        public readonly string $name,

        #[Groups(['product_list'])]
        public readonly float $price,

        #[Groups(['product_list'])]
        public readonly string $imageUrl,

        #[Groups(['product_list'])]
        public readonly string $productUrl,

        #[Groups(['product_list'])]
        public readonly \DateTimeImmutable $createdAt,
    ) {}
}
