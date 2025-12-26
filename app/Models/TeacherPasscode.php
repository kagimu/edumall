<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeacherPasscode extends Model
{
    protected $fillable = [
        'school_id',
        'passcode',
        'teacher_name',
        'permissions',
        'created_by',
        'expires_at',
        'is_active',
    ];

    protected $casts = [
        'permissions' => 'array',
        'expires_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
