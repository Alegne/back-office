<?php

namespace Database\Seeders;

use App\Models\Langue;
use Illuminate\Database\Seeder;

class LangueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Langue::create([
            [
                'libelle'  => 'English',
                'code'     => 'en',
                'flag'     => 'en',
            ],
            [
                'libelle'  => 'French',
                'code'     => 'fr',
                'flag'     => 'fr',
            ],
        ]);
    }
}
