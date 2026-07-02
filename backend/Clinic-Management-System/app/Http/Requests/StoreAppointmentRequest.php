<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAppointmentRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'appointment_date' => 'required|date|after:now',
        ];
    }
    public function messages(): array
    {
        return [
            'appointment_date.required' => 'تاریخ نوبت اجباری میباشد.',
            'appointment_date.date'   => 'فرمت تاریخ اشتباه است.',
            'appointment_date.after:now' => 'تاریخ رزرو نوبت باید بعد از تاریخ فعلی باشد.',
        ];
    }
}
