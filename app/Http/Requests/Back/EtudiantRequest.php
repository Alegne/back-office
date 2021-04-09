<?php

namespace App\Http\Requests\Back;

use Illuminate\Foundation\Http\FormRequest;

class EtudiantRequest extends FormRequest
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
            'numero'         => 'required',
            'nom'            => 'required',
            'prenom'         => 'required',
            'email'          => 'required',
            'date_naissance' => 'required',
            'lieu_naissance' => 'required',
            'adresse'        => 'required',
            'status'         => 'required',
            'parcours_id'    => 'required',
        ];
    }
}
