<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTreatmentNoteRequest extends FormRequest
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
        return [
            'patient_id' => ['required', 'exists:patients,id'],
            'dentist_id' => ['required', 'exists:users,id'],
            'appointment_id' => ['nullable', 'exists:appointments,id'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'tooth_number' => ['nullable', 'string', 'max:50'],
        ];
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
            'appointment_id.exists' => 'الموعد المحدد غير موجود',
            'title.required' => 'عنوان العلاج مطلوب',
            'title.string' => 'عنوان العلاج يجب أن يكون نص',
            'title.max' => 'عنوان العلاج لا يمكن أن يتجاوز 255 حرف',
            'description.required' => 'وصف العلاج مطلوب',
            'description.string' => 'وصف العلاج يجب أن يكون نص',
            'tooth_number.string' => 'رقم السن يجب أن يكون نص',
            'tooth_number.max' => 'رقم السن لا يمكن أن يتجاوز 50 حرف',
        ];
    }
}
