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

    public function getPurchasePrice($data, $product): float
    {
        if (isset($data['couponCode'])) {
            $discount = $this->getDiscount($data['couponCode']);
        } else {
            $discount = [];
        }

        $tax = $this->getTax($data['taxNumber']);

        return $this->getPrice($product['price'], $discount, $tax);
    }

    private function getTax(string $taxNumber): ?float
    {
        $countryCode = substr($taxNumber, 0, 2);

        return match ($countryCode) {
            'DE' => 1.19,
            'IT' => 1.22,
            'GR' => 1.24,
            'FR' => 1.2
        };
    }

    /**
     * Метод возвращает разную скидку для разных купонов.
     * Если купон с приставкой 'DI', то фиксированная скидка от суммы покупки.
     * Если купон с приставкой 'D' - процент от суммы покупки.
     * @param string $couponCode
     * @return array
     */
    private function getDiscount(string $couponCode): array
    {
        preg_match('/^D(I)?(\d+)$/', $couponCode, $matches);
        $discount = $matches[2];

        if (isset($matches[1]) && $matches[1] === 'I') {
            return [
                'fixed' => $discount
            ];
        } else {
            return [
                'percentage' => $discount
            ];
        }
    }

    private function getPrice(int $productPrice, array $discount, float $tax): float
    {
        if (isset($discount['fixed'])) {
            return ($productPrice - $discount['fixed']) * $tax;
        } elseif (isset($discount['percentage'])) {
            return ($productPrice * (100 - $discount['percentage']) / 100) * $tax;
        }

        return $productPrice * $tax;
    }

}