<?php

namespace App\Http\Controllers;

use App\Models\Land;
use App\Models\Purchase;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $totalLands = Land::where('user_id', $userId)->count();
        $forSaleLands = Land::where('user_id', $userId)->where('is_for_sale', true)->count();
        $soldLands = Land::where('user_id', $userId)->where('is_for_sale', false)->count();

        $purchasesCount = Purchase::where('user_id', $userId)->count();
        $salesCount = Purchase::where('seller_id', $userId)->count();

        $latestPurchases = Purchase::with(['land','seller'])
            ->where('user_id', $userId)
            ->latest()
            ->take(5)
            ->get();

        $latestSales = Purchase::with(['land','buyer'])
            ->where('seller_id', $userId)
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalLands',
            'forSaleLands',
            'soldLands',
            'purchasesCount',
            'salesCount',
            'latestPurchases',
            'latestSales'
        ));
    }
}
