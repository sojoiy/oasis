<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
// Quick search dummy route to display html elements in search dropdown (header search)
Route::get('/quick-search', 'PagesController@quickSearch')->name('quick-search');

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/account', 'UsersController@account')->name('account');
Route::post('/user/change', 'UsersController@change')->name('change');
Route::post('/user/resetpassword', 'UsersController@resetpassword')->name('resetpassword');
Route::get('/users', 'UsersController@index')->name('users');

Route::get('/register', 'VisitorsController@index')->name('register');
Route::get('/register2', 'VisitorsController@index2')->name('register2');

Route::post('/search', 'SearchController@index')->name('search');
Route::post('/results', 'SearchController@results')->name('results');

Route::get('/notifications', 'NotificationController@index')->name('index');
Route::get('/notifications/show/{id}', 'NotificationController@show')->name('index');

Route::get('/register/{societeID}', 'VisitorsController@index')->name('register-advanced');
Route::post('/comptes/adduser', 'VisitorsController@createuser')->name('comptes-createuser');
Route::post('/comptes/rechercher-presta', 'VisitorsController@rechercherpresta')->name('comptes-rechercher-presta');
Route::post('/comptes/rechercher-presta2', 'VisitorsController@rechercherpresta2')->name('comptes-rechercher-presta');
Route::post('/comptes/rechercher-presta3', 'VisitorsController@rechercherpresta3')->name('comptes-rechercher-presta');
Route::post('/comptes/verifier-password', 'VisitorsController@verifierpassword')->name('comptes-verifierpassword');

Route::get('/societe/informations', 'SocietesController@show')->name('informations-societe');
Route::get('/societe/details', 'SocietesController@details')->name('informations-details');
Route::get('/societe/compte/{id}', 'SocietesController@compte')->name('informations-compte');
Route::get('/societe/comptes', 'SocietesController@comptes')->name('informations-comptes');
Route::post('/societe/visualiserdocument', 'SocietesController@seeDocument')->name('informations-visualiserdocument');
Route::get('/societe/documents', 'SocietesController@documents')->name('documents-societe');
Route::get('/societe/creercompte', 'SocietesController@creercompte')->name('documents-creercompte');
Route::post('/societe/ajoutercompte', 'SocietesController@ajoutercompte')->name('documents-ajoutercompte');
Route::post('/societe/modifiercompte', 'SocietesController@modifiercompte')->name('documents-modifiercompte');
Route::post('/societe/deletecompte', 'SocietesController@deletecompte')->name('documents-deletecompte');
Route::post('/societe/change', 'SocietesController@change')->name('save-societe');
Route::post('/societe/deletedocument', 'SocietesController@deletedocument')->name('societe-deletedocument');
Route::get('/societe/download/{id}', 'SocietesController@download')->name('download-societe');
Route::post('/societe/deletelink', 'SocietesController@deletelink')->name('delacces-societe');
Route::post('/societe/sendlink', 'SocietesController@sendlink')->name('sendlink-societe');
Route::get('/societe/getDocument/{id}', 'SocietesController@getDocument')->name('societe-getDocument');
Route::post('/societe/upload', 'SocietesController@upload')->name('societe-upload');
Route::get('/societe/habilitations', 'SocietesController@habilitations')->name('societe-habilitations');
Route::post('/societe/chargerdocument', 'SocietesController@chargerdocument')->name('societe-chargerdocument');
Route::post('/societe/addacces', 'SocietesController@addacces')->name('societe-addacces');
Route::get('/societe/completerprofil', 'SocietesController@completerprofil')->name('societe-completerprofil');

