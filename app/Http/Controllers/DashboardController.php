<?php

namespace App\Http\Controllers;

use App\Models\Lab;
use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;


use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
     public function dashboard()
    {
        session(['title' => 'Dashboard']);

        $labs = number_format(Lab::count());
        $orders = number_format(Order::count());
        $users = number_format(User::count());

          // Eager load related items for display
        $orders = Order::with('items.product')->latest()->paginate(10);



        return view('dashboard', compact('labs', 'users', 'orders'));
    }
}
