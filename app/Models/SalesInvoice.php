<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesInvoice extends Model
{
    use HasFactory;

  protected $table = 'sales_invoice';

    protected $fillable = [
        'user_id',
        'store_id',
        'invoice_number',
        'invoice_date',
        'total_invoice',
        'payment_method',
        'note',
    ];

    public function details()
    {
        return $this->hasMany(SalesInvoiceDetails::class, 'invoice_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