/*** LES FONCTIONS DE L'ADMIN ***/	
Route::get('/admin/do', 'AdminController@do')->name('admin-do');
Route::get('/admin/notifdo', 'AdminController@notifdo')->name('admin-notifdo');
Route::get('/admin/notifpresta', 'AdminController@notifpresta')->name('admin-notifpresta');
Route::get('/admin/create-do', 'AdminController@create_do')->name('admin-create-do');
Route::post('/admin/adddo', 'AdminController@adddo')->name('admin-do');
Route::get('/admin/chantier/{id}', 'AdminController@chantier')->name('admin-chantier');
Route::get('/admin/chantiers', 'AdminController@chantiers')->name('admin-chantiers');
Route::get('/admin/old', 'AdminController@old')->name('admin-old');
Route::post('/inprogress', 'AdminController@inprogress')->name('admin-inprogress');
Route::post('/oldchantiers', 'AdminController@oldchantiers')->name('admin-oldchantiers');
Route::get('/admin/pieces', 'AdminController@pieces')->name('admin-pieces');
Route::get('/admin/decisionpiece/{id}', 'AdminController@decisionpiece')->name('admin-decisionpiece');
Route::get('/admin/prestataires', 'AdminController@prestataires')->name('admin-pieces');
Route::post('/admin/prestataires', 'AdminController@prestataires2')->name('admin-pieces');
Route::get('/admin/showpresta/{id}', 'AdminController@showpresta')->name('admin-showpresta');
Route::post('/listepresta', 'AdminController@listepresta')->name('admin-listepresta');
Route::post('/admin/changerstatut', 'AdminController@changerstatut')->name('admin-changerstatut');
Route::post('/admin/resetpassword', 'AdminController@resetpassword')->name('admin-resetpassword');
Route::get('/admin/type_chantier', 'AdminController@type_chantier')->name('type_chantier-params');
Route::get('/admin/type_livraison', 'AdminController@type_livraison')->name('type_livraison-params');
Route::post('/admin/ajoutertype', 'AdminController@ajoutertype')->name('ajoutertype-params');
Route::get('/admin/supprimertype/{id}', 'AdminController@supprimertype')->name('supprimertype-params');
Route::post('/admin/ajoutertypelivraison', 'AdminController@ajoutertypelivraison')->name('ajoutertype-params');
Route::get('/admin/supprimertypelivraison/{id}', 'AdminController@supprimertypelivraison')->name('supprimertype-params');
Route::get('/admin/pays', 'AdminController@pays')->name('admin-pays');
Route::get('/admin/unpays/{id}', 'AdminController@unpays')->name('admin-unpays');
Route::post('/admin/savepays', 'AdminController@savepays')->name('admin-savepays');
Route::get('/admin/zonesgeo', 'AdminController@zonesgeo')->name('admin-zonesgeo');
Route::get('/admin/unezone/{id}', 'AdminController@unezone')->name('admin-unezone');
Route::post('/admin/savezone', 'AdminController@savezone')->name('admin-savezone');
Route::get('/admin/profils', 'AdminController@profils')->name('admin-profils');
Route::post('/admin/enregistrerpieces', 'AdminController@enregistrerpieces')->name('admin-enregistrerpieces');

//Route::post('/prestataires', 'AdminController@prestataires')->name('admin-prestataires');

/*** LES FONCTIONS DU DO ***/	
Route::get('/comptes', 'ComptesController@comptes')->name('comptes-lister');
Route::post('/comptes', 'ComptesController@comptes')->name('comptes-lister');
Route::get('/comptes/show/{id}', 'ComptesController@show')->name('comptes-show');
Route::post('/comptes/changerdroits', 'ComptesController@changerdroits')->name('comptes-changerdroits');
Route::post('/comptes/change', 'ComptesController@change')->name('comptes-change');
Route::get('/comptes/create', 'ComptesController@create')->name('comptes-create');
Route::post('/comptes/save', 'ComptesController@save')->name('comptes-create');
Route::get('/comptes/services', 'ComptesController@services')->name('comptes-services');
Route::get('/comptes/validation', 'ComptesController@validation')->name('comptes-validation');
Route::post('/comptes/savevalidation', 'ComptesController@savevalidation')->name('comptes-savevalidation');
Route::get('/comptes/livraison', 'ComptesController@livraison')->name('comptes-livraison');
Route::post('/comptes/savelivraison', 'ComptesController@savelivraison')->name('comptes-savelivraison');
Route::post('/comptes/refreshSelect', 'ComptesController@refreshSelect')->name('comptes-refreshSelect');
Route::get('/comptes/configuration', 'ComptesController@configuration')->name('comptes-configuration');
Route::post('/comptes/saveconfiguration', 'ComptesController@saveconfiguration')->name('comptes-saveconfiguration');
Route::get('/comptes/pieces', 'ComptesController@pieces')->name('comptes-pieces');
Route::post('/comptes/savepieces', 'ComptesController@savepieces')->name('comptes-savepieces');
Route::post('/comptes/savePiece', 'ComptesController@savepiece')->name('comptes-savepiece');

