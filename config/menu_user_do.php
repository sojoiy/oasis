<?php

// Aside menu
return [

    'items' => [
        // Dashboard
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
            'title' => 'Dossiers Maintenance',
            'icon' => 'media/svg/icons/Layout/Layout-4-blocks.svg',
            'bullet' => 'line',
            'page' => '/chantier/received'
        ],
        [
            'title' => 'Livraison',
            'icon' => 'media/svg/icons/Layout/Layout-4-blocks.svg',
            'bullet' => 'line',
            'page' => '/livraisons/lister'
        ],
        [
            'title' => 'Avis de RDV',
            'icon' => 'media/svg/icons/Layout/Layout-4-blocks.svg',
            'bullet' => 'line',
            'page' => '/rdv/lister'
        ],
        [
            'title' => 'Autorisations globales',
            'icon' => 'media/svg/icons/Layout/Layout-4-blocks.svg',
            'bullet' => 'line',
            'page' => '/chantier/listeglobale'
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
        ],
        [
			'title' => 'Mes paramètres',
            'icon' => 'media/svg/icons/Shopping/Barcode-read.svg',
            'bullet' => 'dot',
            'root' => true,
            'submenu' =>  [
				[
                    'title' => 'Paramètres',
		            'submenu' =>  [
						[
		                    'title' => 'Paramètres',
		                    'page' => '/societe/completerprofil'
		                ],
		                [
		                    'title' => 'Abonnement',
		                    'page' => '/comptes/abonnement'
						],
		                [
		                    'title' => 'Dossiers Intervenants',
		                    'page' => '/comptes/validation'
						],
		                [
		                    'title' => 'Dossiers Véhicules',
		                    'page' => '/comptes/abonnement'
						],
		                [
		                    'title' => 'Groupes',
		                    'page' => '/comptes/profils'
						]
		            ]
                ],
                [
                    'title' => 'Habilitations',
                    'page' => '/comptes/habilitations'
				],
                [
                    'title' => 'Livraisons',
                    'page' => '/comptes/livraison'
				],
                [
                    'title' => 'Pièces',
                    'page' => '/comptes/livraison'
				],
                [
                    'title' => 'Services',
                    'page' => '/comptes/services'
				],
                [
                    'title' => 'Validation',
                    'page' => '/comptes/configuration'
				]
            ]
        ],
    ]
];
