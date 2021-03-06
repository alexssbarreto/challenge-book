<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|string|min:3|max:100',
            'description' => 'required|string|min:3|max:100',
            'author' => 'required|string|min:3|max:100',
            'number_page' => 'required|int',
        ];
    }
}
