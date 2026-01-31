<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\WalletService;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class WalletController extends Controller
{
    protected $walletService;

    public function __construct(WalletService $walletService)
    {
        $this->walletService = $walletService;
    }

    public function index()
    {
        $transactions = Transaction::where('user_id', Auth::id())
            ->with('land')
            ->latest()
            ->paginate(10);

        return view('wallet.index', compact('transactions'));
    }

    public function topUp(Request $request)
    {
        $request->validate([
            'amount' => ['required', 'numeric', 'min:10', 'max:10000'],
        ]);

        $this->walletService->credit(
            Auth::user(),
            $request->amount,
            'top_up',
            null,
            "Wallet top-up simulation"
        );

        return back()->with('success', 'Wallet topped up successfully! ✅');
    }
}
