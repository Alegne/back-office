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
                'valeur' => "_",
            ],
            [
                'cle' => 'image_directeur',
                'valeur' => 'image.png',
            ],
            [
                'cle' => 'nom_directeur',
                'valeur' => '_',
            ],
            [
                'cle' => 'lien_facebook',
                'valeur' => '_',
            ],
            [
                'cle' => 'lien_twitter',
                'valeur' => '_',
            ],
            [
                'cle' => 'lien_youtube',
                'valeur' => '_',
            ],
            [
                'cle' => 'lien_instagram',
                'valeur' => '_',
            ],
            [
                'cle' => 'lien_map',
                'valeur' => '_',
            ],
            [
                'cle' => 'telephone',
                'valeur' => '_',
            ],
            [
                'cle' => 'email',
                'valeur' => 'email@eni.mg',
            ],
            [
                'cle' => 'adresse',
                'valeur' => 'tanambao',
            ],
            [
                'cle' => 'apropos_informations',
                'valeur' => "_",
            ],
            [
                'cle' => 'apropos_historiques',
                'valeur' => "_",
            ],
            [
                'cle' => 'apropos_missions',
                'valeur' => "_",
            ],
            [
                'cle' => 'apropos_specifications',
                'valeur' => "_",
            ],
            [
                'cle' => 'apropos_reference',
                'valeur' => "_",
            ],
            [
                'cle' => 'apropos_albums',
                'valeur' => "_",
            ],

        ]);
    }
}
