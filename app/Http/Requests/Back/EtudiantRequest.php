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
            'numero'         => 'required|unique:cactus_etudiants',
            'nom'            => 'required',
            'prenom'         => 'required',
            'cin'            => 'required|unique:cactus_etudiants|numeric|min:20',
            'email'          => 'required|unique:cactus_etudiants|email',
            'date_naissance' => 'required',
            'lieu_naissance' => 'required',
            'adresse'        => 'required',
            'status'         => 'required',
            'parcours_id'    => 'required',
        ];
    }
}
