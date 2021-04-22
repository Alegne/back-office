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
        'route'  => '', #'admin',
        'icon'   => 'tachometer-alt',
    ],
    'Annee Universitaire' => [
        'icon' => 'university',
        'role'   => 'administratif',
        'children' => [
            [
                'name'  => 'All',
                'role'  => 'administratif',
                'route' => 'annee-universitaire.index',
            ],
            [
                'name'  => 'Add',
                'role'  => 'administratif',
                'route' => 'annee-universitaire.create',
            ],
        ],
    ],
    'Etudiants' => [
        'icon' => 'users',
        'role'   => 'administratif',
        'children' => [
            [
                'name'  => 'All Etudiants',
                'role'  => 'administratif',
                'route' => 'etudiant.index',
            ],
            [
                'name'  => 'Actif Etudiants',
                'role'  => 'administratif',
                'route' => 'etudiant.indexactif',
            ],
            [
                'name'  => 'Ancien Etudiants',
                'role'  => 'administratif',
                'route' => 'etudiant.indexold',
            ],
            [
                'name'  => 'Add',
                'role'  => 'administratif',
                'route' => 'etudiant.create',
            ]
        ],
    ],
    'Enseignants' => [
        'icon' => 'chalkboard-teacher',
        'role'   => 'administratif',
        'children' => [
            [
                'name'  => 'All ',
                'role'  => 'administratif',
                'route' => 'enseignant.index',
            ],
            [
                'name'  => 'Add',
                'role'  => 'administratif',
                'route' => 'enseignant.create',
            ]
        ],
    ],
    'Matieres' => [
        'icon' => 'book',
        'role'   => 'pedagogique',
        'children' => [
            [
                'name'  => 'All ',
                'role'  => 'pedagogique',
                'route' => 'matiere.index',
            ],
            [
                'name'  => 'Add',
                'role'  => 'pedagogique',
                'route' => 'matiere.create',
            ]
        ],
    ],
    'Comptes' => [
        'icon' => 'user',
        'role'   => 'admin',
        'children' => [
            [
                'name'  => 'All',
                'role'  => 'admin',
                'route' => 'user.index',
            ],
            [
                'name'  => 'Add',
                'role'  => 'admin',
                'route' => 'user.create',
            ],
        ],
    ],
    'Formations' => [
        'icon' => 'pager',
        'role'   => 'admin',
        'children' => [
            [
                'name'  => 'All Formations',
                'role'  => 'admin',
                'route' => 'formation.index', #'formations.index',
            ],
            [
                'name'  => 'Add Formations',
                'role'  => 'admin',
                'route' => 'formation.create', #'formations.indexnew',
            ],
            [
                'name'  => 'fake',
                'role'  => 'admin',
                'route' => '', #'formations.edit',
            ],
        ],
    ],
    'Niveaux' => [
        'icon' => 'school',
        'role'   => 'administratif',
        'children' => [
            [
                'name'  => 'All Niveaux',
                'role'  => 'administratif',
                'route' => 'niveau.index',
            ],
            [
                'name'  => 'New Niveaux',
                'role'  => 'administratif',
                'route' => 'niveau.create',
            ],
        ],
    ],
    'Parcours' => [
        'icon' => 'graduation-cap',
        'role'   => 'administratif',
        'children' => [
            [
                'name'  => 'All Parcours',
                'role'  => 'administratif',
                'route' => 'parcours.index',
            ],
            [
                'name'  => 'Add Parcours',
                'role'  => 'administratif',
                'route' => 'parcours.create',
            ]
        ],
    ],
    'Emploi du temps' => [
        'role'   => 'pedadogique',
        'icon'   => 'calendar-alt',
        'children' => [
            [
                'name'  => 'All',
                'role'  => 'pedadogique',
                'route' => 'emploi-du-temps.index',
            ],
            [
                'name'  => 'Add',
                'role'  => 'pedadogique',
                'route' => 'emploi-du-temps.create',
            ],
        ],
    ],
    'Evenements' => [
        'icon' => 'newspaper',
        'role'   => 'annonceur',
        'children' => [
            [
                'name'  => 'All Evenements',
                'role'  => 'annonceur',
                'route' => 'emploi-du-temps.index',
            ],
            [
                'name'  => 'Add Evenements',
                'role'  => 'annonceur',
                'route' => 'emploi-du-temps.create',
            ],
        ],
    ],
    'Annonces' => [
        'icon' => 'scroll',
        'role'   => 'annonceur',
        'children' => [
            [
                'name'  => 'All Annonces',
                'role'  => 'annonceur',
                'route' => 'annonce.index',
            ],
            [
                'name'  => 'Add Annonces',
                'role'  => 'annonceur',
                'route' => 'annonce.create',
            ],
        ],
    ],
    'SEO' => [
        'role'   => 'admin',
        'route'  => '', #'admin',
        'icon'   => 'network-wired',
    ],
    'Pages' => [
        'icon' => 'book',
        'role'   => 'admin',
        'children' => [
            [
                'name'  => 'Contenu',
                'role'  => 'admin',
                'route' => 'configuration.contenu',
            ],
            [
                'name'  => 'Apropos',
                'role'  => 'admin',
                'route' => '',
            ],
            [
                'name'  => 'Langue',
                'role'  => 'admin',
                'route' => '',
            ],
            [
                'name'  => 'Lien',
                'role'  => 'admin',
                'route' => 'configuration.lien',
            ],
            [
                'name'  => 'Contact',
                'role'  => 'admin',
                'route' => 'configuration.contact',
            ],
        ],
    ],
    'Club' => [
        'icon' => 'kaaba',
        'role'   => 'redacteur',
        'children' => [
            [
                'name'  => 'All Club',
                'role'  => 'redacteur',
                'route' => 'club.index',
            ],
            [
                'name'  => 'Add Club',
                'role'  => 'redacteur',
                'route' => 'club.create',
            ],
            [
                'name'  => 'Staff',
                'role'  => 'redacteur',
                'route' => '', #'comments.indexnew',
            ]
        ],
    ],
    'Article' => [
        'icon' => 'blog',
        'role'   => 'redacteur',
        'children' => [
            [
                'name'  => 'All Article',
                'role'  => 'redacteur',
                'route' => 'article.index',
            ],
            [
                'name'  => 'Add Article',
                'role'  => 'redacteur',
                'route' => 'article.create',
            ]
        ],
    ],
    'Message' => [
        'role'   => 'admin',
        'route'  => 'message.index',
        'icon'   => 'id-card',
    ],
    'NewsLetter' => [
        'role'   => 'admin',
        'route'  => 'newsletter.index',
        'icon'   => 'envelope-open-text',
    ],
    'Album' => [
        'icon' => 'image',
        'role'   => 'admin',
        'children' => [
            [
                'name'  => 'All Album',
                'role'  => 'admin',
                'route' => '', #'niveaux.index',
            ],
            [
                'name'  => 'Add Album',
                'role'  => 'admin',
                'route' => '', #'niveaux.index',
            ],
            [
                'name'  => 'Categories',
                'role'  => 'admin',
                'route' => '', #'comments.indexnew',
            ]
        ],
    ],
    'ENT' => [
        'role'   => 'admin',
        'icon'   => 'folder',
        'children' => [
            [
                'name'  => 'All',
                'role'  => 'admin',
                'route' => 'espace-numerique-travail.index',
            ],
            [
                'name'  => 'Add',
                'role'  => 'admin',
                'route' => 'espace-numerique-travail.create',
            ],
        ]
    ],
    'Journal' => [
        'role'   => 'admin',
        'route'  => '', #'admin',
        'icon'   => 'newspaper',
    ],
    'Parametres' => [
        'role'   => 'admin',
        'route'  => '', #'admin',
        'icon'   => 'cog',
    ],
];
