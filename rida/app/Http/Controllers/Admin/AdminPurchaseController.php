<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Purchase;

class AdminPurchaseController extends Controller
{
    public function index()
    {
        $purchases = Purchase::with(['land','buyer','seller'])->latest()->get();
        return view('admin.purchases.index', compact('purchases'));
    }
}
