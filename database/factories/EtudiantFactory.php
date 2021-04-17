<?php

namespace Database\Factories;

use App\Models\Etudiant;
use Illuminate\Database\Eloquent\Factories\Factory;

class EtudiantFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Etudiant::class;
    protected static $i = 0;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'numero'            => 'ET' . ($this->faker->numberBetween(1, 999) * 10) . $this->faker->word.EtudiantFactory::$i++,
            'nom'               => $this->faker->lastName,
            'prenom'            => $this->faker->firstName,
            'email'             => $this->faker->unique()->safeEmail,
            'email_verified_at' => now(),
            'password'          => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password,
            'cin'               => '1234567890',
            'date_naissance'    => $this->faker->dateTimeBetween($startDate = '-20 years', $endDate = 'now', $timezone = null),
            'lieu_naissance'    => $this->faker->address,
            'adresse'           => $this->faker->address,
            'status'            => $this->faker->boolean(80) ? 'actif' : 'ancien',
        ];
    }
}
