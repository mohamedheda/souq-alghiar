<?php

namespace App\Http\Requests\Dashboard\Structure;

use Illuminate\Foundation\Http\FormRequest;

class AboutUsRequest extends FormRequest
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
            'en.title' => ['required', 'string'],
            'en.desc' => ['required', 'string'],
            'en.image' => ['required', 'string'],

            'ar.title' => ['required', 'string'],
            'ar.desc' => ['required', 'string'],
            'ar.image' => ['required', 'string'],

            'file.*' => ['image'],
            'old_file.*' => ['nullable', 'string'],
        ];
    }
}
