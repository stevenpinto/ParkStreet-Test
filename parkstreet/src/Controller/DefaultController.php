<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DefaultController extends AbstractController
{

    public function index(Request $request): JsonResponse
    {
        return $this->json([
            'version' => '0.1.0',
            'GET' => '/invoices/report',
            'params' => [
                'toDate' => 'date',
                'fromDate' => 'date',
                'clientId' => 'string',
                'productId' => 'string',
            ]
        ]);
    }
}
