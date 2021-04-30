<?php

namespace App\Rules;

use App\Models\AnneeUniversitaireLibelle;
use Illuminate\Contracts\Validation\Rule;

class AnneeUniversitaireUpdate implements Rule
{
    private $libelle;
    private $id;

    /**
     * Create a new rule instance.
     *
     * @param $libelle
     * @param $id
     */
    public function __construct($libelle, $id)
    {
        //
        $this->libelle = $libelle;
        $this->id = $id;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        # False => Show Error
        # True  => Hide Error

        $annee_search = AnneeUniversitaireLibelle::where('libelle', $this->libelle)
            ->where('id', '!=', $this->id)->first();

        # dd($annee_search);

        if (isset($annee_search))
        {
            return false;
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('validation.unique', ['attribute' => 'libelle']);
    }
}
