<?php

namespace App\Controller;

use App\Service\DataValidationService;
use App\Service\ProductService;
use App\Validator\CalculatePriceValidator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PurchaseController extends AbstractController
{
    private DataValidationService $dataValidationService;
    private ProductService $productService;

    public function __construct(
        DataValidationService $dataValidationService,
        ProductService $productService
    )
    {
        $this->dataValidationService = $dataValidationService;
        $this->productService = $productService;
    }

    #[Route("/calculate-price", methods: ["POST"])]
    public function calculatePrice(Request $request)
    {
        $jsonData = json_decode($request->getContent(), true);

        $errors = $this->dataValidationService->validateData($jsonData, new CalculatePriceValidator());

        if (!empty($errors)) {
            return $this->json(['errors' => $errors], Response::HTTP_BAD_REQUEST);
        }

        $product = $this->productService->getProduct($jsonData['product']);

        if (empty($product)) {
            return $this->json(['errors' => ['text' => 'Product does not exist']], Response::HTTP_BAD_REQUEST);
        }

        $price = $this->productService->getPurchasePrice($jsonData, $product);

        return new Response($price, Response::HTTP_OK);
    }
}