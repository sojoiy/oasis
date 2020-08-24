<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
	
	public function nomSociete()
	{
		$mandant = Societe::find($this->societeID);
		return $mandant->raisonSociale;
	}
	
	public function nomService()
	{
		if($this->service)
		{
			$service = Service::find($this->service);
			return $service->libelle;
		}
		
		return "N.C.";
	}
	
	public function validation_indiv()
	{
		$societe = Societe::find($this->societeID);
		$validation = json_decode($societe->validation_chantier);
		return ($validation->pieces == 1) ? true : false;
	}
			
	public function validation_forte()
	{
		$societe = Societe::find($this->societeID);
		return ($societe->validation_forte) ? true : false;
	}
		
	public function initiales()
	{
		return substr($this->prenom, 0, 1).substr($this->nom, 0, 1);
	}
	
	public function choix_po()
	{
		$societe = Societe::find($this->societeID);
		return $societe->choix_po;
	}
	
	public function choix_hab()
	{
		$societe = Societe::find($this->societeID);
		return $societe->choix_hab;
	}
	
	public function complet()
	{
		$societe = Societe::find($this->societeID);
		
		$nombre_groupes = Profil::where('societe', $this->societeID)->count();
		$type_chantier_good = DoChantier::where('do', $this->societeID)->count();
		$valideur_intervenants = Profil::where('societe', $this->societeID)->where('validation_entites', 1)->count();
		
		if($nombre_groupes > 0 && $type_chantier_good > 0 && $valideur_intervenants > 0)
		{
			$societe->completude = 1;
			$societe->save();
		}
		else
		{
			$societe->completude = 0;
			$societe->save();
		}
		
		if($this->groupe == "compte" || $this->do == 0)
			return true;
			
		return ($societe->completude) ? true : false;
	}
	
	public function getMenu()
	{
		$rights = $items = array();
		
		if($this->admin)
		{
			$items[] = array([
							'title' => 'Chantier en cours',
				            'icon' => 'media/svg/icons/Layout/Layout-4-blocks.svg',
				            'bullet' => 'line',
				            'page' => '/admin/chantiers'
				        ]);
			
			$items[] = array([
							'title' => 'Prestataires',
				            'icon' => 'media/svg/icons/Layout/Layout-4-blocks.svg',
				            'bullet' => 'line',
				            'page' => '/admin/prestataires'
				        ]);
							
			$items[] = array('title' => 'Paramètres',
		            'icon' => 'media/svg/icons/Layout/Layout-4-blocks.svg',
		            'bullet' => 'line',
		            'root' => true,
		            'submenu' => [
		                [
							'title' => 'Pièces',
		                    'page' => '/parametres/pieces',
			            ],
						[
			                'title' => 'Habilitations',
			                'page' => '/parametres/habilitations',
			            ],
			            [
			                'title' => 'Chantiers',
			                'page' => '/admin/type_chantier',
			            ],
			            [
			                'title' => 'Livraisons',
			                'page' => '/admin/type_livraison',
						]
		            ]);
			
			$items[] = array('title' => 'Notifications',
		            'icon' => 'media/svg/icons/Layout/Layout-4-blocks.svg',
		            'bullet' => 'line',
		            'root' => true,
		            'submenu' => [
		                [
							'title' => 'DO',
		                    'page' => '/admin/notifdo',
			            ],
						[
			                'title' => 'Presta',
			                'page' => '/admin/notifpresta',
			            ]
		            ]);
			
			$items[] = array('title' => 'Zones Géographiques',
		            'icon' => 'media/svg/icons/Layout/Layout-4-blocks.svg',
		            'bullet' => 'line',
		            'root' => true,
		            'submenu' => [
		                [
							'title' => 'Zones',
		                    'page' => '/admin/zonesgeo',
			            ],
						[
			                'title' => 'Pays',
			                'page' => '/admin/pays',
			            ],
						[
			                'title' => 'Profils',
			                'page' => '/admin/profils',
			            ]
		            ]);
							
			return $items;
		}
		
		if($this->do)
		{
			$rights["validation_pieces"] = ($this->validation_pieces) ? true : false;
			$rights["rejuger_pieces"] = ($this->checkRights("rejuger_pieces")) ? true : false;
			$rights["validation_gloable"] = ($this->validation_gloable) ? true : false;
			$rights["validation_indiv"] = ($this->validation_indiv()) ? true : false;
			
			if($this->groupe == 'user')
			{
				$items[] = array('title' => 'Mon compte',
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
			            ]);
				
				$items[] = array('title' => 'Mes ressources',
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
			            ]);
			}
								
			$items[] = array([
							'title' => 'Dossiers Emis',
				            'icon' => 'media/svg/icons/Layout/Layout-4-blocks.svg',
				            'bullet' => 'line',
				            'page' => '/chantier/sent'
				        ]);
							
			$items[] = array([
							'title' => 'Dossiers Reçus',
				            'icon' => 'media/svg/icons/Layout/Layout-4-blocks.svg',
				            'bullet' => 'line',
				            'page' => '/chantier/received'
				        ]);
			
			$items[] = array([
	            'title' => 'Dossiers Maintenance',
	            'icon' => 'media/svg/icons/Layout/Layout-4-blocks.svg',
	            'bullet' => 'line',
	            'page' => '/chantier/received'
				        ]);
			
			$items[] = array([
	            'title' => 'Livraison',
	            'icon' => 'media/svg/icons/Layout/Layout-4-blocks.svg',
	            'bullet' => 'line',
	            'page' => '/livraisons/lister'
				        ]);
			
			$items[] = array([
	            'title' => 'Avis de RDV',
	            'icon' => 'media/svg/icons/Layout/Layout-4-blocks.svg',
	            'bullet' => 'line',
	            'page' => '/rdv/lister'
				        ]);
				
			if($rights["validation_pieces"])
			{
				$items[] = array([
		            'title' => 'Attribuer un RDV',
		            'icon' => 'media/svg/icons/Layout/Layout-4-blocks.svg',
		            'bullet' => 'line',
		            'page' => '/chantier/rdv'
					        ]);
			}
			
			if($rights["validation_pieces"])
			{
				$items[] = array([
		            'title' => 'Pièces à valider',
		            'icon' => 'media/svg/icons/Layout/Layout-4-blocks.svg',
		            'bullet' => 'line',
		            'page' => '/chantier/pieces'
					        ]);
			}
			
			if($rights["rejuger_pieces"])
			{
				$items[] = array([
		            'title' => 'Pièces invalidées',
		            'icon' => 'media/svg/icons/Layout/Layout-4-blocks.svg',
		            'bullet' => 'line',
		            'page' => '/chantier/piecesrefusees'
					        ]);
			}
			
			if($rights["validation_gloable"])
			{
				$items[] = array([
		            'title' => 'Autorisations globales',
		            'icon' => 'media/svg/icons/Layout/Layout-4-blocks.svg',
		            'bullet' => 'line',
		            'page' => '/chantier/listeglobale'
					        ]);
			}
			
			if($this->groupe == 'user')
			{
				$items[] = array(
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
		            ]);
							
				$items[] = array(
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
		                    'page' => '/comptes/pieces'
						],
		                [
		                    'title' => 'Services',
		                    'page' => '/comptes/services'
						],
		                [
		                    'title' => 'Validation',
		                    'page' => '/comptes/configuration'
						]
		            ]);
			}
					
			return $items;
		}
		else
		{
			$items[] = array('title' => 'Mon compte',
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
			                'title' => 'Comptes',
			                'page' => '/societe/comptes',
			            ],
			            [
			                'title' => 'Communication',
			                'page' => '/societe/communication',
			            ],
			            [
			                'title' => 'Abonnements',
			                'page' => '/societe/abonnement',
						]
		            ]);
			
			$items[] = array('title' => 'Mes ressources',
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
		            ]);
							
			$items[] = array([
							'title' => 'Chantiers Emis',
				            'icon' => 'media/svg/icons/Layout/Layout-4-blocks.svg',
				            'bullet' => 'line',
				            'page' => '/chantier/sent'
				        ]);
			
			$items[] = array([
							'title' => 'Chantiers Reçus',
				            'icon' => 'media/svg/icons/Layout/Layout-4-blocks.svg',
				            'bullet' => 'line',
				            'page' => '/chantier/received'
				        ]);
			
			$items[] = array([
							'title' => 'Chantiers Virtuels',
				            'icon' => 'media/svg/icons/Layout/Layout-4-blocks.svg',
				            'bullet' => 'line',
				            'page' => '/chantier/virtuels'
				        ]);

			$items[] = array([
				            'title' => 'Livraisons reçues',
				            'icon' => 'media/svg/icons/Layout/Layout-4-blocks.svg',
				            'bullet' => 'line',
				            'page' => '/livraisons/received'
				        ]);

			$items[] = array([
				            'title' => 'Livraisons émises',
				            'icon' => 'media/svg/icons/Layout/Layout-4-blocks.svg',
				            'bullet' => 'line',
				            'page' => '/livraisons/received'
				        ]);
			
			return $items;
		}
	}
	
	public function checkRights($niveau)
	{
		if($this->profil)
		{
			$profil = Profil::find($this->profil);
			
			switch($niveau)
			{
				case "valider_rdv" :
					return ($profil->validation_entites) ? true : false;
					break;
				case "initier_chantier" :
					return ($profil->initier_chantier) ? true : false;
					break;
				case "visualiser_pieces" :
					return ($profil->visualiser_pieces) ? true : false;
					break;
				case "telecharger_pieces" :
					return ($profil->telecharger_pieces) ? true : false;
					break;
				case "rejuger_pieces" :
					return ($profil->rejuger_pieces) ? true : false;
					break;
			}
		}
		elseif($this->do == 0)
		{
			$rights["validation_pieces"] = false;
			$rights["rejuger_pieces"] = false;
			$rights["validation_gloable"] = false;
			$rights["validation_indiv"] = false;
		}elseif($this->groupe == "user" && $this->do == 1)
			return true;
			
		return false;
	}
		
	public function hasProfile($chantier, $niveau)
	{
		$chantier = Chantier::find($chantier);
		$doChantier = DoChantier::find($chantier->type_chantier);
		
		if($doChantier)
		{
			switch($niveau)
			{
				case 1 :
					return ($this->profil == $doChantier->profil_1) ? true : false;
					break;
				case 2 :
					return ($this->profil == $doChantier->profil_2) ? true : false;
					break;
				case 3 :
					return ($this->profil == $doChantier->profil_3) ? true : false;
					break;
			}
		}
		
		return false;
	}
}
