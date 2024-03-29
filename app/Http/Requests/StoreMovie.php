<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMovie extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|max:255',
            'name.*' => 'mimes:img,jpg,jpeg,png,bmp',
            'release_date' => 'required|max:255',
            'genre_id' => 'required|max:255',
            'images' => 'required'
        ];
    }
    public function message()
    {

    }
}
