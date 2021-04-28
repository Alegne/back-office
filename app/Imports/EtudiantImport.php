<?php

namespace App\Imports;

use App\Models\AnneeUniversitaireLibelle;
use App\Models\Etudiant;
use App\Models\Niveau;
use App\Models\Parcours;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;

class EtudiantImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return Etudiant
     */
    public function model(array $row)
    {
        # dd($row);

        /*array:12 [
        0 => "Numero"
  1 => "Nom"
  2 => "Prenom"
  3 => "Email"
  4 => "CIN"
  5 => "Date de Naissance"
  6 => "Lieu de Naissance"
  7 => "Adresse"
  8 => "Parcours"
  9 => "Niveau"
  10 => "Status"
  11 => "Annee Univeristaire"
]*/
        # new Etudiant([])

        $inputs = [
            'numero'         => $row[0],
            'nom'            => $row[1],
            'prenom'         => $row[2],
            'email'          => $row[3],
            'cin'            => $row[4],
            'date_naissance' => $row[5],
            'lieu_naissance' => $row[6],
            'adresse'        => $row[7],
            'status'         => $row[10],
            'password'       => Hash::make('password'),
            'parcours_id'    => Parcours::where('tag', $row[8])->first()->id,
            # 'niveau'         => $row['Niveau'],
            # 'annee'          => $row['Annee Univeristaire'],
        ];

        $etudiant = Etudiant::create($inputs);

        # $parcours = Parcours::where('tag', $row['Parcours'])->first();
        $niveau   = Niveau::where('tag', $row[9])->first();
        $annee    = AnneeUniversitaireLibelle::where('libelle', $row[11])->first();


        $etudiant->niveau()->attach($niveau->id);

        DB::table('cactus_annee_universitaires')
            ->where('etudiant_id', $etudiant->id)
            ->where('niveau_id', $niveau->id)
            ->update([
                'annee_id' => $annee->id
            ]);

        return $etudiant;
    }
}
