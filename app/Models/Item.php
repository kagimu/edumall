<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

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
        'school_id',
    ];

    protected static function booted()
    {
        static::addGlobalScope('tenant', function (Builder $builder) {
            $schoolId = session('tenant_school_id');
            if ($schoolId) {
                $builder->where('school_id', $schoolId);
            }
        });
    }

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

    public function school() {
        return $this->belongsTo(School::class);
    }
}
