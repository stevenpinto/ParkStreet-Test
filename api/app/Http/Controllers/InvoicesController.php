<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvoicesController extends Controller
{
    //main query that filters invoice data based
    //on date, client and product filters
    public function index(Request $request)
    {
        //get requested filters
        $relativeDate = $request->input('relative_date');
        $clientId = $request->input('client_id');
        $productId = $request->input('product_id');

        //connects to table invoices
        $invoices = DB::table('invoices')
            ->join('invoicelineitems', 'invoices.invoice_num', '=', 'invoicelineitems.invoice_num')
            ->join('products', 'products.product_id', '=', 'invoicelineitems.product_id')
            ->select('invoices.invoice_num', 'invoices.invoice_date', 'products.product_description', 'invoicelineitems.qty', 'invoicelineitems.price', DB::raw('invoicelineitems.qty * invoicelineitems.price as total'))
            ->orderBy('invoices.invoice_date');

        //if relativeDate parameter create the where clause for each type
        if ($relativeDate) {
            $currentDate = date('Y-m-d');
            switch ($relativeDate) {

                case 'last_month_to_date':
                    $previousDate = date('Y-m-d', strtotime('first day of previous month'));
                    $invoices
                        ->whereBetween('invoices.invoice_date', [$previousDate, $currentDate]);
                    break;
                case 'this_month':
                    $previousDate = date('Y-m-d', strtotime('first day of this month'));
                    $invoices
                        ->whereBetween('invoices.invoice_date', [$previousDate, $currentDate]);
                    break;
                case 'this_year':
                    $previousDate = date('Y-m-d', strtotime('first day of January'));
                    $invoices
                        ->whereBetween('invoices.invoice_date', [$previousDate, $currentDate]);
                    break;
                case 'last_year':
                    $previousDate = date('Y-m-d', strtotime('first day of last year'));
                    $invoices
                        ->whereBetween('invoices.invoice_date', [$previousDate, $currentDate]);
                    break;
            }
        }

        //If provided, retrieve invoices by client id
        if ($clientId) {
            $invoices->where('invoices.client_id', $clientId);
        }

        //If provided, retrieve invoices by product id
        if ($productId) {
            $invoices->where('products.product_id', $productId);
        }

        return response()->json($invoices->get());
    }
    
    //Returns all the products filtered by client id
    public function getProductsByClient(Request $request)
    {
        $clientId = $request->input('client_id');

        if (!$clientId) {
            return;
        }

        $products = DB::table('products')
            ->select('product_description', 'product_id')
            ->where('client_id', $clientId);

        return response()->json($products->get());
    }

    //Returns all the clients from the database
    public function getClients(Request $request)
    {
        $clients = DB::table('clients')
            ->select('client_id');

        return response()->json($clients->get());
    }
}
