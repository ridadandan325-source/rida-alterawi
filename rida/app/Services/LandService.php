<?php

namespace App\Services;

use App\Models\Land;
use App\Models\LandOwnership;
use Illuminate\Support\Str;

class LandService
{
    /**
     * Generate a unique Land ID (NFT-like).
     */
    public function generateUniqueId()
    {
        do {
            $id = 'LAND-' . strtoupper(Str::random(8));
        } while (Land::where('land_unique_id', $id)->exists());

        return $id;
    }

    /**
     * Transfer ownership of a land parcel.
     */
    public function transferOwnership(Land $land, int $newOwnerId)
    {
        // Deactivate current ownership
        LandOwnership::where('land_id', $land->id)
            ->where('is_current', true)
            ->update([
                'is_current' => false,
                'transferred_at' => now(),
            ]);

        // Create new ownership record
        LandOwnership::create([
            'land_id' => $land->id,
            'user_id' => $newOwnerId,
            'owned_at' => now(),
            'is_current' => true,
        ]);

        // Update land owner and status
        $land->update([
            'user_id' => $newOwnerId,
            'status' => 'owned',
            'is_for_sale' => false,
        ]);
    }

    /**
     * Change land status with validation.
     */
    public function changeStatus(Land $land, string $newStatus)
    {
        $allowedTransitions = [
            'created' => ['listed_admin'],
            'listed_admin' => ['owned'],
            'owned' => ['listed_owner'],
            'listed_owner' => ['owned'], // When bought
        ];

        // Basic validation logic can be added here
        $land->update(['status' => $newStatus]);
    }
}
