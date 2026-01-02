<?php

namespace App\Policies;

use App\Models\StorageLocation;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class StorageLocationPolicy
{
    public function viewAny(User $user)
    {
        return in_array($user->accountType, ['institution', 'teacher', 'lab_user']);
    }

    public function create(User $user)
    {
        return in_array($user->role, ['admin', 'lab_manager']);
    }

    public function update(User $user)
    {
        return in_array($user->role, ['admin', 'lab_manager']);
    }

    public function delete(User $user)
    {
        return in_array($user->role, ['admin']);
    }
}
