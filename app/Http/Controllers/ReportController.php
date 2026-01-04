<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Supplier;
use App\Models\User;
use App\Models\LabAccessCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function analytics(Request $request)
    {
        $user = $request->user();
        if ($user->role_id !== 1) {
            return response()->json(['error' => 'Unauthorized. Only school administrators can view analytics.'], 403);
        }

        // Get school_id from user
        $schoolId = $user->school_id;

        // Total inventory items for the school
        $totalItems = Item::where('school_id', $schoolId)->count();

        // Active users (lab access codes that are active)
        $activeUsers = LabAccessCode::where('school_id', $schoolId)
            ->where('is_active', true)
            ->count();

        // Total suppliers
        $totalSuppliers = Supplier::count(); // Suppliers might be global or per school

        // Recent transactions (stock movements)
        $recentTransactions = DB::table('stock_movements')
            ->where('school_id', $schoolId)
            ->where('created_at', '>=', now()->subDays(30))
            ->count();

        // Low stock items
        $lowStockItems = Item::where('school_id', $schoolId)
            ->whereColumn('quantity', '<=', 'min_quantity')
            ->count();

        // Total value of inventory
        $totalValue = Item::where('school_id', $schoolId)
            ->sum(DB::raw('quantity * unit_cost'));

        return response()->json([
            'total_items' => $totalItems,
            'active_users' => $activeUsers,
            'total_suppliers' => $totalSuppliers,
            'recent_transactions' => $recentTransactions,
            'low_stock_items' => $lowStockItems,
            'total_value' => $totalValue,
        ]);
    }
}
