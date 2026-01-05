<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Stancl\Tenancy\Contracts\TenantWithDatabase;
use Stancl\Tenancy\Database\Concerns\HasDatabase;

class School extends Model implements TenantWithDatabase
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

    // Implement Tenant interface methods
    public function getTenantKeyName(): string
    {
        return 'id';
    }

    public function getTenantKey()
    {
        return $this->getKey();
    }

    public function getTenantIdentifier(): string
    {
        return $this->getKey();
    }

    // Implement TenantWithDatabase interface methods
    public function getInternal(string $key): mixed
    {
        return $this->getAttribute($key);
    }
}
