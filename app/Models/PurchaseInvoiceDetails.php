<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseInvoiceDetails extends Model
{
    use HasFactory;

    protected $table = 'purchase_invoice_details';

    protected $fillable = [
        'purchase_invoice_id',
        'product_id',
        'quantity',
        'unit_price',
        'total',
        'unit_id',
        'notes',
    ];

    public function purchaseInvoice()
    {
        return $this->belongsTo(PurchaseInvoice::class);
    }

    public function product()
    {
        return $this->belongsTo(Products::class);
    }

    public function unit()
    {
        return $this->belongsTo(Units::class);
    }
}
