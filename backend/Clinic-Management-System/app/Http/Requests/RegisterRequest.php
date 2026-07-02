<?php

namespace App\Http\Requests;
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
            'name' => ['required','string','max:255'],
            'email' => ['required', 'email','unique:users'],
            'password' => ['required', 'string','min:8','confirmed'],
        ];
    }

    public function messages(): array
{
    return [
        'name.required' => 'نام الزامی است.',
        'name.string' => 'نام باید یک متن معتبر باشد.',
        'name.max' => 'نام نمی‌تواند بیشتر از ۲۵۵ کاراکتر باشد.',

        'email.required' => 'ایمیل الزامی است.',
        'email.email' => 'فرمت ایمیل معتبر نیست.',
        'email.unique' => 'کاربری با این ایمیل قبلاً ثبت شده است.',

        'password.required' => 'رمز عبور الزامی است.',
        'password.string' => 'رمز عبور باید یک رشته معتبر باشد.',
        'password.min' => 'رمز عبور باید حداقل ۸ کاراکتر باشد.',
        'password.confirmed' => 'تکرار رمز عبور مطابقت ندارد.',
    ];
}
}
