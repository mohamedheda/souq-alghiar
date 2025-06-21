<?php

namespace App\Http\Requests\Api\V1\Post\Comment;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;

class CommentRequest extends FormRequest
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
            'comment'    => 'required|string|max:255',
            'parent_id' => 'required',
            'type' => 'required|in:comment,reply',
            'pinned'     => 'required|in:0,1',
        ];
    }
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $type = $this->input('type');
            $parentId = $this->input('parent_id');

            if ($type === 'comment') {
                if (!DB::table('posts')->where('id', $parentId)->exists()) {
                    $validator->errors()->add('parent_id', 'The parent_id must be a valid post ID when type is comment.');
                }
            }

            if ($type === 'reply') {
                if (!DB::table('comments')->where('id', $parentId)->exists()) {
                    $validator->errors()->add('parent_id', 'The parent_id must be a valid comment ID when type is reply.');
                }
            }
        });
    }

}
