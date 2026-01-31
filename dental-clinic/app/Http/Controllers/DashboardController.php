<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->hasRole('admin')) {
            return view('dashboards.admin');
        } elseif ($user->hasRole('receptionist')) {
            return view('dashboards.receptionist');
        } elseif ($user->hasRole('dentist')) {
            return view('dashboards.dentist');
        } elseif ($user->hasRole('patient')) {
            return view('dashboards.patient');
        }

        abort(403, 'Unauthorized access.');
    }
}
