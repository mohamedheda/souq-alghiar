<?php

namespace App\Http\Requests\Dashboard\Model;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ModelRequest extends FormRequest
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
            'mark_id' => ['required',Rule::exists('marks','id')],
            'name_ar' => ['required','string'] ,
            'name_en' => ['required','string'] ,
        ];
    }
}
