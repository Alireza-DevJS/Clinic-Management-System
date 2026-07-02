<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreHolidayRequest extends FormRequest
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
            'date' => ['required|date|unique:holidays,date'],
            'title' => ['nullable|string']
        ];
    }

    public function messages(): array
    {
        return [
            'date.required' => 'تاریخ الزامی است.',
            'date.date' => 'فرمت تاریخ صحیح نیست.',
            'date.unique' => 'تاریخ قبلا در لیست تعطیلات ثبت شده.',
            'title.string' => 'عنوان باید حروف باشد.',
        ];
    }
}
