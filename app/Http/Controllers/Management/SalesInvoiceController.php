<?php

namespace App\Http\Controllers\Management;

use Carbon\Carbon;
use App\Models\Shifts;
use App\Models\Stocks;
use App\Models\Stores;
use App\Models\Products;
use App\Models\SalesInvoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\SalesInvoiceDetails;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Traits\NetworkHelperTrait;
use Illuminate\Support\Facades\Storage;

class SalesInvoiceController extends Controller
{
    use NetworkHelperTrait;
    
    public function index()
    {
      $store = Stores::select('id', 'name')->get();
      $invoiceNumber = $this->generateInvoiceNumber();

      return view('sales-invoice.index', compact('store', 'invoiceNumber'));
    }


    private function generateInvoiceNumber()
      {
          do {
              $invoiceNumber = rand(1000, 999999);
          } while (SalesInvoice::where('invoice_number', $invoiceNumber)->exists());

          return $invoiceNumber;
      }


    public function searchProduct(Request $request)
    {
        $barcode = $request->input('barcode');

        $user = Auth::user();

        $openShift = Shifts::where('user_id', $user->id)
            ->whereNull('end_time')
            ->first();

        $stock = Stocks::where('product_id', Products::where('barcode', $barcode)->value('id'))
            ->where('store_id', $openShift->store_id)
            ->with(['product' => function ($query) {
                $query->select('id', 'name', 'sale_price', 'purchase_price', 'barcode');
            }])
            ->select('product_id', 'store_id', 'quantity')
            ->first();

        if (!$stock) {
            return response()->json([
                'error' => true,
                'message' => 'لا يوجد ستوك لهذا المنتج في فرعك'
            ]);
        }

        $totalCost = $stock->quantity * $stock->product->purchase_price;

        $data = [
            'prodctID' => $stock->product_id,
            'storeID' => $stock->store_id,
            'quantity'  => $stock->quantity,
            'product_name' => $stock->product->name,
            'sale_price' => $stock->product->sale_price,
            'purchase_price' => $stock->product->purchase_price,
            'barcode' => $stock->product->barcode,
            'total_cost' => $totalCost,
        ];

        return response()->json([
            'status' => true,
            'data' => $data,
        ], 202);
    }


    public function updateStock(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|numeric|min:1',
        ]);

        $user = Auth::user();
        $openShift = Shifts::where('user_id', $user->id)->whereNull('end_time')->first();

        $stock = Stocks::where('product_id', $request->product_id)
            ->where('store_id', $openShift->store_id)
            ->first();

        if (!$stock) {
            return response()->json(['error' => true, 'message' => 'المنتج غير موجود في المخزن']);
        }

        if($stock->quantity < $request->quantity) {
            return response()->json(['error' => true, 'message' => 'الكمية غير كافية']);
        }

        $stock->quantity -= $request->quantity;
        $stock->save();

        return response()->json(['status' => true, 'quantity' => $stock->quantity]);
    }


    public function restoreStock(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|numeric|min:1',
        ]);

        $user = Auth::user();
        $openShift = Shifts::where('user_id', $user->id)->whereNull('end_time')->first();

        $stock = Stocks::where('product_id', $request->product_id)
            ->where('store_id', $openShift->store_id)
            ->first();

        if(!$stock) return response()->json(['error'=>true, 'message'=>'المنتج غير موجود']);

        $stock->quantity += $request->quantity;
        $stock->save();

        return response()->json(['status'=>true, 'quantity'=>$stock->quantity]);
    }



    public function store(Request $request)
    {
        $request->validate([
            'store_id' => 'required|exists:stores,id',
            'invoice_number' => 'required|integer|unique:sales_invoice,invoice_number',
            'invoice_date'=> 'required|date',
            'total_invoice' => 'required|numeric|min:0',
            'note' => 'nullable|string|max:500',
            'product_id' => 'required|array|min:1',
            'quantity' => 'required|array|min:1',
            'quantity.*' => 'required|numeric|min:1',
            'sellingPrice' => 'required|array|min:1',
            'sellingPrice.*' => 'required|numeric|min:0',
        ]);

        // check connect internet
        if ($this->isConnected()) {
            try {
                DB::beginTransaction();

                $invoice = SalesInvoice::create([
                    'user_id' => auth()->id(),
                    'store_id' => $request->store_id,
                    'invoice_number'=> $request->invoice_number,
                    'invoice_date' => $request->invoice_date,
                    'total_invoice' => $request->total_invoice,
                    'note' => $request->note,
                ]);

                foreach ($request->product_id as $i => $productId) {
                    $quantity = $request->quantity[$i];
                    $price = $request->sellingPrice[$i];
                    $total = $quantity * $price;

                    SalesInvoiceDetails::create([
                        'invoice_id' => $invoice->id,
                        'product_id' => $productId,
                        'quantity' => $quantity,
                        'price' => $price,
                        'total' => $total,
                    ]);
                    // $stocks = Stocks::where('product_id', $productId)
                    //       ->where('store_id', $request->store_id)
                    //       ->where('quantity', '>', 0)
                    //       ->orderBy('id') 
                    //       ->get();

                    //   foreach ($stocks as $stock) {
                    //       if ($stock->quantity >= $quantity) {
                    //           $stock->quantity -= $quantity;
                    //           $stock->save();
                    //           $quantity = 0;
                    //       } else {
                    //           $quantity -= $stock->quantity;
                    //           $stock->quantity = 0;
                    //           $stock->save();
                    //       }
                    //   }
                    //   if ($quantity > 0) {
                    //       DB::rollBack();
                    //       return back()->with('error', 'الكمية غير كافية للمنتج.');
                    //   }
                }

                $shift = Shifts::where('user_id', auth()->id())
                  ->where('store_id', $request->store_id)
                  ->whereNull('end_time')
                  ->first();

                  if ($shift) {
                      $shift->actual_balance += $invoice->total_invoice;
                      $shift->save();
                  }

                DB::commit();
                return back()->with('success', 'تم حفظ الفاتورة بنجاح.');

            } catch (\Exception $e) {
                DB::rollBack();
                return back()->with('error', 'حدث خطأ أثناء حفظ الفاتورة: '.$e->getMessage());
            }
        } else {
            $data = $request->all();
            $data['user_id'] = auth()->id();
            $data['created_at'] = now();

            $path = 'offline_invoices/offline_invoices.json';
            $invoices = [];
            if (Storage::exists($path)) {
                $invoices = json_decode(Storage::get($path), true);
            }
            $invoices[] = $data;
            Storage::put($path, json_encode($invoices, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE));

            return back()->with('warning', 'لا يوجد اتصال. تم حفظ الفاتورة محليًا وسيتم رفعها عند عودة الإنترنت.');
        }
    }


    public function latestPrice($id)
    {
        $product = Products::findOrFail($id);

        $data = [
          'sale_price' => $product->sale_price,
          'purchase_price' => $product->sale_price
        ];

        return response()->json([
          'status' => true,
          // 'data' => $data,
          'sale_price' => $product->sale_price,
          'purchase_price' => $product->purchase_price,
        ]);
    }


    public function report()
    {
        $invoice = SalesInvoice::with('user')
        ->select('id', 'user_id', 'invoice_number', 'invoice_date', 'total_invoice', 'note')
        ->get();
        
        return view('sales-invoice.report-invoice', compact('invoice'));
    }

}
