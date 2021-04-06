<?php

namespace Database\Seeders;

use App\Models\Etudiant;
use App\Models\Formation;
use App\Models\Niveau;
use App\Models\Parcours;
use Illuminate\Database\Seeder;

class EtudiantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        # $formation = Formation::where('libelle', 'Licence')->first();
        # $parcours  = Parcours::where('tag', 'GB')->first();
        # $niveau    = Niveau::where('tag', 'L1')->first();
        $annee     = Niveau::first();

        /*$user = Etudiant::factory()->create([
            'niveau_id'              => $niveau->id,
            'parcours_id'            => $parcours->id,
            'formation_id'           => $formation->id,
            'annee_universitaire_id' => $annee->id
        ]);*/

        $formation_licence = Formation::where('libelle', 'Licence')->first();
        $formation_master = Formation::where('libelle', 'Master')->first();
        $parcours    = Parcours::get();
        $niveaux     = Niveau::get();

        $licence = ['L1', 'L2', 'L3'];

        #foreach ($formations as $formation) # Licence | Master
        #{
            foreach ($parcours as $parcour) # GB | SR | IG
            {
                foreach ($niveaux as $niveau) # L1 | L2 | L3 | M1 | M2
                {
                    Etudiant::factory()
                        ->count(2)
                        ->create([
                        'niveau_id'              => $niveau->id,
                        'parcours_id'            => $parcour->id,
                        'formation_id'           =>  in_array($niveau->tag, $licence) ?
                                                        $formation_licence->id : $formation_master->id,
                        'annee_universitaire_id' => $annee->id
                    ]);
                }
            }
        #}




    }
}
