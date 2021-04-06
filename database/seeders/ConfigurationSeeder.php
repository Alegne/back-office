<?php

namespace Database\Seeders;

use App\Models\Configuration;
use Illuminate\Database\Seeder;

class ConfigurationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        # mot_directeur
        # image_directeur
        # nom_directeur
        # lien_facebook
        # lien_twitter
        # lien_youtube
        # lien_map
        # téléphone
        # email
        # adresse

        Configuration::insert([
            [
                'cle' => 'mot_directeur',
                'valeur' => "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book",
            ],
            [
                'cle' => 'image_directeur',
                'valeur' => 'image.png',
            ],
            [
                'cle' => 'nom_directeur',
                'valeur' => 'Monsieur Bertin Olivier',
            ],
            [
                'cle' => 'lien_facebook',
                'valeur' => 'facebook',
            ],
            [
                'cle' => 'lien_twitter',
                'valeur' => 'twitter',
            ],
            [
                'cle' => 'lien_youtube',
                'valeur' => 'youtube',
            ],
            [
                'cle' => 'lien_instagram',
                'valeur' => 'instagram',
            ],
            [
                'cle' => 'lien_map',
                'valeur' => 'lien_map',
            ],
            [
                'cle' => 'telephone',
                'valeur' => '0341202021',
            ],
            [
                'cle' => 'email',
                'valeur' => 'email@eni.mg',
            ],
            [
                'cle' => 'adresse',
                'valeur' => 'tanambao',
            ],

        ]);
    }
}
