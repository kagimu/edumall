<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'customer_name',
        'customer_email',
        'customer_phone',
        'delivery_info',
        'subtotal',
        'delivery_fee',
        'total',
        'payment_method',
        'payment_status',
    ];

    protected $casts = [
         'delivery_info' => 'array',
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
