<?php

namespace App\Http\Requests\Post;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class CheckSlugRequest extends FormRequest
{
    
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'slug' => [
                'required',
                'string',
                'filled',
                Rule::unique(Post::class),
            ]
        ];
    }
}
