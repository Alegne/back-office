<?php

namespace Database\Seeders;

use App\Models\Niveau;
use Illuminate\Database\Seeder;

class NiveauSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Niveau::create([
            [
                'libelle' => 'Licence 1',
                'tag'     => 'L1',
            ],
            [
                'libelle' => 'Licence 2',
                'tag'     => 'L2',
            ],
            [
                'libelle' => 'Licence 3',
                'tag'     => 'IG',
            ],
            [
                'libelle' => 'Master 1',
                'tag'     => 'M1',
            ],
            [
                'libelle' => 'Master 2',
                'tag'     => 'M1',
            ],
        ]);
    }
}
