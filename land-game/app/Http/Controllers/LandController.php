<?php

namespace App\Http\Controllers;

use App\Models\Land;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LandController extends Controller
{
    /**
     * Display the map with all lands.
     */
    public function map(): View
    {
        $lands = Land::with('owner')->get();
        
        return view('lands.map', [
            'lands' => $lands,
        ]);
    }

    /**
     * Display a specific land.
     */
    public function show(Land $land): View
    {
        // Load the owner relationship
        $land->load('owner');
        
        return view('lands.show', [
            'land' => $land,
        ]);
    }
}
