<?php

namespace App\Http\Controllers\Management;

use App\Models\Shifts;
use App\Models\SalesInvoice;
use Illuminate\Http\Request;
use App\Models\SafeTransaction;
use App\Services\PaymobService;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class PayMobController extends Controller
{
    private $paymob;

    public function __construct(PaymobService $paymob)
    {
      $this->paymob = $paymob;
    }
    
    public function getInvoiceDetalies($invoice)
    {
        $inv = SalesInvoice::with(['details' => function($query) {
          $query->select('id', 'invoice_id', 'product_id', 'quantity', 'price');
        }])->select('id', 'store_id', 'invoice_number', 'invoice_date', 'total_invoice', 'payment_method')
        ->findOrFail($invoice);

        // return response()->json([
          // 'data' => $inv,
        // ]);
        return $inv;
    }


    public function intintionPay($invoiceId)
    {
      // try{
        $inv = $this->getInvoiceDetalies($invoiceId);
        //billing data
        $biilingData = [
          'invoice_id' => $inv->id,
          'merchant_order_id' => $invoiceId,
          'first_name' => 'Abdullah',
          'last_name' => 'Khalil',
          'email' => 'k.goma959@gmail.com',
          'phone_number' => '01158968595',
          'city' => 'Cairo',
          'country' => 'EG',
        ];

        $invoiceItem = [];
        $totalInvoice = 0;

        foreach($inv->details as $item) {
          $price = $item->price;
          $qty = $item->quantity;
          // total amount by cent
          $total_amount  = $price * $qty;
          $totalCent = $total_amount * 100;
          $invoiceItem[] = [
            'name' => 'Product ' . $item->product_id,
            'amount' => $totalCent,
            'qty' => $qty,
            'price' => $price,
          ];
          $totalInvoice += $totalCent;
        }
        $payload = [
        'amount' => $totalInvoice,
        'billing_data' => $biilingData,
        'invoiceId' => $invoiceId,
        'items' => $invoiceItem,
        ];
        $intent = $this->paymob->checkout($payload);
        // $intent = $this->paymob->createPaymentIntent($totalInvoice, $biilingData, $invoiceId, $invoiceItem);
        
        ///unified_checkout_url
        // $checkout_url = $this->paymob->checkout($intent);
        
        if (isset($intent['unified_checkout_url'])) {
        return redirect()->away($intent['unified_checkout_url']);
      }
        
        // return response()->json([
        //     'intent' => $intent
        // ]);
        

        return response()->json([
        'status' => false,
        'message' => 'فشل إنشاء جلسة الدفع',
        'details' => $intent
    ], 400);


      // }catch(\Exception $e){

      // }
    }


    public function handlePaymobWebhook(Request $request)
    {
        Log::info('Paymob Webhook received', [
            'method' => $request->getMethod(),
            'path' => $request->path(),
            'data' => $request->all()
        ]);

        $data = $request->all();

        // Check if payment was successful
        if(isset($data['obj']['success']) && $data['obj']['success'] == true) {
          $obj = $data['obj'];
          $merchant_order_id = $obj['order']['merchant_order_id'] ?? null;

          if (!$merchant_order_id) {
              Log::warning('Paymob Webhook: Missing merchant_order_id', ['data' => $data]);
              return response()->json(['message' => 'Missing merchant_order_id'], 400);
          }

          $invoice = SalesInvoice::find($merchant_order_id);
          if (!$invoice) {
              Log::warning('Paymob Webhook: Invoice not found', ['merchant_order_id' => $merchant_order_id]);
              return response()->json(['message' => 'Invoice not found'], 404);
          }

          // Update invoice payment information
          $invoice->paid_amount = $obj['amount_cents'] / 100;
          $invoice->payment_status = 'paid';
          $invoice->save();



          $shift = Shifts::where('user_id', $invoice->user_id)
          ->where('store_id', $invoice->store_id)
          ->whereNull('end_time')
          ->first();

          $shift->actual_balance += $invoice->total_invoice;
          $shift->save();

          SafeTransaction::create([
              'safe_id' => $shift->safe_id,
              'shift_id' => $shift->id,
              'invoice_id' => $invoice->id,
              'user_id' => $invoice->user_id,
              'transaction_type' => 'in',
              'payment_method' => 'visa',
              'amount' => $invoice->total_invoice,
              'note' => 'فاتورة رقم ' . $invoice->invoice_number,
          ]);

          Log::info('Paymob Webhook: Invoice updated successfully', [
              'invoice_id' => $invoice->id,
              'paid_amount' => $invoice->paid_amount,
              'payment_status' => $invoice->payment_status
          ]);

          return response()->json(['message' => 'Webhook handled successfully'], 200);
        }

        Log::info('Paymob Webhook: Payment not successful or invalid data', ['data' => $data]);
        return response()->json(['message' => 'Payment not successful or invalid data'], 400);
    }



    public function paymentConfirmation(Request $request)
    {
        $invoice_id = $request->query('invoice_id');

        $invoice = SalesInvoice::find($invoice_id);

        if (!$invoice) {
            return "لم يتم العثور على الفاتورة";
        }

        if ($invoice->payment_status == 'paid') {
            return "تم دفع الفاتورة بنجاح";
        } else {
          return "فشل فى دفع الفاتروة";
        }
    }
    }
