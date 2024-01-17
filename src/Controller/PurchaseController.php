<?php

namespace App\Controller;

use App\Service\DataValidationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PurchaseController extends AbstractController
{
    private DataValidationService $dataValidationService;

    public function __construct(DataValidationService $dataValidationService)
    {
        $this->dataValidationService = $dataValidationService;
    }

    #[Route("/calculate-price", methods: ["POST"])]
    public function calculatePrice(Request $request)
    {
        $jsonData = json_decode($request->getContent(), true);

        $errors = $this->dataValidationService->validateData($jsonData);

        if (!empty($errors)) {
            return $this->json(['errors' => $errors], Response::HTTP_BAD_REQUEST);
        }

        return new Response(null, Response::HTTP_OK);
    }
}