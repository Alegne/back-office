<?php

namespace App\Rules;

use App\Models\Article;
use Illuminate\Contracts\Validation\Rule;

class ArticleUpdate implements Rule
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

        $article_search = Article::where('titre', $this->titre)
            ->where('id', '!=', $this->id)->first();

        # dd($article_search);

        if (isset($article_search))
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
        return __('validation.unique', ['attribute' => 'titre']);
    }
}
