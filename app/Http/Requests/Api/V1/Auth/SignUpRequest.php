<?php

namespace App\Http\Requests\Api\V1\Auth;

use App\Http\Enums\UserType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class SignUpRequest extends FormRequest
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
        $userType = request()->type ?? UserType::User->value;
        return [
            'type' => ['required', Rule::in(UserType::values())],
            ...UserType::from($userType)->validationRules(),
        ];
    }
}
