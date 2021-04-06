<?php

namespace Database\Factories;

use App\Models\Evenement;
use Illuminate\Database\Eloquent\Factories\Factory;

class EvenementFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Evenement::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'titre'         => $this->faker->word,
            'description'   => $this->faker->sentence,
            'date_creation' => now(),
            'posteur'       => $this->faker->name,
            'slug'          => $this->faker->slug,
            'type'          => $this->faker->boolean(70) ? 'actualite' : 'nouvelle',
        ];
    }
}
