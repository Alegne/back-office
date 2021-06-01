<?php

namespace App\Http\Requests\Back;

use Illuminate\Foundation\Http\FormRequest;

class EnseignantRequest extends FormRequest
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
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            # 'identifiant.unique' => 'Cet identifitant existe deja',
            # 'email.unique'       => 'Cet email existant ',
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            #'identifiant'   => 'required|unique:cactus_enseignants',
            'nom'           => 'required',
            'prenom'        => 'required',
            'email'         => 'required|unique:cactus_enseignants|email',
            'telephone'     => 'required|numeric',
            'adresse'       => 'required',
            'photo'         => 'mimes:jpeg,jpg,png,gif|max:10000'
        ];
        # |size:10
    }
}
