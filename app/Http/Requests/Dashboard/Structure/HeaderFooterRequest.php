<?php

namespace App\Http\Requests\Dashboard\Structure;

use Illuminate\Foundation\Http\FormRequest;

class HeaderFooterRequest extends FormRequest
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
            'en.home_content.first_title' => ['required','string'],
            'en.logo' => ['required','string'],
            'en.fav_icon' => ['required','string'],
            'en.footer_logo' => ['required','string'],
            'en.social.*.icon' => ['required','string'],

            'ar.home_content.first_title' => ['required','string'],
            'ar.logo' => ['required','string'],
            'ar.fav_icon' => ['required','string'],
            'ar.footer_logo' => ['required','string'],
            'ar.social.*.icon' => ['required','string'],


            'all.social.*.link' => ['required','url'],
            'all.contacts.phones.*' => ['required','numeric'],
            'all.contacts.emails.*' => ['required','email'],

            'file.*' => ['image'],
            'old_file.*' => ['nullable','string'],
        ];
    }
}
