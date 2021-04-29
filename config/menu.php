<?php

/**
 * Created by PhpStorm.
 * User: NRH
 * Date: 05/04/2021
 * Time: 19:00
 */

return [

    /*
    |--------------------------------------------------------------------------
    | Menu Sidebar Admin
    |--------------------------------------------------------------------------
    |
    | Set Menu
    */

    'Dashboard' => [
        'role'   => 'user',
        'route'  => 'dashboard.webcup',
        'icon'   => 'tachometer-alt',
    ],
    'Activites' => [
        'icon' => 'school',
        'role'   => 'redacteur',
        'children' => [
            [
                'name'  => 'Clubs',
                'role'  => 'redacteur',
                'route' => 'club.index',
            ],
            [
                'name'  => 'Articles',
                'role'  => 'redacteur',
                'route' => 'article.index',
            ]
        ]
    ],
    'Actualites' => [
        'icon' => 'book',
        'role'   => 'annonceur',
        'children' => [
            [
                'name'  => 'Albums ',
                'role'  => 'annonceur',
                'route' => 'album.index',
            ],
            [
                'name'  => 'Annonces ',
                'role'  => 'annonceur',
                'route' => 'annonce.index',
            ],
            [
                'name'  => 'Nouvelles',
                'role'  => 'annonceur',
                'route' => 'evenement.index',
            ]
        ],
    ],
    'Messages' => [
        'icon' => 'envelope',
        'role'   => 'admin',
        'children' => [
            [
                'name'  => 'News letters',
                'role'  => 'admin',
                'route' => 'newsletter.index',
            ],
            [
                'name'  => 'Messages',
                'role'  => 'admin',
                'route' => 'message.index',
            ]
        ]
    ],
    'Pedadogique' => [
        'icon' => 'university',
        'role'   => 'pedagogique',
        'children' => [
            [
                'name'  => 'Annee Universitaire',
                'role'  => 'pedagogique',
                'route' => 'annee-universitaire.index',
            ],
            [
                'name'  => 'Emploi du Temps',
                'role'  => 'pedagogique',
                'route' => 'emploi-du-temps.index',
            ],
            [
                'name'  => 'Enseignants',
                'role'  => 'pedagogique',
                'route' => 'enseignant.index',
            ],
            [
                'name'  => 'ENT',
                'role'  => 'pedagogique',
                'route' => 'espace-numerique-travail.index',
            ],
            [
                'name'  => 'Etudiants',
                'role'  => 'pedagogique',
                'route' => 'etudiant.index',
            ],
            [
                'name'  => 'Formations',
                'role'  => 'pedagogique',
                'route' => 'formation.index',
            ],
            [
                'name'  => 'Matieres',
                'role'  => 'pedagogique',
                'route' => 'matiere.index',
            ],
            [
                'name'  => 'Niveaux',
                'role'  => 'pedagogique',
                'route' => 'niveau.index',
            ],
            [
                'name'  => 'Parcours',
                'role'  => 'pedagogique',
                'route' => 'parcours.index',
            ],
        ],
    ],
    'Parametres' => [
        'icon' => 'cog',
        'role'   => 'admin',
        'children' => [
            [
                'name'  => 'Comptes',
                'role'  => 'admin',
                'route' => 'user.index',
            ],
            [
                'name'  => 'Pages',
                'role'  => 'admin',
                'route' => 'configuration.index',
            ],
            [
                'name'  => 'Journal',
                'role'  => 'admin',
                'route' => '',
            ],
            [
                'name'  => 'SEO',
                'role'  => 'admin',
                'route' => '',
            ]
        ]
    ]
];
