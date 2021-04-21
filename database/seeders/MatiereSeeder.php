<?php

namespace Database\Seeders;

use App\Models\EmploiTemps;
use App\Models\EmploiTempsItem;
use App\Models\Enseignant;
use App\Models\Matiere;
use App\Models\Niveau;
use App\Models\Parcours;
use Illuminate\Database\Seeder;

class MatiereSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $parcours           = Parcours::get();
        $niveaux            = Niveau::get();
        $enseignants        = Enseignant::get();

        foreach ($enseignants as $enseignant)
        {
            foreach ($parcours as $parcour) # GB | SR | IG
            {
                foreach ($niveaux as $niveau) # L1 | L2 | L3 | M1 | M2
                {
                    # for ($i = 1; $i <= 1; $i++)
                    # {
                        $matiere = Matiere::factory()
                            # ->count(2)
                            ->create([
                                'niveau_id'            => $niveau->id,
                                'enseignant_id'        => $enseignant->id,
                            ]);

                        $matiere->parcours()->attach($parcour->id);

                    $item = EmploiTemps::factory()
                        # ->count(2)
                        ->create([
                            'niveau_id'       => $niveau->id,
                            'annee_id'        => 1,
                        ]);

                    $item->parcours()->attach($parcour->id);
                    # }

                }
            }
        }

    }
}
