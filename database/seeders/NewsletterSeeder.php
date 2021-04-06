<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class NewsletterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Newsletter::factory(5)->create();
    }
}
