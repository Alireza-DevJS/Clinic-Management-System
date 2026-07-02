<?php

namespace App\Http\Requests;

use App\Enums\WeekDay;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class StoreWorkShiftRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
{
    return [
        'day_of_week' => [
            'required',
            'integer',
            'between:0,6',
            new Enum(WeekDay::class),
        ],
        'start_time' => [
            'required',
        ],
        'end_time' => [
            'required',
            'after:start_time',
        ],
        'visit_duration' => [
            'required',
            'integer',
            'min:5',
        ],
    ];
}

    /**
     * Custom validation messages.
     */
    public function messages(): array
    {
        return [
            'day_of_week.required' => ' روز های هفته الزامی است.',
            'day_of_week.integer'   => ' روز های هفته باید عدد باشد.',
            'day_of_week.between:0,6'       => 'روز های هفته باید بین 0و6 باشد.',
            'start_time.required' => 'شروع تایم کاری اجباری میباشد',
            'end_time.after:start_time' => 'تاریخ پایان تایم کاری باید بعد از شروع تایم کاری باشد',
            'visit_duration.required' => 'تعداد ویزیت بیمار اجباری میباشد',
            'visit_duration.required.integer' => 'نعداد ویزیت باید عدد باشد',
            'visit_duration.required.min:5' => 'نعداد ویزیت باید حداقل 5 باشد',
        ];
    }
}
