<?php

namespace App\Http\Requests\Api\V1\Post;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
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
            'description' => 'required|string|max:16000',
            'mark_id' => 'nullable|exists:marks,id',
            'model_id' => 'nullable|exists:models,id',
            'category_id' => 'required|exists:categories,id',
            'city_id' => 'nullable|exists:cities,id',
            'year' => 'nullable|digits:4|integer|min:0',
            'images' => ['nullable', 'array'],
            'images.*' => ['image','max:5120'],
        ];
    }
}
