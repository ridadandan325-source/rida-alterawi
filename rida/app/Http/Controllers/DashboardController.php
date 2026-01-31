<?php

namespace App\Http\Controllers;

use App\Models\Land;
use App\Models\Purchase;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $userId = $user->id;

        $totalLands = Land::where('user_id', $userId)->count();
        $forSaleLands = Land::where('user_id', $userId)->where('is_for_sale', true)->count();
        $walletBalance = $user->wallet_balance;

        // Purchases/Sales come from Purchase table (MarketService does not write to Transaction)
        $purchasesCount = Purchase::where('user_id', $userId)->count();
        $salesCount = Purchase::where('seller_id', $userId)->count();

        // Latest wallet movements (top-up, etc.) from Transaction table
        $latestTransactions = Transaction::with(['land'])
            ->where('user_id', $userId)
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalLands',
            'forSaleLands',
            'walletBalance',
            'purchasesCount',
            'salesCount',
            'latestTransactions'
        ));
    }
}
