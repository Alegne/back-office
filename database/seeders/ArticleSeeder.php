<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Club;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $clubs = Club::get();

        foreach ($clubs as $club)
        {
            $articles = Article::factory()
                ->count(5)
                ->forClub($club)
                ->create();
        }
    }
}