Route::get('/comptes/habilitations', 'ComptesController@habilitations')->name('comptes-habilitations');
Route::post('/comptes/savehabilitation', 'ComptesController@savehabilitation')->name('comptes-savehabilitation');
Route::post('/comptes/saveTypeDossier', 'ComptesController@saveTypeDossier')->name('comptes-saveTypeDossier');
Route::post('/comptes/saveTypeLivraison', 'ComptesController@saveTypeLivraison')->name('comptes-saveTypeLivraison');

Route::get('/comptes/groupes', 'ComptesController@profils')->name('comptes-groupes');
Route::get('/comptes/profils', 'ComptesController@profils')->name('comptes-groupes');
Route::get('/comptes/abonnement', 'ComptesController@abonnement')->name('comptes-abonnement');

Route::post('/comptes/saveservice', 'ComptesController@saveservice')->name('comptes-saveservice');
Route::get('/comptes/service/{id}', 'ComptesController@services')->name('comptes-service');
Route::get('/comptes/deleteservice/{id}', 'ComptesController@deleteservice')->name('comptes-deleteservice');

Route::post('/comptes/saveprofil', 'ComptesController@saveprofil')->name('comptes-saveprofil');
Route::get('/comptes/profil/{id}', 'ComptesController@profils')->name('comptes-profil');
Route::get('/comptes/deleteprofil/{id}', 'ComptesController@deleteprofil')->name('comptes-deleteprofil');

/*** CALENDRIER ***/
Route::get('/calendrier/fermeture', 'CalendrierController@fermeture')->name('comptes-fermeture');
Route::get('/calendrier/fermeture/{id}', 'CalendrierController@fermeture')->name('comptes-fermeture');
Route::post('/calendrier/savefermeture', 'CalendrierController@savefermeture')->name('comptes-fermeture');
Route::get('/calendrier/deletefermeture/{id}', 'CalendrierController@deletefermeture')->name('comptes-deletefermeture');

Route::get('/calendrier/creneaux', 'CalendrierController@creneaux')->name('calendrier-creneaux');
Route::get('/calendrier/creneau/{id}', 'CalendrierController@creneaux')->name('calendrier-creneau');
Route::post('/calendrier/savecreneau', 'CalendrierController@savecreneau')->name('calendrier-savecreneau');
Route::get('/calendrier/deletecreneau/{id}', 'CalendrierController@deletecreneau')->name('calendrier-deletecreneau');
Route::get('/calendrier/affectation', 'CalendrierController@affectation')->name('calendrier-affectation');
Route::post('/calendrier/ajouterLigne', 'CalendrierController@ajouterLigne')->name('calendrier-ajouterLigne');
Route::get('/calendrier/newtype', 'CalendrierController@newtype')->name('calendrier-newtype');
Route::post('/calendrier/ajoutercreneau', 'CalendrierController@ajoutercreneau')->name('chantier-ajoutercreneau');
Route::post('/calendrier/delete', 'CalendrierController@delete')->name('chantier-delete');
Route::post('/calendrier/changertype', 'CalendrierController@changertype')->name('chantier-changertype');
Route::post('/calendrier/affecter_semaines', 'CalendrierController@affecter_semaines')->name('calendrier-affecter_semaines');
Route::post('/calendrier/creerCreneaux', 'CalendrierController@creerCreneaux')->name('calendrier-creerCreneaux');
Route::get('/calendrier/modifierTypeSemaines/{id}', 'CalendrierController@modifierTypeSemaines')->name('calendrier-modifierTypeSemaines');

/*** LES CHANTIERS ***/	
Route::get('/chantier/virtuels', 'ChantiersController@virtuels')->name('chantier-virtuels');
Route::match(['get', 'post'], '/chantier/sent', 'ChantiersController@sent')->name('chantier-lister');
Route::get('/chantier/do', 'ChantiersController@do')->name('chantier-do');
Route::get('/chantier/avisrdv', 'ChantiersController@avisrdv')->name('chantier-avisrdv');
Route::get('/chantier/entites', 'ChantiersController@entites')->name('chantier-entites');
Route::get('/chantiers/validerentite/{id}', 'ChantiersController@validerentite')->name('chantier-validerentite');
Route::get('/chantiers/invaliderentite/{id}', 'ChantiersController@invaliderentite')->name('chantier-invaliderentite');
Route::get('/chantier/voirmateriel/{id}', 'ChantiersController@voirmateriel')->name('chantier-voirmateriel');
Route::post('/chantier/getlignevisiteur', 'ChantiersController@getlignevisiteur')->name('chantier-getlignevisiteur');
Route::post('/chantier/getlignedate', 'ChantiersController@getlignedate')->name('chantier-getlignedate');

