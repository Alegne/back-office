<?php

namespace Database\Seeders;

use App\Models\Club;
use Illuminate\Database\Seeder;

class ClubSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Club::create([
            [
                'libelle'     => 'Linux',
                'description' => "Lorem Ipsum is simply dummy text of the printing and typesetting industry. "
            ],
            [
                'libelle'     => 'Ente Aide',
                'description' => "Lorem Ipsum is simply dummy text of the printing and typesetting industry. "
            ],
            [
                'libelle'     => 'Danse',
                'description' => "Lorem Ipsum is simply dummy text of the printing and typesetting industry. "
            ],
            [
                'libelle'     => 'Hack',
                'description' => "Lorem Ipsum is simply dummy text of the printing and typesetting industry. "
            ],
        ]);
    }
}
