<?php

namespace App\Http\Controllers;

use App\Models\Lab;
use App\Models\Library;
use App\Models\Stationary;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
     public function dashboard()
    {
        session(['title' => 'Dashboard']);

        $labs = number_format(Lab::count());
        $libraries = number_format(Library::count());
        $stationaries = number_format(Stationary::count());

        return view('dashboard', compact('labs', 'libraries', 'stationaries'));
    }
}
