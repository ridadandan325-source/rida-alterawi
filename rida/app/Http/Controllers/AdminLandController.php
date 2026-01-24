<?php

namespace App\Http\Controllers;

use App\Models\Land;

class AdminLandController extends Controller
{
    public function index()
    {
        // كل الأراضي + صاحبها (لازم علاقة user في Land model)
        $lands = Land::with('user')->latest()->get();

        return view('admin.lands.index', compact('lands'));
    }
}
