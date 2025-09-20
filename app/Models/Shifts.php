<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shifts extends Model
{
    use HasFactory;

    protected $table = 'shifts';

    protected $fillable = [
        'user_id',
        'store_id',
        'safe_id',
        'start_time',
        'end_time',
        'opening_balance',
        'closing_balance',
        'actual_balance',
        'difference'
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function store()
    {
        return $this->belongsTo(Stores::class);
    }
    
    public function safe()
    {
        return $this->belongsTo(Safes::class);
    }
    
    public function invoices()
    {
        return $this->hasMany(SalesInvoice::class);
    }

    public function transactions()
    {
        return $this->hasMany(SafeTransaction::class, 'shift_id');
    }
}
