<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class StockMovement extends Model
{
    protected $fillable = [
        'school_id',
        'item_id',
        'created_by',
        'type',
        'quantity',
        'reason',
        'notes',
        'is_updated',
        'created_at',

    ];

    protected $casts = [
        'date' => 'datetime',
        'is_updated' => 'boolean',
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

     public function creator()
        {
            return $this->belongsTo(User::class, 'created_by');
        }

    public function school() {
        return $this->belongsTo(School::class);
    }

    public function updateHistory()
    {
        return $this->hasMany(TransactionUpdateHistory::class);
    }
}