Route::match(['get', 'post'], '/chantier/pieces', 'ChantiersController@pieces')->name('chantier-pieces');
Route::get('/chantier/piecesrefusees', 'ChantiersController@piecesrefusees')->name('chantier-piecesrefusees');
Route::get('/chantier/piece/{id}', 'ChantiersController@piece')->name('chantier-piece');
Route::get('/chantier/received', 'ChantiersController@received')->name('chantier-lister');
Route::get('/chantier/create', 'ChantiersController@create')->name('chantier-creer');
Route::get('/chantier/createv', 'ChantiersController@createv')->name('chantier-creerv');
Route::get('/chantier/createpresta', 'ChantiersController@createpresta')->name('chantier-createpresta');
Route::get('/chantier/createchantierdo', 'ChantiersController@createchantierdo')->name('chantier-createchantierdo');
Route::post('/chantier/decisionrdv', 'ChantiersController@decisionrdv')->name('chantier-decisionrdv');
Route::post('/chantier/save', 'ChantiersController@save')->name('chantier-save');
Route::post('/chantier/savevirtuel', 'ChantiersController@savevirtuel')->name('chantier-savevirtuel');
Route::post('/chantier/savepresta', 'ChantiersController@savepresta')->name('chantier-savepresta');
Route::post('/chantier/savechantierdo', 'ChantiersController@savechantierdo')->name('chantier-savechantierdo');
Route::post('/chantier/delete', 'ChantiersController@delete')->name('chantier-delete');
Route::get('/chantier/restore/{id}', 'ChantiersController@restore')->name('chantier-restore');
Route::get('/chantier/show/{id}', 'ChantiersController@show')->name('chantier-show');
Route::get('/chantier/showDo/{id}', 'ChantiersController@showDo')->name('chantier-showDo');
Route::get('/chantier/choixpresta/{id}', 'ChantiersController@choixpresta')->name('chantier-choixpresta');
Route::post('/chantier/supprimerpresta', 'ChantiersController@supprimerpresta')->name('chantier-supprimerpresta');
Route::post('/chantier/supprimertitulaireprincipal', 'ChantiersController@supprimertitulaireprincipal')->name('chantier-supprimertitulaireprincipal');
Route::post('/chantier/savevehicule', 'ChantiersController@savevehicule')->name('chantier-savevehicule');
Route::get('/chantier/fic/{id}', 'ChantiersController@download_fic')->name('chantier-download_fic');
Route::get('/chantier/download/{id}', 'ChantiersController@download')->name('chantier-download');
Route::get('/chantier/rdv/{id}', 'ChantiersController@getavis')->name('chantier-getavis');
Route::post('/chantier/liste_titulaires', 'ChantiersController@liste_titulaires')->name('chantier-liste_titulaires');
Route::post('/chantier/voirintervenantdo', 'ChantiersController@voirintervenantdo')->name('chantier-voirintervenantdo');
Route::get('/chantier/voirautorisation/{id}', 'ChantiersController@voirautorisation')->name('chantier-voirautorisation');
Route::post('/chantier/saveautorisation', 'ChantiersController@saveautorisation')->name('chantier-saveautorisation');
Route::post('/chantier/annulerAutorisation', 'ChantiersController@annulerAutorisation')->name('chantier-annulerAutorisation');
Route::post('/chantier/changerAutorisation', 'ChantiersController@changerAutorisation')->name('chantier-changerAutorisation');
Route::get('/chantier/personnelautorise', 'ChantiersController@personnelautorise')->name('chantier-personnelautorise');
Route::get('/chantier/personnelexclus', 'ChantiersController@personnelexclus')->name('chantier-personnelexclus');
Route::post('/chantier/ajoutermaterieldo', 'ChantiersController@ajoutermaterieldo')->name('chantier-ajoutermaterieldo');
Route::post('/chantier/chargerdocument', 'ChantiersController@chargerdocument')->name('chantier-chargerdocument');
Route::get('/chantier/accreditation', 'ChantiersController@accreditation')->name('chantier-accreditation');
Route::post('/chantier/saveattributs', 'ChantiersController@saveattributs')->name('chantier-saveattributs');
Route::post('/chantier/refreshresponsables', 'ChantiersController@refreshresponsables')->name('chantier-saveattributs');
Route::get('/autorisation/chantiers', 'SocietesController@chantiers')->name('autorisation-chantiers');

	
Route::post('/chantier/savememo', 'ChantiersController@savememo')->name('chantier-savememo');
Route::get('/chantier/mandater/{id}', 'ChantiersController@mandater')->name('chantier-mandater');
Route::get('/chantier/validation/{id}', 'ChantiersController@validation')->name('chantier-validation');
Route::post('/chantier/rechercher-presta', 'ChantiersController@rechercherpresta')->name('chantier-rechercher-presta');
Route::post('/chantier/creermandat', 'ChantiersController@creermandat')->name('chantier-creermandat');
Route::post('/chantier/voirmandat', 'ChantiersController@voirmandat')->name('chantier-voirmandat');
Route::get('/chantier/intervenant/{id}', 'ChantiersController@intervenant')->name('chantier-intervenant');
Route::get('/chantier/archive/{id}', 'ChantiersController@archive')->name('chantier-archive');
Route::get('/chantier/intervenants/{id}', 'ChantiersController@intervenants')->name('chantier-intervenants');
Route::get('/chantier/gerervirtuel/{id}', 'ChantiersController@gerervirtuel')->name('chantier-intervenants');
Route::get('/chantier/intervenantsDo/{id}', 'ChantiersController@intervenantsDo')->name('chantier-intervenantsDo');
Route::get('/chantier/actionsDo/{id}', 'ChantiersController@actionsDo')->name('chantier-actionsDo');
Route::post('/chantier/addnewaction', 'ChantiersController@addnewaction')->name('chantier-addnewaction');
Route::post('/chantier/demarrer', 'ChantiersController@demarrer')->name('chantier-demarrer');
Route::post('/chantier/terminer', 'ChantiersController@terminer')->name('chantier-terminer');
Route::post('/chantier/terminerGuest', 'VisitorsController@terminer')->name('chantier-terminerGuest');

