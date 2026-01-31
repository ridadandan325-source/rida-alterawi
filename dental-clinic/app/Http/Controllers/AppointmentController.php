<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Patient;
use App\Models\User;
use App\Http\Requests\StoreAppointmentRequest;
use App\Http\Requests\UpdateAppointmentRequest;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        $query = Appointment::with(['patient', 'dentist']);

        // Role-based filtering
        if ($user->hasRole('patient')) {
            // Patients can only see their own appointments
            // Match patient by email (patients table has email field)
            $patient = Patient::where('email', $user->email)->first();
            if ($patient) {
                $query->where('patient_id', $patient->id);
            } else {
                // If no patient record found, return empty result
                $query->whereRaw('1 = 0');
            }
        } elseif ($user->hasRole('dentist')) {
            // Dentists can only see their own appointments
            $query->where('dentist_id', $user->id);
        }

        // Filters
        if ($request->filled('date_from')) {
            $query->whereDate('start_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('start_at', '<=', $request->date_to);
        }

        if ($request->filled('dentist_id')) {
            $query->where('dentist_id', $request->dentist_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $appointments = $query->latest('start_at')->paginate(15);

        // Get dentists for filter dropdown (only for admin/receptionist)
        $dentists = null;
        if ($user->hasAnyRole(['admin', 'receptionist'])) {
            $dentists = User::role('dentist')->get();
        }

        return view('appointments.index', compact('appointments', 'dentists'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Appointment::class);

        $patients = Patient::orderBy('full_name')->get();
        $dentists = User::role('dentist')->orderBy('name')->get();

        return view('appointments.create', compact('patients', 'dentists'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAppointmentRequest $request)
    {
        $this->authorize('create', Appointment::class);

        Appointment::create($request->validated());

        return redirect()->route('appointments.index')
            ->with('status', 'تم إضافة الموعد بنجاح');
    }

    /**
     * Display the specified resource.
     */
    public function show(Appointment $appointment)
    {
        $user = auth()->user();

        // Authorization checks
        if ($user->hasRole('patient')) {
            // Patients can only view their own appointments
            // Match patient by email
            $patient = Patient::where('email', $user->email)->first();
            abort_if(!$patient || $appointment->patient_id != $patient->id, 403);
        } elseif ($user->hasRole('dentist')) {
            // Dentists can only view their own appointments
            abort_if($appointment->dentist_id != $user->id, 403);
        }

        $appointment->load(['patient', 'dentist']);

        return view('appointments.show', compact('appointment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Appointment $appointment)
    {
        $this->authorize('update', $appointment);

        $patients = Patient::orderBy('full_name')->get();
        $dentists = User::role('dentist')->orderBy('name')->get();

        return view('appointments.edit', compact('appointment', 'patients', 'dentists'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAppointmentRequest $request, Appointment $appointment)
    {
        $user = auth()->user();

        // Dentists can only update status to completed/no_show
        if ($user->hasRole('dentist')) {
            $validated = $request->validated();
            // Only allow status update for dentists
            $appointment->update([
                'status' => $validated['status'],
                'notes' => $validated['notes'] ?? $appointment->notes,
            ]);

            return redirect()->route('appointments.show', $appointment)
                ->with('status', 'تم تحديث حالة الموعد بنجاح');
        }

        // Admin and receptionist can update everything
        $this->authorize('update', $appointment);
        $appointment->update($request->validated());

        return redirect()->route('appointments.index')
            ->with('status', 'تم تحديث الموعد بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Appointment $appointment)
    {
        $this->authorize('delete', $appointment);

        $appointment->delete();

        return redirect()->route('appointments.index')
            ->with('status', 'تم حذف الموعد بنجاح');
    }

    /**
     * Update appointment status to confirmed.
     */
    public function confirm(Appointment $appointment)
    {
        $this->authorize('update', $appointment);

        $appointment->update(['status' => 'confirmed']);

        return redirect()->route('appointments.show', $appointment)
            ->with('status', 'تم تأكيد الموعد بنجاح');
    }

    /**
     * Update appointment status to cancelled.
     */
    public function cancel(Appointment $appointment)
    {
        $this->authorize('update', $appointment);

        $appointment->update(['status' => 'cancelled']);

        return redirect()->route('appointments.show', $appointment)
            ->with('status', 'تم إلغاء الموعد بنجاح');
    }

    /**
     * Update appointment status (for dentists: completed/no_show only).
     */
    public function updateStatus(Request $request, Appointment $appointment)
    {
        $user = auth()->user();

        $request->validate([
            'status' => ['required', 'in:completed,no_show,confirmed,cancelled'],
        ]);

        // Dentists can only set to completed or no_show
        if ($user->hasRole('dentist')) {
            abort_unless(in_array($request->status, ['completed', 'no_show']), 403);
            abort_unless($appointment->dentist_id == $user->id, 403);
        } else {
            // Admin and receptionist can set any status
            $this->authorize('update', $appointment);
        }

        $appointment->update(['status' => $request->status]);

        return redirect()->route('appointments.show', $appointment)
            ->with('status', 'تم تحديث حالة الموعد بنجاح');
    }
}
