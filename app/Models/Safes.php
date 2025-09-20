<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Safes extends Model
{
    use HasFactory;

    protected $table = 'safes';

    protected $fillable = [
        'store_id',
        'name',
    ];

    public function store()
    {
        return $this->belongsTo(Stores::class);
    }

    public function shifts()
    {
        return $this->hasMany(Shifts::class);
    }

    public function transactions()
    {
        return $this->hasMany(SafeTransaction::class);
    }
}
