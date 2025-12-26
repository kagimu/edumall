<?php

namespace App\Http\Controllers;

use App\Models\Lab;
use App\Models\User;
use App\Models\Order;
use App\Models\School;
use Illuminate\Http\Request;


use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
     public function dashboard()
    {
        session(['title' => 'Dashboard']);

        $labs = number_format(Lab::count());
        $schoolsCount = number_format(School::count());
        $users = number_format(User::count());

          // Get registered schools for display
        $schools = School::latest()->paginate(10);



        return view('dashboard', compact('labs', 'users', 'schools', 'schoolsCount'));
    }
}
