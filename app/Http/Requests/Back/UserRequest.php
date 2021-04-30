<?php

namespace App\Http\Requests\Back;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'identifiant'   => 'required|unique:cactus_users',
            'email'         => 'required|email|unique:cactus_users',
            'role'          => 'required',
            'photo'         => 'mimes:jpeg,jpg,png,gif|max:10000'
            #'password'     => 'required'
        ];
    }
}
