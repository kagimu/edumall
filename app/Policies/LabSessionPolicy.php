<?php

namespace App\Policies;

use App\Models\LabSession;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class LabSessionPolicy
{
    public function viewAny(User $user)
    {
        return in_array($user->accountType, ['institution', 'teacher', 'lab_user']);
    }

    public function create(User $user)
    {
        return in_array($user->role, ['admin', 'lab_manager']);
    }

    public function update(User $user, LabSession $session)
    {
        return in_array($user->role, ['admin', 'lab_manager']);
    }

    public function delete(User $user, LabSession $session)
    {
        return $user->role === 'admin';
    }
}

