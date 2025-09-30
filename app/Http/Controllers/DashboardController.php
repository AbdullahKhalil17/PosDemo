<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SalesInvoice;
use App\Models\PurchaseInvoice;

class DashboardController extends Controller
{
    public function index()
    {
        $today = now()->toDateString();
        $dailySales = SalesInvoice::whereDate('invoice_date', $today)->sum('total_invoice');
        $dailyPurchases = PurchaseInvoice::whereDate('invoice_date', $today)->sum('total_amount');



        $allInvoices = SalesInvoice::with('user')
          ->where('payment_method', 'visa')
          ->where('payment_status', 'unpaid')
          ->orderBy('invoice_date', 'desc')
          ->orderBy('id', 'desc')
          ->limit(10)
          ->get();


        return view('welcome', compact('dailySales', 'dailyPurchases', 'allInvoices'));
    }
}
