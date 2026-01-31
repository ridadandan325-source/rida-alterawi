<?php

namespace App\Http\Controllers;

use App\Models\TreatmentNote;
use App\Models\Patient;
use App\Models\User;
use App\Models\Appointment;
use App\Http\Requests\StoreTreatmentNoteRequest;
use App\Http\Requests\UpdateTreatmentNoteRequest;
use Illuminate\Http\Request;

class TreatmentNoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        $query = TreatmentNote::with(['patient', 'dentist', 'appointment']);

        // Role-based filtering
        if ($user->hasRole('dentist')) {
            // Dentists can only see their own treatment notes
            $query->where('dentist_id', $user->id);
        } elseif ($user->hasRole('patient')) {
            // Patients can only see their own treatment notes
            $patient = Patient::where('email', $user->email)->first();
            if ($patient) {
                $query->where('patient_id', $patient->id);
            } else {
                $query->whereRaw('1 = 0');
            }
        }

        // Filters
        if ($request->filled('patient_id')) {
            $query->where('patient_id', $request->patient_id);
        }

        if ($request->filled('dentist_id')) {
            $query->where('dentist_id', $request->dentist_id);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $treatmentNotes = $query->latest()->paginate(15);

        // Get data for filters (only for admin/receptionist)
        $patients = null;
        $dentists = null;
        if ($user->hasAnyRole(['admin', 'receptionist'])) {
            $patients = Patient::orderBy('full_name')->get();
            $dentists = User::role('dentist')->orderBy('name')->get();
        }

        return view('treatment_notes.index', compact('treatmentNotes', 'patients', 'dentists'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $user = auth()->user();

        // Authorization check
        if (!$user->hasAnyRole(['admin', 'dentist'])) {
            abort(403, 'Unauthorized access.');
        }

        $patients = Patient::orderBy('full_name')->get();
        $dentists = User::role('dentist')->orderBy('name')->get();
        
        // If dentist, set their ID as default
        if ($user->hasRole('dentist')) {
            $dentists = collect([$user]);
        }

        // Get appointments for selected patient (if provided)
        $appointments = collect();
        if ($request->filled('patient_id')) {
            $appointments = Appointment::where('patient_id', $request->patient_id)
                ->orderBy('start_at', 'desc')
                ->get();
        }

        return view('treatment_notes.create', compact('patients', 'dentists', 'appointments'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTreatmentNoteRequest $request)
    {
        $user = auth()->user();

        // Authorization check
        if (!$user->hasAnyRole(['admin', 'dentist'])) {
            abort(403, 'Unauthorized access.');
        }

        // If dentist, ensure they can only create notes for themselves
        if ($user->hasRole('dentist') && !$user->hasRole('admin')) {
            $request->merge(['dentist_id' => $user->id]);
        }

        TreatmentNote::create($request->validated());

        return redirect()->route('treatment-notes.index')
            ->with('status', 'تم إضافة سجل العلاج بنجاح');
    }

    /**
     * Display the specified resource.
     */
    public function show(TreatmentNote $treatmentNote)
    {
        $user = auth()->user();

        // Authorization checks
        if ($user->hasRole('dentist')) {
            // Dentists can only view their own notes
            abort_if($treatmentNote->dentist_id != $user->id, 403);
        } elseif ($user->hasRole('patient')) {
            // Patients can only view their own notes
            $patient = Patient::where('email', $user->email)->first();
            abort_if(!$patient || $treatmentNote->patient_id != $patient->id, 403);
        } elseif ($user->hasRole('receptionist')) {
            // Receptionist can view all (no restriction)
        } elseif (!$user->hasRole('admin')) {
            abort(403, 'Unauthorized access.');
        }

        $treatmentNote->load(['patient', 'dentist', 'appointment']);

        return view('treatment_notes.show', compact('treatmentNote'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TreatmentNote $treatmentNote)
    {
        $user = auth()->user();

        // Authorization checks
        if ($user->hasRole('dentist')) {
            // Dentists can only edit their own notes
            abort_if($treatmentNote->dentist_id != $user->id, 403);
        } elseif (!$user->hasAnyRole(['admin', 'dentist'])) {
            abort(403, 'Unauthorized access.');
        }

        $patients = Patient::orderBy('full_name')->get();
        $dentists = User::role('dentist')->orderBy('name')->get();
        
        // If dentist, set their ID as default
        if ($user->hasRole('dentist') && !$user->hasRole('admin')) {
            $dentists = collect([$user]);
        }

        // Get appointments for the patient
        $appointments = Appointment::where('patient_id', $treatmentNote->patient_id)
            ->orderBy('start_at', 'desc')
            ->get();

        return view('treatment_notes.edit', compact('treatmentNote', 'patients', 'dentists', 'appointments'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTreatmentNoteRequest $request, TreatmentNote $treatmentNote)
    {
        $user = auth()->user();

        // Authorization checks
        if ($user->hasRole('dentist')) {
            // Dentists can only update their own notes
            abort_if($treatmentNote->dentist_id != $user->id, 403);
            // Ensure dentist_id remains the same
            $request->merge(['dentist_id' => $user->id]);
        } elseif (!$user->hasAnyRole(['admin', 'dentist'])) {
            abort(403, 'Unauthorized access.');
        }

        $treatmentNote->update($request->validated());

        return redirect()->route('treatment-notes.index')
            ->with('status', 'تم تحديث سجل العلاج بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TreatmentNote $treatmentNote)
    {
        $user = auth()->user();

        // Authorization checks
        if ($user->hasRole('dentist')) {
            // Dentists can only delete their own notes
            abort_if($treatmentNote->dentist_id != $user->id, 403);
        } elseif (!$user->hasAnyRole(['admin', 'dentist'])) {
            abort(403, 'Unauthorized access.');
        }

        $treatmentNote->delete();

        return redirect()->route('treatment-notes.index')
            ->with('status', 'تم حذف سجل العلاج بنجاح');
    }
}
