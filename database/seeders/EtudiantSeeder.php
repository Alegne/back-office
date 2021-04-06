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
        # $formation = Formation::factory('libelle', 'Licence')->create();
        # $parcours  = Parcours::where('tag', 'GB')->get();
        # $niveau    = Niveau::where('tag', 'L1')->get();

        $formations = Formation::get();
        $parcours   = Parcours::get();
        $niveaux     = Niveau::get();

        foreach ($formations as $formation)
        {
            foreach ($parcours as $parcour)
            {
                foreach ($niveaux as $niveau)
                {
                    $etudiants = Etudiant::factory()
                        ->count(50)
                        ->forNiveau($niveau)
                        ->forParcours($parcours)
                        ->forFormation($formation)
                        ->create();
                }
            }
        }




    }
}
