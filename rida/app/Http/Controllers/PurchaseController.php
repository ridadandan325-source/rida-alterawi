<?php

namespace App\Http\Controllers;

use App\Models\Land;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Services\MarketService;
use Illuminate\Support\Facades\Gate;

class PurchaseController extends Controller
{
    protected $marketService;

    public function __construct(MarketService $marketService)
    {
        $this->marketService = $marketService;
    }

    /**
     * Display purchases and sales of the authenticated user
     */
    public function myPurchases()
    {
        // الأراضي اللي اشتراها المستخدم
        $buying = Purchase::with(['land', 'seller'])
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        // الأراضي اللي باعها المستخدم
        $selling = Purchase::with(['land', 'buyer'])
            ->where('seller_id', Auth::id())
            ->latest()
            ->get();

        return view('purchases.index', compact('buying', 'selling'));
    }

    /**
     * Display sales page
     */
    public function mySales()
    {
        $sales = Purchase::with(['land', 'buyer'])
            ->where('seller_id', Auth::id())
            ->latest()
            ->get();

        return view('purchases.sales', compact('sales'));
    }

    /**
     * Show checkout page
     */
    public function checkout(Land $land)
    {
        try {
            $this->authorize('buy', $land);
        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            $reason = "Purchase criteria not met.";
            if ($land->user_id === Auth::id()) {
                $reason = "Conflict: You already own this asset.";
            } elseif (Auth::user()->wallet_balance < $land->price) {
                $reason = "Balance: You need " . number_format($land->price, 2) . " LNDC.";
            }
            return redirect()->route('map')->with('error', $reason);
        }

        return view('checkout', compact('land'));
    }

    /**
     * Process purchase using LAND Coins
     */
    public function payFake(Request $request, Land $land)
    {
        try {
            $this->authorize('buy', $land);
            $this->marketService->executePurchase(Auth::user(), $land);

            return redirect()
                ->route('lands.index')
                ->with('success', 'Asset acquired successfully!');
        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            return redirect()->back()->with('error', 'Purchase unauthorized.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
