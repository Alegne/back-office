<?php

namespace Database\Seeders;

use App\Models\Annonce;
use App\Models\Niveau;
use App\Models\Parcours;
use Illuminate\Database\Seeder;

class AnnonceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 2 indicates the number of records
        $niveaux = Niveau::inRandomOrder()->limit(2)->get();

        // get one random record
        $parcours = Parcours::inRandomOrder()->first();

        for ($i = 1; $i <= 50; $i++)
        {
            $annonce = Annonce::factory()
                # ->count(10)
                # ->forClub($club)
                ->create();

            $annonce->niveau()->attach($niveaux);
            $annonce->parcours()->attach($parcours);
        }



    }
}
