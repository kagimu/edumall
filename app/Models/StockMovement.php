<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

class StockMovement extends Model
{
    use BelongsToTenant;
    protected $fillable = [
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

    public function item() {
        return $this->belongsTo(Item::class);
    }

     public function creator()
        {
            return $this->belongsTo(User::class, 'created_by');
        }

    public function updateHistory()
    {
        return $this->hasMany(TransactionUpdateHistory::class);
    }
}
