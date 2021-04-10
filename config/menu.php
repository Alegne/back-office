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
    'Comptes' => [
        'icon' => 'user',
        'role'   => 'admin',
        'children' => [
            [
                'name'  => 'All comptes',
                'role'  => 'admin',
                'route' => '', #'comptes.index',
            ],
            [
                'name'  => 'New comptes',
                'role'  => 'admin',
                'route' => '', #'comptes.indexnew',
            ],
            [
                'name'  => 'Add',
                'role'  => 'admin',
                'route' => '', #'comptes.create',
            ],
            [
                'name'  => 'fake',
                'role'  => 'admin',
                'route' => '', #'comptes.edit',
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
        'role'   => 'administratif',
        'route'  => '', #'admin',
        'icon'   => 'calendar-alt',
    ],
    'Evenements' => [
        'icon' => 'newspaper',
        'role'   => 'annonceur',
        'children' => [
            [
                'name'  => 'All Evenements',
                'role'  => 'annonceur',
                'route' => '', #'niveaux.index',
            ],
            [
                'name'  => 'New Evenements',
                'role'  => 'annonceur',
                'route' => '', #'comments.indexnew',
            ],
            [
                'name'  => 'Add Evenements',
                'role'  => 'annonceur',
                'route' => '', #'comments.indexnew',
            ],
            [
                'name'  => 'fake',
                'role'  => 'annonceur',
                'route' => '', #'comments.edit',
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
                'route' => '', #'niveaux.index',
            ],
            [
                'name'  => 'New Annonces',
                'role'  => 'annonceur',
                'route' => '', #'comments.indexnew',
            ],
            [
                'name'  => 'Add Annonces',
                'role'  => 'annonceur',
                'route' => '', #'comments.indexnew',
            ],
            [
                'name'  => 'fake',
                'role'  => 'annonceur',
                'route' => '', #'comments.edit',
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
                'name'  => 'Photo Slide',
                'role'  => 'admin',
                'route' => '', #'niveaux.index',
            ],
            [
                'name'  => 'Contenu',
                'role'  => 'admin',
                'route' => '', #'comments.indexnew',
            ],
            [
                'name'  => 'Apropos',
                'role'  => 'admin',
                'route' => '', #'comments.indexnew',
            ],
            [
                'name'  => 'Langue',
                'role'  => 'admin',
                'route' => 'langue.index',
            ],
            [
                'name'  => 'Lien',
                'role'  => 'admin',
                'route' => '', #'comments.indexnew',
            ],
            [
                'name'  => 'Contact',
                'role'  => 'admin',
                'route' => '', #'comments.indexnew',
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
                'route' => '', #'niveaux.index',
            ],
            [
                'name'  => 'New Article',
                'role'  => 'redacteur',
                'route' => '', #'comments.indexnew',
            ],
            [
                'name'  => 'Add Article',
                'role'  => 'redacteur',
                'route' => '', #'comments.indexnew',
            ]
        ],
    ],
    'NewsLetter' => [
        'role'   => 'admin',
        'route'  => '', #'admin',
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
        'route'  => '', #'admin',
        'icon'   => 'folder',
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
