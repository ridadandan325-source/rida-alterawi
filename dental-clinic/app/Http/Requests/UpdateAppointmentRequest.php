<?php

namespace App\Http\Requests;

use App\Models\Appointment;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAppointmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $appointment = $this->route('appointment');

        return [
            'patient_id' => ['required', 'exists:patients,id'],
            'dentist_id' => ['required', 'exists:users,id'],
            'start_at' => ['required', 'date'],
            'end_at' => ['required', 'date', 'after:start_at'],
            'status' => ['required', Rule::in(['pending', 'confirmed', 'completed', 'cancelled', 'no_show'])],
            'reason' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string'],
        ];
    }

    /**
     * Configure the validator instance.
     */
    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            if (!$this->has('dentist_id') || !$this->has('start_at') || !$this->has('end_at')) {
                return;
            }

            $appointment = $this->route('appointment');
            $startAt = $this->input('start_at');
            $endAt = $this->input('end_at');
            $dentistId = $this->input('dentist_id');

            // Check for overlapping appointments (excluding current appointment)
            $overlapping = Appointment::where('dentist_id', $dentistId)
                ->where('id', '!=', $appointment->id)
                ->where(function ($query) use ($startAt, $endAt) {
                    $query->where(function ($q) use ($startAt, $endAt) {
                        // Check if new appointment overlaps with existing ones
                        // Overlap condition: start_at < existing_end AND end_at > existing_start
                        $q->where('start_at', '<', $endAt)
                          ->where('end_at', '>', $startAt);
                    });
                })
                ->whereNotIn('status', ['cancelled', 'no_show'])
                ->exists();

            if ($overlapping) {
                $validator->errors()->add(
                    'start_at',
                    'هذا الموعد يتداخل مع موعد آخر للطبيب في نفس الوقت. يرجى اختيار وقت آخر.'
                );
            }
        });
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'patient_id.required' => 'يجب اختيار المريض',
            'patient_id.exists' => 'المريض المحدد غير موجود',
            'dentist_id.required' => 'يجب اختيار الطبيب',
            'dentist_id.exists' => 'الطبيب المحدد غير موجود',
            'start_at.required' => 'تاريخ ووقت البداية مطلوب',
            'start_at.date' => 'تاريخ ووقت البداية يجب أن يكون تاريخ صحيح',
            'end_at.required' => 'تاريخ ووقت النهاية مطلوب',
            'end_at.date' => 'تاريخ ووقت النهاية يجب أن يكون تاريخ صحيح',
            'end_at.after' => 'تاريخ ووقت النهاية يجب أن يكون بعد تاريخ ووقت البداية',
            'status.required' => 'حالة الموعد مطلوبة',
            'status.in' => 'حالة الموعد غير صحيحة',
            'reason.max' => 'سبب الموعد لا يمكن أن يتجاوز 255 حرف',
        ];
    }
}
