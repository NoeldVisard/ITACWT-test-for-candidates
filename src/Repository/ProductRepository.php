<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ProductRepository extends ServiceEntityRepository
{
    private $products = [
        1 => [
            'id' => 1,
            'name' => 'Iphone',
            'price' => 100
        ],
        2 => [
            'id' => 2,
            'name' => 'Headphones',
            'price' => 20
        ],
        3 => [
            'id' => 3,
            'name' => 'Case',
            'price' => 10
        ]
    ];

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function findProductById(int $productId): array
    {
        if (isset($this->products[$productId])) {
            return $this->products[$productId];
        }

        return [];
    }
}