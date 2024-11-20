<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    public ?int $id = null;

    public function __construct(
        #[ORM\Column(length: 255)]
        public readonly string $name,

        #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
        public readonly string $price,

        #[ORM\Column(length: 255)]
        public readonly string $imageUrl,

        #[ORM\Column(length: 1024)]
        public readonly string $productUrl,

        #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
        public readonly \DateTimeImmutable $createdAt = new \DateTimeImmutable(),
    ) {}
}
