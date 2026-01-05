<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Stancl\Tenancy\Contracts\TenantWithDatabase;
use Stancl\Tenancy\Database\Concerns\HasDatabase;
use Stancl\Tenancy\Database\Concerns\HasDomains;
use Stancl\Tenancy\Concerns\HasInternalKeys;
use Stancl\Tenancy\Concerns\TenantRun;

class School extends Model implements TenantWithDatabase
{
    use HasFactory;
    use HasDatabase;
    use HasInternalKeys;
    use TenantRun;

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

    /** Tenant primary key */
    public function getTenantKeyName(): string
    {
        return 'id';
    }

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
