<?php

namespace Database\Seeders;

use App\Models\AnneeUniversitaire;
use App\Models\AnneeUniversitaireLibelle;
use App\Models\Etudiant;
use App\Models\Formation;
use App\Models\Niveau;
use App\Models\Parcours;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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

        /*$user = Etudiant::factory()->create([
            'niveau_id'              => $niveau->id,
            'parcours_id'            => $parcours->id,
            'formation_id'           => $formation->id,
            'annee_universitaire_id' => $annee->id
        ]);*/

        $formation_licence  = Formation::where('libelle', 'Licence')->first();
        $formation_master   = Formation::where('libelle', 'Master')->first();
        $parcours           = Parcours::get();
        $niveaux            = Niveau::get();
        $annee              = AnneeUniversitaireLibelle::where('libelle', '2020-2021')->first();

        $licence = ['L1', 'L2', 'L3'];

        #foreach ($formations as $formation) # Licence | Master
        #{
            foreach ($parcours as $parcour) # GB | SR | IG
            {
                foreach ($niveaux as $niveau) # L1 | L2 | L3 | M1 | M2
                {
                    for ($i = 1; $i <= 50; $i++)
                    {
                        $etudiant = Etudiant::factory()
                            # ->count(2)
                            ->create([
                                'parcours_id'            => $parcour->id,
                                # 'niveau_id'              => $niveau->id,
                                # 'formation_id'           =>  in_array($niveau->tag, $licence) ? $formation_licence->id : $formation_master->id,
                                # 'annee_universitaire_id' => $annee->id
                            ]);

                        $etudiant->niveau()->attach($niveau->id);

                        # $etudiant->annee()->attach($annee->id);

                        DB::table('cactus_annee_universitaires')
                            ->where('etudiant_id', $etudiant->id)
                            ->where('niveau_id', $niveau->id)
                            ->update([
                                'annee_id' => $annee->id
                            ]);

                        # $annee->etudiant_id = $etudiant->id;
                        # $annee->niveau_id   = $niveau->id;
                        # $annee->save();

                        # DB::table('cactus_annee_universitaires')
                        #     ->where('id', $annee->id)
                        #     ->update([
                        #         'etudiant_id' => $etudiant->id,
                        #         'niveau_id' => $niveau->id
                        #     ]);
                    }

                }
            }
        #}

        # $etudiants = Etudiant::get();
        # $etudiant->niveau()->attach($niveau_id);




    }
}
