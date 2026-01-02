<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $fillable = [
        'school_id',
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
