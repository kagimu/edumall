<?php

namespace App\Policies;

use App\Models\Item;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class StockPolicy
{
    public function before(User $user)
    {
        // Admin can do anything
        if ($user->role === 'admin') {
            return true;
        }
    }

    public function view(User $user, Item $item)
    {
        return in_array($user->role, [
            'department_head',
            'teacher',
            'lab_agent'
        ]);
    }

    public function stockIn(User $user)
    {
        return $user->role === 'lab_agent';
    }

    public function stockOut(User $user)
    {
        return in_array($user->role, [
            'lab_agent',
            'teacher'
        ]);
    }

    public function adjust(User $user)
    {
        return $user->role === 'lab_agent';
    }

    public function viewReports(User $user)
    {
        return in_array($user->role, [
            'admin',
            'department_head'
        ]);
    }
}

