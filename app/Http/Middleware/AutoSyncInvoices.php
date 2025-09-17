<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Http\Traits\NetworkHelperTrait;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class AutoSyncInvoices
{
  use NetworkHelperTrait;
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // تحقق من وجود ملف الفواتير الأوفلاين
        if (Storage::exists('offline_invoices/offline_invoices.json') && $this->isConnected()) {
            // تشغيل الأمر فقط إذا كان هناك اتصال بالإنترنت
            Artisan::call('sync:invoices');
        }

        return $next($request);
    }
}
