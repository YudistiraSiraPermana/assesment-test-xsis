<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MovieRequest extends FormRequest
{
    public function rules()
    {
        return [
            'title'         => ['required'],
            'description'   => ['nullable'],
            'rating'        => ['required','numeric'],
            'image'         => ['nullable'],
        ];
    }

    public function messages()
    {
        return [
            'required'  => ':Attributes Must Be Filled.',
        ];
    }

    public function attributes()
    {
        return [
            'title'         => 'Title',
            'description'   => 'Description',
            'rating'        => 'Rating',
            'image'         => 'Image',
        ];
    }
}
