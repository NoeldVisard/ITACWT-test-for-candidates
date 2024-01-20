<?php

namespace App\Service;

use App\Repository\ProductRepository;

class ProductService
{
    private ProductRepository $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function getProduct($productId): array
    {
        return $this->productRepository->findProductById($productId);
    }

}