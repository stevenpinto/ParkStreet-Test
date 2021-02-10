<?php

namespace App\Controller;

use App\Entity\Client;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ClientsController extends AbstractController
{
    /**
     * This is the main method to get all clients data
     */
    public function index(Request $request): JsonResponse
    {
        $clients = $this->getDoctrine()->getRepository( Client::class )->findByFilters();
        return $this->json($clients);
    }
}
