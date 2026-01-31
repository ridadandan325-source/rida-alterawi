<?php

namespace App\Http\Controllers;

use App\Models\Land;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LandController extends Controller
{
    /**
     * Display all lands owned by the authenticated user
     */
    public function index()
    {
        $lands = Land::where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('lands.index', compact('lands'));
    }

    /**
     * Display a single land
     */
    public function show(Land $land)
    {
        $land->load('user');
        return view('lands.show', compact('land'));
    }
}
