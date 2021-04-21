<?php

namespace Database\Factories;

use App\Models\EmploiTemps;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class EmploiTempsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = EmploiTemps::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $date = $this->faker->dateTimeBetween('-1 years');
        return [
            'date_debut' => $date,
            'date_fin'   => Carbon::parse($date)->addDays(7)
        ];
    }
}