Route::get('/chantier/action/{id}', 'ChantiersController@action')->name('chantier-action');
Route::post('/chantier/chargerjustificatif', 'ChantiersController@chargerjustificatif')->name('chantier-chargerjustificatif');
Route::post('/chantier/deletefile', 'ChantiersController@deletefile')->name('chantier-deletefile');
Route::post('/chantier/saveaction', 'ChantiersController@saveaction')->name('chantier-saveaction');
Route::post('/chantier/deleteaction', 'ChantiersController@deleteaction')->name('chantier-deleteaction');
Route::post('/chantier/sendurl', 'ChantiersController@sendurl')->name('chantier-sendurl');

Route::get('/chantier/showDoGuest/{url}', 'VisitorsController@showDoGuest')->name('chantier-showDoGuest');
Route::get('/chantier/accesaction/{url}', 'VisitorsController@accesaction')->name('chantier-accesaction');
Route::get('/chantier/actionGuest/{id}', 'VisitorsController@actionGuest')->name('chantier-actionGuest');
Route::get('/chantier/actionValidateGuest/{id}', 'VisitorsController@actionValidateGuest')->name('chantier-actionGuest');
Route::post('/chantier/saveactionGuest', 'VisitorsController@saveaction')->name('chantier-saveaction');
Route::post('/chantier/chargerjustificatifGuest', 'VisitorsController@chargerjustificatif')->name('chantier-chargerjustificatifGuest');
Route::get('/chantier/downloadJustificatif/{id}', 'VisitorsController@downloadJustificatif')->name('chantier-downloadJustificatif');
	
