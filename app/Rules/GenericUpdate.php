<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class GenericUpdate implements Rule
{
    private $table;
    private $champ;
    private $id;
    private $value;
    /**
     * @var null
     */
    private $specification;

    /**
     * Create a new rule instance.
     *
     * @param $table
     * @param $champ
     * @param $value
     * @param $id
     * @param null $specification
     */
    public function __construct($table, $champ, $value, $id, $specification = null)
    {
        //
        $this->table = $table;
        $this->champ = $champ;
        $this->id    = $id;
        $this->value = $value;
        $this->specification = $specification;
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
        $model = DB::table($this->table)->where($this->champ, $this->value)
            ->where('id', '!=', $this->id)->first();

        # dd($model, $this->table, $this->champ, $this->value, $this->id);

        if (isset($model))
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

        if ($this->specification)
        {
            return __('validation.unique', ['attribute' => $this->specification]);
        }

        return __('validation.unique', ['attribute' => Str::ucfirst($this->champ)]);
    }
}
