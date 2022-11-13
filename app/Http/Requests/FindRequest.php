<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FindRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'fullName' => 'bail|required|between:5,100',
            'piece_id' => 'required|',
            'findCity' => 'required|max:75',
            'ward' => 'required|max:75',
            'name' => 'bail|required|between:5,20',
            'email' => 'required|string|email|max:255|unique:users',
            'city' => 'bail|required|max:100',
            'phone_number' => 'bail|required|regex:/^([0-9\s\-\+\(\)]*)$/|max:9',
            'amount_check' => 'bail|required',
//            'photos' => 'required|image|mimes:jpg,png,jpeg,bmp|max:2048',
        ];
    }
}