// AVIS DE RENDEZ-VOUS
Route::match(['get', 'post'], '/rdv/lister', 'RdvController@lister')->name('rdv-lister');
Route::post('/rdv/creerrdv', 'RdvController@creerrdv')->name('chantier-creerrdv');
Route::post('/rdv/save', 'RdvController@save')->name('chantier-save');
Route::get('/rdv/show/{id}', 'RdvController@showrdv')->name('chantier-showrdv');
Route::get('/rdv/creer', 'RdvController@creer')->name('chantier-showrdv');
Route::post('/rdv/validerrdv', 'RdvController@validerrdv')->name('chantier-validerrdv');
Route::post('/rdv/refuserrdv', 'RdvController@refuserrdv')->name('chantier-refuserrdv');
Route::post('/rdv/supprimer', 'RdvController@supprimer')->name('chantier-supprimer');
Route::post('/rdv/listeValideur', 'RdvController@listeValideur')->name('chantier-listeValideur');

Route::get('/livraisons/lister', 'LivraisonsController@lister')->name('livraisons-lister');
Route::get('/livraisons/createlivraison', 'LivraisonsController@createlivraison')->name('livraisons-createlivraison');
Route::post('/livraisons/save', 'LivraisonsController@save')->name('livraisons-save');
Route::get('/livraisons/show/{id}', 'LivraisonsController@show')->name('livraisons-show');
Route::post('/livraisons/rechercher-presta', 'LivraisonsController@rechercherpresta')->name('livraisons-rechercher-presta');
Route::post('/livraisons/addpresta', 'LivraisonsController@addpresta')->name('livraisons-addpresta');
Route::get('/livraisons/intervenants/{id}', 'LivraisonsController@intervenants')->name('livraisons-intervenants');
Route::get('/livraisons/vehicules/{id}', 'LivraisonsController@vehicules')->name('livraisons-vehicules');
Route::get('/livraisons/choixpresta/{id}', 'LivraisonsController@choixpresta')->name('livraisons-choixpresta');
Route::post('/livraisons/supprimerpresta', 'LivraisonsController@supprimerpresta')->name('livraisons-supprimerpresta');
Route::post('/livraisons/supprimertitulaireprincipal', 'LivraisonsController@supprimertitulaireprincipal')->name('livraisons-supprimertitulaireprincipal');
Route::post('/livraisons/liste_titulaires', 'LivraisonsController@liste_titulaires')->name('livraisons-liste_titulaires');
Route::get('/livraisons/mandats/{id}', 'LivraisonsController@mandats')->name('livraisons-mandats');
Route::post('/livraisons/creermandat', 'LivraisonsController@creermandat')->name('livraisons-creermandat');
Route::post('/livraisons/voirmandat', 'LivraisonsController@voirmandat')->name('livraisons-voirmandat');
Route::post('/livraisons/ajouterlivreur', 'LivraisonsController@ajouterlivreur')->name('chantier-ajouterlivreur');
Route::get('/livraisons/documents/{id}', 'LivraisonsController@documents')->name('livraisons-documents');
Route::post('/livraisons/ajouterdocument', 'LivraisonsController@ajouterdocument')->name('livraisons-ajouterdocument');

Route::get('/livraisons/received', 'LivraisonsController@received')->name('livraisons-lister');
Route::get('/Llivraisons/getinfo', 'LivraisonsController@getinfo')->name('livraisons-lister');

