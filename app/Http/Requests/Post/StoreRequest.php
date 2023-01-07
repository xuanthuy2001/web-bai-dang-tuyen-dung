<?php

namespace App\Http\Requests\Post;

use Illuminate\Validation\Rule;
use App\Enums\CompanyCountryEnum;
use App\Enums\PostCurrencySalaryEnum;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        $rules = [
            'name' => [
                'required',
                'filled',
                'string',
                'min:0',
            ],
            'country' => [
                'required',
                'string',
                Rule::in(CompanyCountryEnum::getKeys()),
            ],
            'city' => [
                'required',
                'string',
            ],
            'distinct' => [
                'nullable',
                'string',
            ],
            'currency_salary'   => [
                'required',
                'numeric',
                Rule::in(PostCurrencySalaryEnum::getValues()),
            ],
            'number_applicants' => [
                'nullable',
                'numeric',
                'min:1',
            ],
            'start_date'        => [
                'nullable',
                'date',
                'before:end_date',
            ],
            'end_date'          => [
                'nullable',
                'date',
                'after:start_date',
            ],
            'title'             => [
                'required',
                'string',
                'filled',
                'min:3',
                'max:255',
            ],
            'slug'              => [
                'required',
                'string',
                'filled',
                'min:3',
                'max:255',
                Rule::unique(Post::class),
            ],
            'address' => [
                'nullable',
                'string',
            ],
            'address2' => [
                'nullable',
                'string',
            ],
            'zipcode' => [
                'nullable',
                'string',
            ],
            'phone' => [
                'nullable',
                'string',
            ],
            'email' => [
                'nullable',
                'string',
            ],
            'logo' => [
                'nullable',
                'file',
                'image',
                'max:5000',
            ],
        ];
        $rules['min_salary'] = [
            'nullable',
            'numeric',
        ];
        if (!empty($this->max_salary)) {
            $rules['min_salary'][] = 'lt:max_salary';
        }
        $rules['max_salary'] = [
            'nullable',
            'numeric',
        ];
        if (!empty($this->min_salary)) {
            $rules['max_salary'][] = 'gt:min_salary';
        }
        
        return $rules;
    }
}
