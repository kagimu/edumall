<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
    'user_id',
    'total',
    'payment_method',
    'payment_status',
    'delivery_details',
    'payment_reference',
    ];

    protected $casts = [
        'delivery_details' => 'array',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
