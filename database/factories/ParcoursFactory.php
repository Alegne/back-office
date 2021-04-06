<?php

namespace Database\Factories;

use App\Models\Parcours;
use Illuminate\Database\Eloquent\Factories\Factory;

class ParcoursFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Parcours::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'tag'
        ];
    }
}