Route::get('/chantier/mandats/{id}', 'ChantiersController@mandats')->name('chantier-mandats');
Route::get('/chantier/vehicule/{id}', 'ChantiersController@vehicule')->name('chantier-vehicule');
Route::get('/chantier/vehicules/{id}', 'ChantiersController@vehicules')->name('chantier-vehicules');
Route::post('/chantier/ajouterequipier', 'ChantiersController@ajouterequipier')->name('chantier-ajouterequipier');
Route::post('/chantier/enleverequipier', 'ChantiersController@enleverequipier')->name('chantier-enleverequipier');
Route::post('/chantier/refreshEquipier', 'ChantiersController@refreshEquipier')->name('chantier-refreshEquipier');
Route::post('/chantier/ajouterpiece', 'ChantiersController@ajouterpiece')->name('chantier-ajouterpiece');
Route::post('/chantier/validerintervenant', 'ChantiersController@validerintervenant')->name('chantier-validerintervenant');
Route::post('/chantier/invaliderintervenant', 'ChantiersController@invaliderintervenant')->name('chantier-invaliderintervenant');
Route::post('/chantier/validationvehicule', 'ChantiersController@validationvehicule')->name('chantier-validationvehicule');
Route::post('/chantier/invalidationvehicule', 'ChantiersController@invalidervehicule')->name('chantier-invalidervehicule');
Route::get('/chantier/decisionpiece/{id}', 'ChantiersController@decisionpiece')->name('chantier-decisionpiece');
Route::get('/chantier/refuserpiece/{id}', 'ChantiersController@decisionpiece')->name('chantier-refuserpiece');
Route::post('/chantier/afficherpiece', 'ChantiersController@afficherpiece')->name('chantier-afficherpiece');
Route::post('/chantier/analyserpiece', 'ChantiersController@analyserpiece')->name('chantier-analyserpiece');
Route::post('/chantier/addpresta', 'ChantiersController@addpresta')->name('chantier-addpresta');
Route::get('/chantier/rdv', 'ChantiersController@rdv')->name('chantier-rdv');
Route::get('/chantier/attribuer/{id}', 'ChantiersController@attribuer')->name('chantier-attribuer');
Route::post('/chantier/attribuer', 'ChantiersController@attribuerpost')->name('chantier-attribuer');
Route::post('/chantier/setcreneau', 'ChantiersController@setcreneau')->name('chantier-setcreneau');
Route::post('/chantier/proroger', 'ChantiersController@proroger')->name('chantier-proroger');
Route::post('/chantier/cloturer', 'ChantiersController@cloturer')->name('chantier-cloturer');
Route::post('/chantier/upload', 'ChantiersController@upload')->name('chantier-upload');
Route::post('/chantier/addnewintervenantdo', 'ChantiersController@addnewintervenantdo')->name('chantier-addnewintervenantdo');
Route::post('/chantier/ajouterintervenantdo', 'ChantiersController@ajouterintervenantdo')->name('chantier-ajouterintervenantdo');
Route::get('/chantier/listeglobale', 'ChantiersController@listeglobale')->name('chantier-listeglobale');
Route::get('/chantier/listeglobale/{filter}', 'ChantiersController@listeglobale')->name('chantier-listeglobale');
Route::post('/chantier/savevalidation', 'ChantiersController@savevalidation')->name('chantier-savevalidation');
Route::post('/intervenant/renewautorisation', 'EntitesController@renewautorisation')->name('chantier-renewautorisation');
Route::post('/intervenant/refreshlistepieces', 'EntitesController@refreshlistepieces')->name('chantier-refreshlistepieces');

/*** LES PIECES ***/
Route::post('/pieces/validerpiece', 'PiecesController@validerpiece')->name('pieces-validerpiece');
	
Route::get('/intervenants', 'EntitesController@intervenants')->name('intervenants');
Route::get('/add-intervenant', 'EntitesController@nouveau')->name('add-intervenant');
Route::post('/intervenant/getinfo', 'EntitesController@getinfo')->name('getinfo-intervenant');
Route::post('/intervenant/save', 'EntitesController@save_new')->name('save-intervenant');
Route::post('/intervenant/change', 'EntitesController@change')->name('change-intervenant');
Route::get('/intervenant/show/{id}', 'EntitesController@show')->name('fiche-intervenant');
Route::get('/intervenant/carnet/{id}', 'EntitesController@carnet')->name('carnet-intervenant');
Route::get('/intervenant/delete/{id}', 'EntitesController@delete')->name('delete-intervenant');
Route::get('/intervenant/deletepiece/{id}', 'EntitesController@deletepiece2')->name('delete-piece-intervenant');
Route::post('/intervenant/deletepiece', 'EntitesController@deletepiece')->name('delete-piece-intervenant');
Route::get('/intervenant/restore/{id}', 'EntitesController@restore')->name('restore-intervenant');
Route::post('/intervenant/addpiece', 'EntitesController@addpiece')->name('piece-intervenant');
Route::post('/intervenant/rechercher', 'EntitesController@rechercher')->name('piece-rechercher');
Route::post('/intervenant/addhabilitation', 'EntitesController@addhabilitation')->name('habilitation-intervenant');
Route::get('/intervenant/download/{id}', 'EntitesController@download')->name('download-intervenant');
Route::post('/intervenant/upload', 'EntitesController@upload')->name('entite-upload');
Route::post('/intervenant/gettoken', 'EntitesController@gettoken')->name('entite-gettoken');
Route::post('/intervenant/afficherpiece', 'EntitesController@afficherpiece')->name('entite-afficherpiece');
Route::post('/intervenant/savehabilitation', 'EntitesController@addhabilitation')->name('entite-savehabilitation');
Route::post('/intervenant/rechargerpiece', 'EntitesController@rechargerpiece')->name('rechargerpiece-intervenant');

