<?php

namespace App\Rules;

use App\Models\Album;
use Illuminate\Contracts\Validation\Rule;

class AlbumUpdate implements Rule
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

        $album_search = Album::where('titre', $this->titre)
                        ->where('id', '!=', $this->id)->first();

        # dd($album_search);

        if (isset($album_search))
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
        # return 'La valeur du champ titre est déjà utilisée.';
        return __('validation.unique', ['attribute' => 'titre']);
    }
}
