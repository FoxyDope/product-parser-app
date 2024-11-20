<?php

namespace App\Controller;

use App\Service\ProductService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class ProductController extends AbstractController
{
    public function __construct(
        private readonly ProductService $productService,
    ) {}

    #[Route('/api/products', name: 'api_products', methods: ['GET'])]
    public function index(): JsonResponse
    {
        $products = $this->productService->getAllProducts();

        return $this->json($products, context: ['groups' => ['product_list']]);
    }
}
