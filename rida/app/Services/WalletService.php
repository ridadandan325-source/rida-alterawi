<?php

namespace App\Services;

use App\Models\User;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

class WalletService
{
    /**
     * Credit money to a user's wallet.
     */
    public function credit(User $user, float $amount, string $type, ?int $landId = null, string $description = '')
    {
        return DB::transaction(function () use ($user, $amount, $type, $landId, $description) {
            $user = User::where('id', $user->id)->lockForUpdate()->first();
            $user->wallet_balance += $amount;
            $user->save();

            return Transaction::create([
                'user_id' => $user->id,
                'land_id' => $landId,
                'amount' => $amount,
                'type' => $type,
                'description' => $description,
            ]);
        });
    }

    /**
     * Debit money from a user's wallet.
     */
    public function debit(User $user, float $amount, string $type, ?int $landId = null, string $description = '')
    {
        return DB::transaction(function () use ($user, $amount, $type, $landId, $description) {
            $user = User::where('id', $user->id)->lockForUpdate()->first();

            if ($user->wallet_balance < $amount) {
                throw new \Exception("Insufficient balance.");
            }

            $user->wallet_balance -= $amount;
            $user->save();

            return Transaction::create([
                'user_id' => $user->id,
                'land_id' => $landId,
                'amount' => -$amount, // Negative for tracking
                'type' => $type,
                'description' => $description,
            ]);
        });
    }
}
