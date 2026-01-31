<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function create()
    {
        return view('appointments.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_name' => ['required','string','max:255'],
            'phone'        => ['required','string','max:30'],
            'date'         => ['required','date'],
            'time'         => ['required'],
            'note'         => ['nullable','string','max:2000'],
        ]);

        if ($validated['date'] < now()->toDateString()) {
            return back()->withErrors(['date' => 'لا يمكن حجز موعد بتاريخ قديم.'])->withInput();
        }

        Appointment::create([
            'user_id'      => auth()->id(),
            'patient_name' => $validated['patient_name'],
            'phone'        => $validated['phone'],
            'date'         => $validated['date'],
            'time'         => $validated['time'],
            'note'         => $validated['note'] ?? null,
            'status'       => 'pending',
        ]);

        return redirect()->route('appointments.my')
            ->with('success', 'تم إرسال طلب الموعد ✅ بانتظار التأكيد.');
    }

    public function my()
    {
        $appointments = Appointment::where('user_id', auth()->id())
            ->orderBy('date')
            ->orderBy('time')
            ->get();

        return view('appointments.my', compact('appointments'));
    }
}
