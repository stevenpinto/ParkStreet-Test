<?php

namespace App\Controller;

use App\Entity\Product;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProductsController extends AbstractController
{
    /**
     * This is the main method to get all products data
     */
    public function index(Request $request): JsonResponse
    {
        $repository = $this->getDoctrine()->getRepository( Product::class );

        $clientId = $request->query->get('clientId');

        $products = $repository->findByFilters($clientId);
        return $this->json($products);
    }
}
