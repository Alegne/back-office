<?php

namespace Database\Seeders;

use App\Models\AnneeUniversitaire;
use Illuminate\Database\Seeder;

class AnneUniversitaireSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AnneeUniversitaire::create([
            [
                'libelle' => '2020-2021'
            ],
            [
                'libelle' => '2019-2020'
            ],
            [
                'libelle' => '2018-2019'
            ],
            [
                'libelle' => '2017-2018'
            ],

        ]);
    }
}
