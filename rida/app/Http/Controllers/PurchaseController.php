<?php

namespace App\Http\Controllers;

use App\Models\Land;
use App\Models\Purchase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{
    // صفحة مشترياتي
    public function myPurchases()
    {
        $purchases = Purchase::with(['land', 'buyer', 'seller'])
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('purchases.index', compact('purchases'));
    }

    // صفحة مبيعاتي
    public function mySales()
    {
        $sales = Purchase::with(['land', 'buyer', 'seller'])
            ->where('seller_id', Auth::id())
            ->latest()
            ->get();

        return view('purchases.sales', compact('sales'));
    }

    // ✅ صفحة الدفع الوهمي
    public function checkout(Land $land)
    {
        // لازم تكون للبيع
        if (!$land->is_for_sale) {
            return redirect()->route('purchases.index')->with('error', 'This land is not for sale.');
        }

        // ممنوع تشتري أرضك
        if ($land->user_id === Auth::id()) {
            return redirect()->route('purchases.index')->with('error', 'You cannot buy your own land.');
        }

        // ممنوع تنشرا مرتين
        if (Purchase::where('land_id', $land->id)->exists()) {
            return redirect()->route('purchases.index')->with('error', 'This land is already sold.');
        }

        return view('checkout', compact('land'));
    }

    // ✅ تنفيذ الدفع الوهمي (هنا يتم الشراء فعلياً)
    public function payFake(Land $land)
    {
        return DB::transaction(function () use ($land) {

            // قفل لمنع شراء مزدوج
            $land = Land::where('id', $land->id)->lockForUpdate()->first();

            if (!$land || !$land->is_for_sale) {
                return redirect()->route('purchases.index')->with('error', 'This land is not for sale.');
            }

            if ($land->user_id === Auth::id()) {
                return redirect()->route('purchases.index')->with('error', 'You cannot buy your own land.');
            }

            if (Purchase::where('land_id', $land->id)->exists()) {
                return redirect()->route('purchases.index')->with('error', 'This land is already sold.');
            }

            // البائع قبل نقل الملكية
            $sellerId = $land->user_id;

            // سجل عملية الشراء
            Purchase::create([
                'user_id'   => Auth::id(),
                'seller_id' => $sellerId,
                'land_id'   => $land->id,
                'price'     => $land->price,
            ]);

            // نقل ملكية + مش للبيع
            $land->user_id = Auth::id();
            $land->is_for_sale = false;
            $land->save();

            return redirect()->route('purchases.index')
                ->with('success', 'Payment successful (Fake) ✅ Land purchased!');
        });
    }

    // (اختياري) شراء مباشر - مش مستخدم الآن
    public function buy(Land $land)
    {
        return redirect()->route('checkout.show', $land);
    }
}
