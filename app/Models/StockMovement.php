<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class StockMovement extends Model
{
    protected $fillable = [
        'item_id',
        'user_id',
        'type',
        'quantity',
        'note',
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

    public function item() {
        return $this->belongsTo(Item::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function school() {
        return $this->belongsTo(School::class);
    }
}
