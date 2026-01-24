<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $fillable = [
        'user_id',
        'seller_id',
        'land_id',
        'price',
    ];

    // ✅ كاست للسعر (اختياري بس ممتاز)
    protected $casts = [
        'price' => 'decimal:2',
    ];

    // ✅ الأرض
    public function land()
    {
        return $this->belongsTo(\App\Models\Land::class);
    }

    // ✅ المشتري
    public function buyer()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

    // ✅ البائع
    public function seller()
    {
        return $this->belongsTo(\App\Models\User::class, 'seller_id');
    }
}
