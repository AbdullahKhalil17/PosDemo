<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SafeTransaction extends Model
{
    use HasFactory;

    protected $table = 'safe_transactions';

    protected $fillable = [
        'safe_id',
        'shift_id',
        'invoice_id',
        'user_id',
        'transaction_type',
        'payment_method',
        'amount',
        'note',
    ];

    public function safe()
    {
        return $this->belongsTo(Safes::class);
    }

    public function shift()
    {
        return $this->belongsTo(Shifts::class);
    }

    public function invoice()
    {
        return $this->belongsTo(SalesInvoice::class, 'invoice_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
