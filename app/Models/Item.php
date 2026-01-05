<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [
        'name',
        'category_id',
        'supplier_id',
        'location_id',
        'quantity',
        'min_quantity',
        'expiry_date',
        'unit',
        'unit_cost',
    ];

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function supplier() {
        return $this->belongsTo(Supplier::class);
    }

    public function location() {
        return $this->belongsTo(Location::class);
    }

    public function stockMovements() {
        return $this->hasMany(StockMovement::class);
    }
}
