<?php

namespace App\Services;

use App\Models\Land;
use App\Models\User;
use App\Models\Purchase;
use App\Models\LandOwnership;
use Illuminate\Support\Facades\DB;
use Exception;

class MarketService
{
    /**
     * Execute the purchase of a digital land (NFT-like asset).
     * 
     * @param User $buyer
     * @param Land $land
     * @return bool
     * @throws Exception
     */
    public function executePurchase(User $buyer, Land $land)
    {
        return DB::transaction(function () use ($buyer, $land) {
            // 1. Lock the land row to prevent race conditions
            $land = Land::where('id', $land->id)->lockForUpdate()->first();

            // 2. Lock the buyer row to ensure balance stability during check and deduct
            $buyer = User::where('id', $buyer->id)->lockForUpdate()->first();

            // 3. Critical State Validations inside transaction
            if (!$land->is_for_sale) {
                throw new Exception("This asset is no longer available for sale.");
            }

            if (!in_array($land->status, ['listed_admin', 'listed_owner'])) {
                throw new Exception("Asset is in an invalid state for purchase.");
            }

            if ($land->user_id === $buyer->id) {
                throw new Exception("You are already the owner of this asset.");
            }

            // Wallet balance validation inside transaction
            if ($buyer->wallet_balance < $land->price) {
                throw new Exception("Insufficient wallet balance to complete this acquisition.");
            }

            $seller = $land->user; // The current owner/seller
            $price = $land->price;

            // 4. Financial Settlement (Atomic Balance Updates)
            $buyer->decrement('wallet_balance', $price);

            // Credit seller (if not platform/admin)
            if ($seller && !$seller->is_admin) {
                $seller->increment('wallet_balance', $price);
            }

            // 5. Update Land Status and Current Owner
            $oldOwnerId = $land->user_id;
            $land->update([
                'user_id' => $buyer->id,
                'status' => 'owned',
                'is_for_sale' => false,
            ]);

            // 6. Ownership Provenance Sync (LandOwnerships table)
            // Deactivate previous ownership record
            LandOwnership::where('land_id', $land->id)
                ->where('is_current', true)
                ->update([
                    'is_current' => false,
                    'transferred_at' => now(),
                ]);

            // Create new record for current owner
            LandOwnership::create([
                'land_id' => $land->id,
                'user_id' => $buyer->id,
                'owned_at' => now(),
                'is_current' => true,
            ]);

            // 7. Transaction Logging (Purchases table)
            // seller_id is nullable-safe for primary sales
            Purchase::create([
                'user_id' => $buyer->id,
                'seller_id' => $oldOwnerId,
                'land_id' => $land->id,
                'price' => $price,
            ]);

            return true;
        });
    }
}
