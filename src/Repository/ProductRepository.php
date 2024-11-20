<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function save(Product $product, bool $flush = false): void
    {
        $this->getEntityManager()->persist($product);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function saveMany(array $products): void
    {
        $batchSize = 100;
        $count = 0;

        foreach ($products as $product) {
            $this->getEntityManager()->persist($product);
            $count++;
            
            if ($count % $batchSize === 0) {
                $this->getEntityManager()->flush();
                $this->getEntityManager()->clear();
            }
        }

        $this->getEntityManager()->flush();
        $this->getEntityManager()->clear();
    }
} 