<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Appointment;
use App\Models\Invoice;
use App\Models\Payment;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index()
    {
        $stats = [
            'total_patients' => Patient::count(),
            'today_appointments' => Appointment::whereDate('start_at', Carbon::today())->count(),
            'upcoming_appointments' => Appointment::where('start_at', '>', Carbon::now())->count(),
            'total_revenue' => Payment::sum('amount'),
            'monthly_revenue' => Payment::whereMonth('created_at', Carbon::now()->month)->sum('amount'),
            'unpaid_invoices_count' => Invoice::where('status', '!=', 'paid')->count(),
            'unpaid_invoices_amount' => Invoice::where('status', '!=', 'paid')->get()->sum(function ($inv) {
                return $inv->total_amount - $inv->paid_amount;
            }),
        ];

        $recentPayments = Payment::with(['invoice.patient'])->latest()->take(5)->get();
        $recentAppointments = Appointment::with('patient')->latest()->take(5)->get();

        return view('reports.index', compact('stats', 'recentPayments', 'recentAppointments'));
    }
}
