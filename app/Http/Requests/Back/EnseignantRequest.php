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
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'identifiant'   => 'required',
            'nom'           => 'required',
            'prenom'        => 'required',
            'email'         => 'required',
            'telephone'     => 'required',
            'adresse'       => 'required',
        ];
    }
}
