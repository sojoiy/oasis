<?php

// Aside menu
return [

    'items' => [
        [
            'title' => 'Mon compte',
            'icon' => 'media/svg/icons/Layout/Layout-4-blocks.svg',
            'bullet' => 'line',
            'root' => true,
            'submenu' => [
                [
					'title' => 'Profil',
                    'page' => '/societe/informations',
	            ],
				[
	                'title' => 'Documents',
	                'page' => '/societe/documents',
	            ],
	            [
	                'title' => 'Communication',
	                'page' => '/societe/communication',
	            ],
	            [
	                'title' => 'Abonnements',
	                'page' => '/societe/abonnement',
				]
            ]
        ],
        [
			'title' => 'Mes ressources',
            'icon' => 'media/svg/icons/Shopping/Barcode-read.svg',
            'bullet' => 'dot',
            'root' => true,
            'submenu' =>  [
				[
                    'title' => 'Intervenants',
                    'page' => '/intervenants'
                ],
                [
                    'title' => 'Véhicules',
                    'page' => '/vehicules'
                ],
                [
                    'title' => 'Autres',
                    'page' => '/entite/autres'
				]
            ]
        ],
        [
            'title' => 'Dossiers Emis',
            'icon' => 'media/svg/icons/Layout/Layout-4-blocks.svg',
            'bullet' => 'line',
            'page' => '/chantier/sent'
        ],
        [
            'title' => 'Dossiers Reçus',
            'icon' => 'media/svg/icons/Layout/Layout-4-blocks.svg',
            'bullet' => 'line',
            'page' => '/chantier/received'
        ],
        [
            'title' => 'Dossiers Virtuels',
            'icon' => 'media/svg/icons/Layout/Layout-4-blocks.svg',
            'bullet' => 'line',
            'page' => '/chantier/virtuels'
        ],
        [
            'title' => 'Dossiers Maintenance',
            'icon' => 'media/svg/icons/Layout/Layout-4-blocks.svg',
            'bullet' => 'line',
            'page' => '/chantier/received'
        ],
        [
            'title' => 'Livraison Reçues',
            'icon' => 'media/svg/icons/Layout/Layout-4-blocks.svg',
            'bullet' => 'line',
            'page' => '/livraisons/received'
        ],
        [
            'title' => 'Livraison &Eacute;mises',
            'icon' => 'media/svg/icons/Layout/Layout-4-blocks.svg',
            'bullet' => 'line',
            'page' => '/livraisons/sent'
        ],
        [
			'title' => 'Mes comptes',
            'icon' => 'media/svg/icons/Shopping/Barcode-read.svg',
            'bullet' => 'dot',
            'root' => true,
            'submenu' =>  [
				[
                    'title' => 'Lister',
                    'page' => '/comptes'
                ],
                [
                    'title' => 'Créer',
                    'page' => '/comptes/create'
				]
            ]
        ]
    ]

];
