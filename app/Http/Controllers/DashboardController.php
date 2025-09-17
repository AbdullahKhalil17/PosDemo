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
        return view('welcome', compact('dailySales', 'dailyPurchases'));
    }
}
