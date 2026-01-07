<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

class Location extends Model
{
    use BelongsToTenant;

    protected $fillable = [
        'tenant_id',
        'name',
        'type',
        'lab_type',
        'capacity',
    ];

    protected $appends = ['current_usage'];

    public function items()
    {
        return $this->hasMany(Item::class);
    }

    public function getCurrentUsageAttribute()
    {
        return $this->items()->count();
    }

}
