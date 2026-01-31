<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LandOwnership extends Model
{
    protected $fillable = [
        'land_id',
        'user_id',
        'owned_at',
        'transferred_at',
        'is_current',
    ];

    protected $casts = [
        'owned_at' => 'datetime',
        'transferred_at' => 'datetime',
        'is_current' => 'boolean',
    ];

    public function land()
    {
        return $this->belongsTo(Land::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
