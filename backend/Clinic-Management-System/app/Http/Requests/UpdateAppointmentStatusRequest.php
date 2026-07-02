<?php

namespace App\Http\Requests;

use App\Enums\AppointmentStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;


class UpdateAppointmentStatusRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Validation rules.
     */
    public function rules(): array
    {
        return [
            'status' => [
    'required',
    new Enum(AppointmentStatus::class),
],
        ];
    }

    /**
     * Custom validation messages.
     */
    public function messages(): array
    {
        return [
            'status.required' => 'وضعیت نوبت الزامی است.',
            'status.string'   => 'وضعیت نوبت باید رشته باشد.',
            'status.in'       => 'وضعیت انتخاب شده معتبر نیست.',
        ];
    }

    /**
     * Custom attribute names.
     */
    public function attributes(): array
    {
        return [
            'status' => 'وضعیت نوبت',
        ];
    }
}
