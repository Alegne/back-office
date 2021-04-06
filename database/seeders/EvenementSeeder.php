<?php

namespace Database\Seeders;

use App\Models\Evenement;
use Illuminate\Database\Seeder;

class EvenementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $evenements = Evenement::factory()
            ->count(20)
            # ->for($user)
            ->create();
    }
}
