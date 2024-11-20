<?php

namespace App\MessageHandler;

use App\Message\ProductWriteMessage;
use App\Service\ProductService;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class ProductWriteMessageHandler
{
    public function __construct(
        private readonly ProductService $productService,
    ) {}

    public function __invoke(ProductWriteMessage $message): void
    {
        $this->productService->writeProductsToCsv(
            $message->getProducts(),
            $message->getCategory(),
            $message->getSource()
        );
    }
}
