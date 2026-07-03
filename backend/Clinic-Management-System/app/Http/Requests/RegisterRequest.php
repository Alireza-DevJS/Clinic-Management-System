<?php

namespace App\Http\Requests;

use App\Rules\NationalCodeRule;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
        'name' => ['required', 'string', 'max:255'],

        'last_name' => ['required', 'string', 'max:255'],

        'email' => [
            'required',
            'email',
            'unique:users,email',
        ],

        'mobile' => [
            'required',
            'digits:11',
            'unique:users,mobile',
        ],

        'national_code' => [
            'required',
            new NationalCodeRule(),
            'unique:users,national_code',
        ],

        'birth_date' => [
            'nullable',
            'date',
            'before:today',
        ],

        'gender' => [
            'nullable',
            'in:male,female',
        ],

        'password' => [
            'required',
            'string',
            'min:8',
            'confirmed',
        ],
    ];
}

public function messages(): array
{
    return [
        'name.required' => 'نام الزامی است.',
        'name.string' => 'نام باید یک متن معتبر باشد.',
        'name.max' => 'نام نمی‌تواند بیشتر از ۲۵۵ کاراکتر باشد.',

        'last_name.required' => 'نام خانوادگی الزامی است.',
        'last_name.string' => 'نام خانوادگی باید یک متن معتبر باشد.',
        'last_name.max' => 'نام خانوادگی نمی‌تواند بیشتر از ۲۵۵ کاراکتر باشد.',

        'email.required' => 'ایمیل الزامی است.',
        'email.email' => 'فرمت ایمیل معتبر نیست.',
        'email.unique' => 'کاربری با این ایمیل قبلاً ثبت شده است.',

        'mobile.required' => 'شماره موبایل الزامی است.',
        'mobile.digits' => 'شماره موبایل باید ۱۱ رقم باشد.',
        'mobile.unique' => 'این شماره موبایل قبلاً ثبت شده است.',

        'national_code.required' => 'کد ملی الزامی است.',
        'national_code.unique' => 'این کد ملی قبلاً ثبت شده است.',

        'birth_date.date' => 'تاریخ تولد معتبر نیست.',
        'birth_date.before' => 'تاریخ تولد باید قبل از امروز باشد.',

        'gender.in' => 'جنسیت معتبر نیست.',

        'password.required' => 'رمز عبور الزامی است.',
        'password.string' => 'رمز عبور باید یک رشته معتبر باشد.',
        'password.min' => 'رمز عبور باید حداقل ۸ کاراکتر باشد.',
        'password.confirmed' => 'تکرار رمز عبور مطابقت ندارد.',
    ];
}
}
