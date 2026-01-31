<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'full_name',
        'phone',
        'email',
        'gender',
        'birth_date',
        'address',
        'notes',
    ];

    protected $casts = [
        'birth_date' => 'date',
    ];

    /**
     * Get the appointments for the patient.
     */
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    /**
     * Get the treatment notes for the patient.
     */
    public function treatmentNotes()
    {
        return $this->hasMany(TreatmentNote::class);
    }
    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }
}
