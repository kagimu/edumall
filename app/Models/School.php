<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class School extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'centre_number',
        'district',
        'subcounty',
        'parish',
        'village',
        'admin_name',
        'admin_email',
        'admin_phone',
        'status',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function items()
    {
        return $this->hasMany(Item::class);
    }

    public function stockMovements()
    {
        return $this->hasManyThrough(StockMovement::class, Item::class);
    }

    public function isActive()
    {
        return $this->status === 'active';
    }
}
