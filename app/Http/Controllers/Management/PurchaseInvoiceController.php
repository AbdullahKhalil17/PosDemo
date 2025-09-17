<?php

namespace App\Http\Controllers\Management;

use App\Models\Stores;
use App\Models\Products;
use Illuminate\Http\Request;
use App\Models\PurchaseInvoice;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\PurchaseInvoiceDetails;
use App\Models\Stocks;
use Illuminate\Database\Events\TransactionBeginning;

class PurchaseInvoiceController extends Controller
{
    public function index()
    {
      $store = Stores::select('id', 'name')->get();
      return view('purchase-invoice.index', compact('store'));
    }


    public function searchProduct(Request $request)
    {
        $barcode = $request->input('barcode');

        $product = Products::where('barcode', $barcode)
        ->select('id', 'name', 'barcode', 'purchase_price', 'sale_price', 'unit')
        ->first();

        if(!$product) {
          return response()->json([
            'error' => false,
            'message' => 'المنتج غير متوفر فى الوقت الحالي',
          ], 404);
        }

        $data = [
          'detailsProduct' => [
            'id' => $product->id,
            'product_name' => $product->name,
            'barcode' => $product->barcode,
            'purchase_price' => $product->purchase_price,
            'sale_price' => $product->sale_price,
            'unit' => $product->unit,
          ],
        ];

        return response()->json([
          'status' => true,
          'data' => $data
        ], 202);
    }

    public function store(Request $request)
    {
      $request->validate([
        'invoice_date' => 'required|date',
        'invoice_number' => 'required|string|unique:purchase_invoice,invoice_number',
        'store_id' => 'required|exists:stores,id',
        'note' => 'nullable|string|max:500',

        'product_id' => 'required|array|min:1',
        'quantity' => 'required|array|min:1',
        'quantity.*' => 'required|numeric|min:1',
        'sellingPrice' => 'required|array|min:1',
        'sellingPrice.*' => 'required|numeric|min:0',
        'costPrice'=> 'required|array|min:1',
        'costPrice.*' => 'required|numeric|min:0',
        'totalValue' => 'required|array|min:1',
        'totalValue.*' => 'required|numeric|min:0',
        ]);
      try {
        DB::beginTransaction();
        $invoice = PurchaseInvoice::create([
          'store_id' => $request->input('store_id'),
          'invoice_date' => $request->input('invoice_date'),
          'user_id' => auth()->id(),
          'invoice_number' => $request->input('invoice_number'),
          'total_amount' => 0,
          'status' => 'confirmed',
          'note' => $request->input('note'),
        ]);
        $productIds = $request->input('product_id');
        $quantities = $request->input('quantity');
        $sellingPrices = $request->input('sellingPrice');
        $costPrices = $request->input('costPrice');
        $totalValues = $request->input('totalValue');

        $totalInvoiceAmount = 0;

        foreach($productIds as $index => $productId) {
          $unitPrice = $costPrices[$index];
          $total = $totalValues[$index];
          $item = PurchaseInvoiceDetails::create([
            'purchase_invoice_id' => $invoice->id,
            'product_id' => $productId,
            'quantity' => $quantities[$index],
            'unit_price' => $unitPrice,
            'total' => $total,
          ]);
          Stocks::create([
              'product_id' => $productId,
              'store_id'   => $request->input('store_id'),
              'quantity'   => $quantities[$index],
          ]);
          $totalInvoiceAmount += $total;
        }

        $invoice->total_amount = $totalInvoiceAmount;
        $invoice->save();

        DB::commit();
        return redirect()->route('purchaseInvoice.index')->with('success', 'تم حفظ الفاتورة بنجاح');
      } catch(\Exception $e) {
        DB::rollback();
        return redirect()->route('purchaseInvoice.index')->with('error', $e->getMessage());
      }     
    }


    public function reportInvoice()
    {
      $invoice = PurchaseInvoice::with('store', 'user')
        ->select('id', 'store_id', 'user_id', 'invoice_number', 'invoice_date', 'total_amount')->get();
      return view('purchase-invoice.purchase-invoice', compact('invoice'));
    }
}
