<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        # Users
        User::withoutEvents(function () {
            // Create 1 admin
            User::factory()->create([
                'role' => 'admin',
            ]);

            // Create 2 redacteurs
            User::factory()->count(2)->create([
                'role' => 'redacteur',
            ]);

            // Create 2 annonceurs
            User::factory()->count(2)->create([
                'role' => 'annonceur',
            ]);

            // Create 2 pedagogiques
            User::factory()->count(2)->create([
                'role' => 'pedagogique',
            ]);

            // Create 2 users
            User::factory()->count(2)->create();
        });

        # Call Seeder
        $this->call([
            FormationSeeder::class,
            NiveauSeeder::class,
            ParcoursSeeder::class,
            AnneUniversitaireSeeder::class,
            LangueSeeder::class,
            ConfigurationSeeder::class,
            EtudiantSeeder::class,
            NewsletterSeeder::class,
            ClubSeeder::class,
            ArticleSeeder::class,
            AnnonceSeeder::class,
            EvenementSeeder::class,
            EnseignantSeeder::class
        ]);
    }
}
