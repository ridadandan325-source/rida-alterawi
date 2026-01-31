<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Land extends Model
{
    protected $fillable = [
        'title',
        'description',
        'price',
        'lat',
        'lng',
        'is_for_sale',
        'user_id',
        'status',
        'land_id',
        'land_unique_id',
        'coordinates',
        'area',
    ];

    /**
     * Use land_unique_id for Route Model Binding.
     */
    public function getRouteKeyName()
    {
        return 'land_unique_id';
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function ownerships()
    {
        return $this->hasMany(LandOwnership::class);
    }

    public function currentOwnership()
    {
        return $this->hasOne(LandOwnership::class)->where('is_current', true);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    // State helper
    public function isOwned()
    {
        return in_array($this->status, ['owned', 'listed_owner']);
    }
}
