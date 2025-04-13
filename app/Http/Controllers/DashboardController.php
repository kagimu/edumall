<?php

namespace App\Http\Controllers;

use App\Models\Lab;
use App\Models\Library;
use App\Models\Stationary;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
     public function dashboard()
    {
        session(['title' => 'Dashboard']);

        $labs = number_format(Lab::count());
        $libraries = number_format(Library::count());
        $stationaries = number_format(Statinary::count());

        $active_clients = User::withCount(['posts', 'impacts'])
            ->where('role', 'client')
            ->orderByDesc(DB::raw('posts_count + impacts_count'))
            ->take(10)
            ->get();

        return view('dashboard', compact('labs', 'libraries', 'active_clients', 'stationaries'));
    }
}