Route::get('/vehicules', 'EntitesController@vehicules')->name('vehicules');
Route::get('/add-vehicule', 'EntitesController@nouveauvehicule')->name('add-vehicule');
Route::post('/vehicule/save', 'EntitesController@savevehicule')->name('save-vehicule');
Route::get('/vehicule/show/{id}', 'EntitesController@vehiculeshow')->name('fiche-vehicule');
Route::post('/vehicule/change', 'EntitesController@vehiculechange')->name('change-vehicule');
Route::post('/vehicule/addpiece', 'EntitesController@addpiece')->name('piece-intervenant');

Route::get('/entite/autres', 'EntitesController@autres')->name('entite-autres');
Route::get('/entite/createtype', 'EntitesController@createtype')->name('entite-createtype');
Route::post('/entite/ajoutertype', 'EntitesController@ajoutertype')->name('entite-ajoutertype');
Route::get('/entite/createnew', 'EntitesController@createnew')->name('entite-createnew');
Route::post('/entite/updateform', 'EntitesController@updateform')->name('entite-updateform');
Route::post('/entite/savenew', 'EntitesController@savenew')->name('entite-savenew');
Route::post('/entite/saveold', 'EntitesController@saveold')->name('entite-saveold');
Route::post('/entite/saveentite', 'EntitesController@saveentite')->name('entite-saveentite');
Route::post('/entite/addpiece2', 'EntitesController@addpiece2')->name('entite-addpiece2');
Route::post('/entite/deleteelement', 'EntitesController@deleteelement')->name('entite-deleteentite');
Route::get('/entite/showEntite/{id}', 'EntitesController@showEntite')->name('entite-showEntite');
Route::get('/entite/typeentite/{id}', 'EntitesController@typeentite')->name('entite-typeentite');
Route::post('/entite/adddocument', 'EntitesController@adddocument')->name('entite-adddocument');
Route::get('/entite/listertypes', 'EntitesController@listertypes')->name('entite-listertypes');
Route::post('/entite/listertypes', 'EntitesController@listertypes')->name('entite-listertypes');
Route::post('/entite/supprimerdocument', 'EntitesController@supprimerdocument')->name('entite-supprimerdocument');
Route::post('/entite/supprimertype', 'EntitesController@supprimertype')->name('entite-supprimertype');

Route::post('/entite/getinfo', 'EntitesController@getinfo')->name('getinfo-entite');

/*** ADMIN FUNCTIONS ***/
Route::get('/societe/lister', 'SocietesController@lister')->name('lister-societe');
Route::get('/societe/fiche/{id}', 'SocietesController@fiche')->name('fiche-societe');
Route::post('/societe/getinfo', 'SocietesController@getinfo')->name('getinfo-societe');

Route::post('/parametres/savehabilitation', 'PiecesController@savehabilitation')->name('administrer-savehabilitation');
Route::post('/parametres/savepieces', 'PiecesController@savepieces')->name('save-pieces');
Route::get('/parametres/fichehabilitation/{id}', 'PiecesController@fichehabilitation')->name('administrer-fichehabilitation');
Route::get('/parametres/deletehabilitation/{id}', 'PiecesController@deletehabilitation')->name('administrer-deletehabilitation');
Route::get('/parametres/add-habilitation', 'PiecesController@addhabilitation')->name('administrer-add-habilitation');
Route::get('/parametres/pieces', 'PiecesController@administrer')->name('administrer-pieces');
Route::get('/parametres/add-type-pieces', 'PiecesController@add')->name('add-pieces');
Route::get('/parametres/fichepiece/{id}', 'PiecesController@fiche')->name('fiche-pieces');
Route::post('/parametres/savepieces', 'PiecesController@savepieces')->name('save-pieces');
Route::post('/parametres/savetypepiece', 'PiecesController@savetypepiece')->name('savetypepiece-pieces');
Route::get('/parametres/chantiers', 'ChantiersController@administrerchantier')->name('administrerchantier-params');
Route::get('/parametres/add-type-chantiers', 'ChantiersController@addtypechantiers')->name('addtypechantiers-params');
Route::post('/parametres/savechantiers', 'ChantiersController@savechantiers')->name('savechantiers-params');

