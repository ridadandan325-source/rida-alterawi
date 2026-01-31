<?php

namespace App\Policies;

use App\Models\Land;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class LandPolicy
{
    /**
     * Determine whether the user can buy the land.
     */
    public function buy(User $user, Land $land): bool
    {
        // 1. Must be explicitly listed for sale
        if (!$land->is_for_sale) {
            return false;
        }

        // 2. State machine protection: Must be in a listed state
        if (!in_array($land->status, ['listed_admin', 'listed_owner'])) {
            return false;
        }

        // 3. Ownership protection: Cannot buy own land
        if ($user->id === $land->user_id) {
            return false;
        }

        // 4. Financial verification: REMOVED from policy to allow viewing checkout page
        // Balance check is handled in MarketService transaction.
        // if ($user->wallet_balance < $land->price) {
        //    return false;
        // }

        return true;
    }

    /**
     * Optional: Determine whether the user can update the asset.
     */
    public function update(User $user, Land $land): bool
    {
        return $user->is_admin || $user->id === $land->user_id;
    }
}
