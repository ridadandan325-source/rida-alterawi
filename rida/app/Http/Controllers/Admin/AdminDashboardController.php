<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Land;
use App\Models\Purchase;
use App\Models\User;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $usersCount = User::count();
        $landsCount = Land::count();
        $forSaleCount = Land::where('is_for_sale', true)->count();
        $soldCount = Land::where('is_for_sale', false)->count();

        $purchasesCount = Purchase::count();
        $totalVolume = Purchase::sum('price');

        $latestPurchases = Purchase::with(['land','buyer','seller'])
            ->latest()
            ->take(6)
            ->get();

        return view('admin.dashboard', compact(
            'usersCount',
            'landsCount',
            'forSaleCount',
            'soldCount',
            'purchasesCount',
            'totalVolume',
            'latestPurchases'
        ));
    }
}
