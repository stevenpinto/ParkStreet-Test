<?php

namespace App\Controller;

use App\Entity\ViewInvoicesReport;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class InvoicesReportController extends AbstractController
{
    /**
     * This is the main method to get all invoices data
     */
    public function index(Request $request): JsonResponse
    {
        $repository = $this->getDoctrine()->getRepository( ViewInvoicesReport::class );

        $dateTo = $request->query->has('dateTo') ? $request->query->get('dateTo') : date("Y-m-d");
        $dateFrom = $request->query->get('dateFrom');
        $clientId = $request->query->get('clientId');
        $productId = $request->query->get('productId');

        $invoices = $repository->findByFilters($dateTo, $dateFrom, $clientId, $productId);
        return $this->json($invoices);
    }
}
