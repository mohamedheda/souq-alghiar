<?php

namespace App\Http\Requests\Api\V1\Auth\User;

use App\Http\Enums\UserType;
use App\Rules\Phone;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UpdateProfileRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'user_name' => ['nullable', 'string', 'max:255',Rule::unique('users','user_name')->ignore(auth('api')->id()) ],
            'phone' => ['nullable', 'string', 'max:14',Rule::unique('users','phone')->ignore(auth('api')->id()), new Phone()],
            'address' => ['nullable', 'string'],
            'email' => [auth('api')->user()?->type==UserType::Merchant->value ? 'required':'nullable', 'email:rfc,dns', Rule::unique('users', 'email')->ignore(auth('api')->id())],
            'image' => ['nullable', 'image'],
            'cover' => ['nullable', 'image'],
            'city_id' => ['required', Rule::exists('cities', 'id')],
        ];
    }
}
