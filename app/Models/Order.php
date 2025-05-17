<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'customer_id',
        'total',
        'status',
        'address',
        'note',
        'delivery',
        'payment',
        'items',
    ];

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }
}
