<?php

namespace App\Http\Requests\Dashboard\Product;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'used' => 'nullable|in:0,1',
            'category_id' => 'nullable|exists:categories,id',
            'sub_category_id' => 'nullable|exists:categories,id',
            'price' => 'nullable|integer|min:1|max_digits:7',
            'all_makes' => 'nullable|in:0,1',
            'featured' => 'nullable|in:0,1',

            'makes' => 'nullable|array',
            'makes.*.product_id' => 'nullable|exists:products,id',
            'makes.*.mark_id' => 'nullable|exists:marks,id',
            'makes.*.model_id' => 'nullable|exists:models,id',
            'makes.*.year_from' => 'nullable|digits:4|integer|min:0',
            'makes.*.year_to' => 'nullable|digits:4|integer|min:0',
            'deleted_makes' => ['nullable', 'array'],
            'deleted_makes.*' => ['exists:product_marks,id'],

            'images' => ['nullable', 'array'],
            'images.*' => ['image','max:5120'],
            'deleted_images' => ['nullable', 'array'],
            'deleted_images.*' => ['exists:product_images,id'],
        ];
    }

    public function messages()
    {
        return [
            'en' => [
                'title.string' => 'The title must be a string.',
                'title.max' => 'The title may not be greater than 255 characters.',
                'description.string' => 'The description must be a string.',
                'used.in' => 'The used field must be either 0 or 1.',
                'category_id.exists' => 'The selected category does not exist.',
                'sub_category_id.exists' => 'The selected sub-category does not exist.',
                'price.integer' => 'The price must be an integer.',
                'price.min' => 'The price must be at least 1.',
                'all_makes.in' => 'The all makes field must be either 0 or 1.',
                'featured.in' => 'The featured field must be either 0 or 1.',
                'makes.required_if' => 'The makes field is required when all makes is 0.',
                'makes.array' => 'The makes field must be an array.',
                'makes.*.product_id.exists' => 'The selected product does not exist.',
                'makes.*.mark_id.exists' => 'The selected mark does not exist.',
                'makes.*.model_id.exists' => 'The selected model does not exist.',
                'makes.*.year_from.integer' => 'The year from must be an integer.',
                'makes.*.year_from.min' => 'The year from must be at least 0.',
                'makes.*.year_to.integer' => 'The year to must be an integer.',
                'makes.*.year_to.min' => 'The year to must be at least 0.',
                'makes.*.year_from.digits' => 'The year from must be exactly 4 digits.',
                'makes.*.year_to.digits' => 'The year to must be exactly 4 digits.',
                'images.required' => 'The images field is required.',
                'images.array' => 'The images field must be an array.',
                'images.*.image' => 'Each item in the images must be a valid image.',
                'images.*.max' => 'Each image may not be greater than 5MB.',
                'price.digits' => 'The price must be a number with a maximum of 7 digits.',
            ],
            'ar' => [
                'title.string' => 'يجب أن يكون العنوان نصًا.',
                'title.max' => 'لا يجب أن يكون العنوان أكبر من 255 حرفًا.',
                'description.string' => 'يجب أن يكون الوصف نصًا.',
                'used.in' => 'يجب أن يكون حقل "مستعمل" إما 0 أو 1.',
                'category_id.exists' => 'القسم المحدد غير موجود.',
                'sub_category_id.exists' => 'القسم الداخلي المحدد غير موجود.',
                'price.integer' => 'يجب أن يكون السعر عددًا صحيحًا.',
                'price.min' => 'يجب أن يكون السعر على الأقل 1.',
                'all_makes.in' => 'يجب أن يكون حقل "جميع العلامات" إما 0 أو 1.',
                'featured.in' => 'يجب أن يكون حقل "مميز" إما 0 أو 1.',
                'makes.required_if' => 'حقل "الماركات" مطلوب عند عدم تحديد "كل الماركات" رجاء اختيار الماركات والموديلات والسنين.',
                'makes.array' => 'يجب أن يكون حقل "الماركات" مصفوفة.',
                'makes.*.product_id.exists' => 'المنتج المحدد غير موجود.',
                'makes.*.mark_id.exists' => 'الماركه المحددة غير موجودة.',
                'makes.*.model_id.exists' => 'الموديل المحدد غير موجود.',
                'makes.*.year_from.integer' => 'يجب أن يكون السنة من عددًا صحيحًا.',
                'makes.*.year_from.min' => 'يجب أن يكون السنة من على الأقل 0.',
                'makes.*.year_to.integer' => 'يجب أن يكون السنة إلى عددًا صحيحًا.',
                'makes.*.year_to.min' => 'يجب أن يكون السنة إلى على الأقل 0.',
                'makes.*.year_from.digits' => 'يجب أن تكون السنة من مكونة من 4 أرقام.',
                'makes.*.year_to.digits' => 'يجب أن تكون السنة إلى مكونة من 4 أرقام.',
                'images.required' => 'حقل الصور مطلوب.',
                'images.array' => 'يجب أن يكون حقل الصور مصفوفة.',
                'images.*.image' => 'يجب أن يكون كل عنصر في الصور صورة صالحة.',
                'images.*.max' => 'يجب ألا تتجاوز الصورة 5 ميجابايت.',
                'price.digits' => 'يجب أن يكون السعر عددًا مكونًا من 7 أرقام كحد أقصى.',
            ]
        ];
    }
}
