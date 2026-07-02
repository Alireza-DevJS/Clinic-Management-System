<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateWorkShiftRequest extends FormRequest
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
        'start_time' => 'required',
        'end_time' => 'required|after:start_time',
        'visit_duration' => 'required|integer|min:5'
        ];
    }

    /**
     * Custom validation messages.
     */
    public function messages(): array
    {
        return [
            'start_time.required' => 'شروع تایم کاری اجباری میباشد',
            'end_time.after:start_time' => 'تاریخ پایان تایم کاری باید بعد از شروع تایم کاری باشد',
            'visit_duration.required' => 'تعداد ویزیت بیمار اجباری میباشد',
            'visit_duration.required.integer' => 'نعداد ویزیت باید عدد باشد',
            'visit_duration.required.min:5' => 'نعداد ویزیت باید حداقل 5 باشد',
        ];
    }
}
