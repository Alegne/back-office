<?php

namespace Database\Seeders;

use App\Models\Parcours;
use Illuminate\Database\Seeder;
use Psy\Util\Str;

class ParcoursSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Parcours::insert([
            [
                'libelle' => 'Genie Logiciel et Base des donnees',
                'tag'     => 'GB',
            ],
            [
                'libelle' => 'Administration et Systeme de reseaux',
                'tag'     => 'SR',
            ],
            [
                'libelle' => 'Informatique general [Hybride]',
                'tag'     => 'IG',
            ],
        ]);
    }
}
