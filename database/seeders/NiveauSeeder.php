<?php

namespace Database\Seeders;

use App\Models\Formation;
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
        $formation_licence = Formation::where('libelle', 'Licence')->first();
        $formation_master = Formation::where('libelle', 'Master')->first();

        Niveau::insert([
            [
                'libelle'      => 'Licence 1',
                'tag'          => 'L1',
                'formation_id' => $formation_licence->id
            ],
            [
                'libelle'       => 'Licence 2',
                'tag'           => 'L2',
                'formation_id'  => $formation_licence->id
            ],
            [
                'libelle'       => 'Licence 3',
                'tag'           => 'L3',
                'formation_id'  => $formation_licence->id
            ],
            [
                'libelle'       => 'Master 1',
                'tag'           => 'M1',
                'formation_id'  => $formation_master->id
            ],
            [
                'libelle'       => 'Master 2',
                'tag'           => 'M2',
                'formation_id'  => $formation_master->id
            ],
        ]);
    }
}
