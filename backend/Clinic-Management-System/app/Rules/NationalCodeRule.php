<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class NationalCodeRule implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $value = trim($value);

        // باید دقیقاً ۱۰ رقم باشد
        if (!preg_match('/^\d{10}$/', $value)) {
            $fail('کد ملی باید ۱۰ رقم باشد.');
            return;
        }

        // جلوگیری از اعداد تکراری
        if (preg_match('/^(\d)\1{9}$/', $value)) {
            $fail('کد ملی معتبر نیست.');
            return;
        }

        $checkDigit = (int) substr($value, 9, 1);

        $sum = 0;

        for ($i = 0; $i < 9; $i++) {
            $sum += ((int) $value[$i]) * (10 - $i);
        }

        $remainder = $sum % 11;

        $isValid = $remainder < 2
            ? $checkDigit === $remainder
            : $checkDigit === (11 - $remainder);

        if (!$isValid) {
            $fail('کد ملی معتبر نیست.');
        }
    }
}
