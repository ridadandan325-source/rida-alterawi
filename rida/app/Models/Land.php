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
];

public function user()
{
    return $this->belongsTo(\App\Models\User::class);
}

}
