<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseInvoice extends Model
{
    use HasFactory;

    protected $table = 'purchase_invoice';

    protected $fillable = [
        'store_id',
        'user_id',
        'supplier_name',
        'invoice_number',
        'invoice_date',
        'total_amount',
        'status',
        'notes',
    ];

    protected $casts = [
        'invoice_date' => 'date',
        'total_amount' => 'decimal:2',
    ];

    public function details()
    {
        return $this->hasMany(PurchaseInvoiceDetails::class);
    }

    public function store()
    {
        return $this->belongsTo(Stores::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
