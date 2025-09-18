<?php

namespace App\Console\Commands;

use App\Models\Shifts;
use App\Models\Stocks;
use App\Models\SalesInvoice;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\SalesInvoiceDetails;
use Illuminate\Support\Facades\Log;
use App\Http\Traits\NetworkHelperTrait;
use Illuminate\Support\Facades\Storage;

class SyncInvoices extends Command
{
      use NetworkHelperTrait;
      protected $signature = 'sync:invoices';
      protected $description = 'Sync offline invoices from storage to database';

      public function handle()
      {
        if (!$this->isConnected()) {
          $this->warn("لا يوجد اتصال بالإنترنت. تم تأجيل المزامنة.");
          Log::warning("Sync skipped - No internet connection");
          return;
        }

        $path = 'offline_invoices/offline_invoices.json';

        if (!Storage::exists($path)) {
          $this->info('لا توجد فواتير غير متصلة للمزامنة.');
          return;
        }

        $invoices = json_decode(Storage::get($path), true);

        if (empty($invoices)) {
          $this->info('لا توجد فواتير غير متصلة للمزامنة.');
          Storage::delete($path);
          return;
        }

        $failedInvoices = [];

        foreach ($invoices as $data) {
          try {
            // check inoice in database
            $existingInvoice = SalesInvoice::where('invoice_number', $data['invoice_number'])->first();
            if ($existingInvoice) {
              $this->info("الفاتورة رقم {$data['invoice_number']} موجودة بالفعل. تم تخطيها.");
              continue;
            }

            DB::beginTransaction();

            $invoice = SalesInvoice::create([
              'user_id' => $data['user_id'],
              'store_id' => $data['store_id'],
              'invoice_number' => $data['invoice_number'],
              'invoice_date' => $data['invoice_date'],
              'total_invoice' => $data['total_invoice'],
              'note' => $data['note'],
            ]);

            foreach ($data['product_id'] as $i => $productId) {
              $quantity = $data['quantity'][$i];
              $price = $data['sellingPrice'][$i];
              $total = $quantity * $price;

              SalesInvoiceDetails::create([
                'invoice_id' => $invoice->id,
                'product_id' => $productId,
                'quantity' => $quantity,
                'price' => $price,
                'total' => $total,
              ]);

              // $stocks = Stocks::where('product_id', $productId)
              //     ->where('store_id', $data['store_id'])
              //     ->where('quantity', '>', 0)
              //     ->orderBy('id')
              //     ->get();

              // $remainingQuantity = $quantity;
              // foreach ($stocks as $stock) {
              //     if ($stock->quantity >= $remainingQuantity) {
              //         $stock->quantity -= $remainingQuantity;
              //         $stock->save();
              //         $remainingQuantity = 0;
              //         break;
              //     } else {
              //         $remainingQuantity -= $stock->quantity;
              //         $stock->quantity = 0;
              //         $stock->save();
              //     }
              // }

              // if ($remainingQuantity > 0) {
              //     throw new \Exception("كمية غير كافية للمنتج رقم {$productId}.");
              // }
            }

            $shift = Shifts::where('user_id', $data['user_id'])
              ->where('store_id', $data['store_id'])
              ->whereNull('end_time')
              ->first();

            if ($shift) {
              $shift->actual_balance += $invoice->total_invoice;
              $shift->save();
            }

            DB::commit();
              $this->info("تم مزامنة الفاتورة رقم {$data['invoice_number']} بنجاح.");
              Log::info("Sync Success", ['invoice_number' => $data['invoice_number']]);
          } catch (\Exception $e) {
            DB::rollBack();
            $this->error("فشل مزامنة الفاتورة رقم {$data['invoice_number']}: " . $e->getMessage());
            
            Log::error("Sync Failed", [
              'invoice_number' => $data['invoice_number'],
              'error' => $e->getMessage()
            ]);

            $this->error("فشل مزامنة الفاتورة رقم {$data['invoice_number']}: " . $e->getMessage());
            
            $failedInvoices[] = $data;
            continue;
          }
        }

        if (!empty($failedInvoices)) {
          Storage::put($path, json_encode($failedInvoices, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
          $this->warn("فشلت بعض الفواتير في المزامنة وتم الاحتفاظ بها في ملف JSON.");
        } else {
          Storage::delete($path);
          $this->info('تم مزامنة جميع الفواتير غير المتصلة بنجاح.');
        }
      }
}
