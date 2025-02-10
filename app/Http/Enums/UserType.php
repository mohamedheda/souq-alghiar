<?php

namespace App\Http\Enums;

use App\Rules\Phone;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

enum UserType: string
{
    use Enumable;

    case User = 'user';
    case Merchant = 'merchant';

    public function validationRules()
    {
        return match ($this) {
            self::User => [
                'email' => ['required', 'email:rfc,dns', Rule::unique('users', 'email')],
                'password' => ['required', Password::min(8)->letters()->numbers()->symbols()],
                'name' => ['required', 'string', 'max:255'],
                'city_id' => ['required', Rule::exists('cities', 'id')],
            ],
            self::Merchant => [
                'email' => ['required', 'email:rfc,dns', Rule::unique('users', 'email')],
                'password' => ['required', Password::min(8)->letters()->numbers()->symbols()],
                'name' => ['required', 'string', 'max:255'],
                'user_name' => ['nullable', 'string', 'max:255', 'unique:users,user_name'],
                'phone' => ['nullable', 'string', 'max:14', new Phone()],
                'address' => ['nullable', 'string'],
                'image' => ['required', 'image'],
                'city_id' => ['required', Rule::exists('cities', 'id')],
            ],
        };
    }

    public function t()
    {
        return match ($this) {
            self::User => __('dashboard.user'),
            self::Merchant => __('dashboard.merchant'),
        };
    }
}
