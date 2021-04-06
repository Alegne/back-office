<?php

namespace Database\Factories;

use App\Models\Enseignant;
use Illuminate\Database\Eloquent\Factories\Factory;

class EnseignantFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Enseignant::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nom'               => $this->faker->lastName,
            'prenom'            => $this->faker->firstName,
            'email'             => $this->faker->unique()->safeEmail,
            'titre'             => $this->faker->word,
            'grade'             => $this->faker->word,
            'identifiant'       => $this->faker->lastName . '' . $this->faker->numberBetween(1, 20),
            'mot_de_passe'      => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password,
            'telephone'         => '' . 1201111111111,
            'adresse'           => $this->faker->address,
        ];
    }
}
