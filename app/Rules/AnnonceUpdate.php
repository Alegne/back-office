<?php

namespace App\Rules;

use App\Models\Annonce;
use Illuminate\Contracts\Validation\Rule;

class AnnonceUpdate implements Rule
{
    private $titre;
    private $id;

    /**
     * Create a new rule instance.
     *
     * @param $titre
     * @param $id
     */
    public function __construct($titre, $id)
    {
        //
        $this->titre = $titre;
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

        $annonce_search = Annonce::where('titre', $this->titre)
            ->where('id', '!=', $this->id)->first();

        # dd($annonce_search);

        if (isset($annonce_search))
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
        # return 'The validation error message.';
        return __('validation.unique', ['attribute' => 'titre']);
    }
}
