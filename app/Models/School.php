<?php

namespace App\Models;

use Stancl\Tenancy\Database\Models\Tenant;
use Stancl\Tenancy\Contracts\TenantWithDatabase;
use Stancl\Tenancy\Database\Concerns\HasDatabase;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class School extends Tenant implements TenantWithDatabase
{
    use HasFactory, HasDatabase;



    protected $fillable = [
        'id',       // optional if using UUID
        'name',     // top-level column required by MySQL
        'data',     // JSON column
    ];

    protected $virtualColumns = ["name"]; // Make 'name' a real column

    /** Relationships */
    public function users()
    {
        return $this->hasMany(User::class, 'tenant_id');
    }

    public function items()
    {
        return $this->hasMany(Item::class);
    }

    public function stockMovements()
    {
        return $this->hasManyThrough(StockMovement::class, Item::class);
    }

    /** ----------------------
     * JSON accessors
     * ----------------------
     */
    public function getDataValue(string $key)
    {
        return $this->data[$key] ?? null;
    }

    public function getStatusAttribute(): ?string
    {
        return $this->getDataValue('status') ?? 'active';
    }

    public function getCentreNumberAttribute(): ?string
    {
        return $this->getDataValue('centre_number');
    }

    public function getDistrictAttribute(): ?string
    {
        return $this->getDataValue('district');
    }

    public function getAdminNameAttribute(): ?string
    {
        return $this->getDataValue('admin_name');
    }

    public function getAdminEmailAttribute(): ?string
    {
        return $this->getDataValue('admin_email');
    }

    public function getAdminPhoneAttribute(): ?string
    {
        return $this->getDataValue('admin_phone');
    }

    /** ----------------------
     * Convenience
     * ----------------------
     */
    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    /** ----------------------
     * Boot method: sync JSON 'name' to top-level 'name'
     * ----------------------
     */
    protected static function booted()
    {
        static::creating(function ($school) {
            if (isset($school->data['name']) && empty($school->name)) {
                $school->name = $school->data['name'];
            }
        });
    }
}
