<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Stancl\Tenancy\Database\Models\Tenant;
use Stancl\Tenancy\Contracts\TenantWithDatabase;
use Stancl\Tenancy\Database\Concerns\HasDatabase;

class School extends Tenant implements TenantWithDatabase
{
    use HasFactory, HasDatabase;

    protected $table = 'schools';

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

    /** Relationships */
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

    public function isActive(): bool
    {
        return $this->status === 'active';
    }
}
