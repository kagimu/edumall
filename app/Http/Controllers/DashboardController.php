<?php

namespace App\Http\Controllers;

use App\Models\Lab;
use App\Models\Library;
use App\Models\Stationary;
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
        $libraries = number_format(Library::count());
        $stationaries = number_format(Stationary::count());

          // Eager load related items for display
        $orders = Order::with('items.product')->latest()->paginate(10);



        return view('dashboard', compact('labs', 'libraries', 'stationaries', 'orders'));
    }
}
