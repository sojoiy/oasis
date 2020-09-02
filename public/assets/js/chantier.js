// AFFICHE LA LISTE DES OPTIONS DISPONIBLE SELON LA SITUATION DU CLIENT
function afficherDocument(piece_ID)
{
	$.ajax({
	         type:'POST',
	         url:'/chantier/afficherpiece',
	         headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			data: {
		        "id": piece_ID
		        },
	         success:function(data){
	            $("#viewer").html(data);
	         }
	      });
}

function refreshValideurs(piece_ID)
{
	$.ajax({
	         type:'POST',
	         url:'/chantier/afficherpiece',
	         headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			data: {
		        "id": piece_ID
		        },
	         success:function(data){
	            $("#viewer").html(data);
	         }
	      });
}
function rafraichircalendar(equipier)
{
	$.ajax({
	         type:'POST',
	         url:'/chantier/rafraichircalendar',
	         headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			data: {
		        "equipier": equipier
		        },
	         success:function(data){
	            $("#calendar").html(data);
	         }
	      });
}
function annulerrdv(equipier)
{
	$.ajax({
	         type:'POST',
	         url:'/chantier/annulerrdv',
	         headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			data: {
		        "equipier": equipier
		        },
	         success:function(equipier){
	            rafraichircalendar(equipier);
	         }
	      });
}

function refreshResponsables(type_chantier)
{
	$.ajax({
	         type:'POST',
	         url:'/chantier/refreshresponsables',
	         headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			data: {
		        "id": type_chantier
		        },
	         success:function(data){
	            $("#liste_valideurs").html(data);
	         }
	      });
}

function supprimerChantier(chantier_ID)
{
	$.ajax({
	         type:'POST',
	         url:'/chantier/delete',
	         headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			data: {
		        "id": chantier_ID
		        },
	         success:function(data){
	            $("#chantier_"+chantier_ID).remove();
	         }
	      });
}

function validerEquipier2(equipier_ID)
{
	alert('plop');
	$.ajax({
	         type:'POST',
	         url:'/chantier/validationvehicule',
	         headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			data: {
		        "id": equipier_ID,
		        "origin": "tab"
		        },
	         success:function(data){
	            $("#zone_validation").html(data);
	         }
	      });
}

function invaliderVehicule(equipier_ID)
{
	$.ajax({
	         type:'POST',
	         url:'/chantier/invalidationvehicule',
	         headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			data: {
		        "id": equipier_ID
		        },
	         success:function(data){
	            $("#zone_validation").html(data);
	         }
	      });
}

function showMandat(mandat_ID)
{
	$.ajax({
	         type:'POST',
	         url:'/chantier/voirmandat',
	         headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			data: {
		        "id": mandat_ID
		        },
	         success:function(data){
	            $("#affichage").html(data);
	         }
	      });
}

function ajouterEquipier(chantier_ID, entite_ID)
{
	// AFFICHAGE DE LA FENETRE MODAL
	if(entite_ID != 0)
	{
		$('#identite_intervenant2').html($('#ligneEntite_'+entite_ID).html());
	
		$.ajax({
		         type:'POST',
		         url:'/chantier/ajouterequipier',
		         headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
				data: {
			        "id": chantier_ID,
					"entiteID": entite_ID
			        },
		         success:function(data){
		            $("#equipe_chantier").html(data);
					$("#ligneEntite_"+entite_ID).remove();
					$('#kt_modal_avertissement').modal('show');
		         }
		      });
	}
}

function refreshEquipier(chantier_ID, entite_ID)
{
	$.ajax({
		     type:'POST',
		     url:'/chantier/refreshEquipier',
		     headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			data: {
		        "id": chantier_ID,
				"entiteID": entite_ID
		        },
		     success:function(data){
	            $("#equipe_chantier").html(data);
				$('#kt_modal_avertissement').modal('show');
		     }
		});
}

function enleverEquipier(chantier_ID, entite_ID)
{
	if(confirm('Souhaitez-vous retirer cet élément du chantier ?'))
	{
		$.ajax({
			     type:'POST',
			     url:'/chantier/enleverequipier',
			     headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
				data: {
			        "id": chantier_ID,
					"entiteID": entite_ID
			        },
			     success:function(data){
			        //$("#equipe_chantier").html(data);
					$("#selectEquipier").append(data);
					$("#ligneEquipier_"+entite_ID).remove();
			     }
			});
	}
}

function selectionnerEquipier(entite_ID, chantier)
{
	$.ajax({
	        type:'POST',
	        url:'/intervenant/refreshlistepieces',
	        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			data: {
		        "entite": entite_ID,
				"chantier": chantier
		        },
	         success:function(data){
	            $("#zoneTypePiece").html(data);
	         }
	      });
}

function accepterPiece(decision)
{
	$('#decision').val(decision);
	
	$.ajax({
		type: "POST",
		url: "/pieces/validerpiece",
		data: $("#decision-piece").serialize(),
			success: function(code){
				$('#zone_decisive').html(code);
			},
		
		error: function(){
			alert("Erreur, merci de contacter l'administrateur en lui donnant le code suivant : Erx0001");
		}
	});
}

function choosePresta(societe_ID)
{
	$('#mandataireID').val(societe_ID);
	
	$.ajax({
	        type:'POST',
	        url:'/societe/getinfo',
	        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			data: {
		        "field": "raisonSociale",
				"societe_ID": societe_ID
		        },
	         success:function(data){
	            $("#saRaisonSociale").val(data);
	         }
	      });
		  
  	$.ajax({
  	        type:'POST',
  	        url:'/societe/getinfo',
  	        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
  			data: {
  		        "field": "noSiret",
				"societe_ID": societe_ID
  		        },
  	         success:function(data){
  	            $("#sonNoSiret").val(data);
  	         }
  	      });
		  
	$.ajax({
	        type:'POST',
	        url:'/societe/getinfo',
	        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			data: {
		        "field": "interim",
				"societe_ID": societe_ID
		        },
	         success:function(data){
	            $("#ligne_interim").html(data);
	         }
	      });
		  
	$.ajax({
	        type:'POST',
	        url:'/societe/getinfo',
	        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			data: {
		        "field": "email",
				"societe_ID": societe_ID
		        },
	         success:function(data){
	            $("#emailDirigeant").val(data);
	         }
	      });
}

function chooseVehicule(vehicule_ID)
{
	$.ajax({
	        type:'POST',
	        url:'/entite/getinfo',
	        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			data: {
		        "field": "modele",
				"id": vehicule_ID
		        },
	         success:function(data){
	            $("#sonModele").val(data);
	         }
	      });
	
	$("#sonType").val('pl').trigger('change');
	
  	$.ajax({
  	        type:'POST',
  	        url:'/entite/getinfo',
  	        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
  			data: {
  		        "field": "marque",
  				"id": vehicule_ID
  		        },
  	         success:function(data){
  	            $("#saMarque").val(data);
  	         }
  	      });
		  
  	$.ajax({
  	        type:'POST',
  	        url:'/entite/getinfo',
  	        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
  			data: {
  		        "field": "immatriculation",
  				"id": vehicule_ID
  		        },
  	         success:function(data){
  	            $("#sonImmatriculation").val(data);
  	         }
  	      });
}

/* VALIDATION DES INTERVENANTS DU CHANTIER */
function forcerValiderEquipier(entiteID)
{
	if(confirm('Ce dossier n\'est pas complet, voulez-vous forcer sa validation ?'))
	{
	  	$.ajax({
	  	        type:'POST',
	  	        url:'/chantier/validerintervenant',
	  	        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
	  			data: {
	  		        "id": entiteID
	  		        },
	  	         success:function(data){
	  	            $("#etatEquipier"+entiteID).val(data);
	  	         }
	  	      });
	}
}

function validerEquipier(entiteID, niveau)
{
  	$.ajax({
  	        type:'POST',
  	        url:'/chantier/validerintervenant',
  	        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
  			data: {
  		        "id": entiteID,
  		        "niveau": niveau
  		        },
  	         success:function(data){
  	            $("#zone_validation").html(data);
  	         }
  	      });
}


function validerEquipier2(equipier_ID)
{
	$.ajax({
	         type:'POST',
	         url:'/chantier/validationvehicule',
	         headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			data: {
		        "id": equipier_ID
		        },
	         success:function(data){
	            $("#zone_validation").html(data);
	         }
	      });
}

function invaliderEquipier(entiteID)
{
  	$.ajax({
  	        type:'POST',
  	        url:'/chantier/invaliderintervenant',
  	        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
  			data: {
  		        "id": entiteID
  		        },
  	         success:function(data){
  	            $("#zone_validation").html(data);
  	         }
  	      });
}



function saveMemo(chantier_ID)
{
	var memo = $('textarea#memo').val();
	$.ajax({
	        type:'POST',
	        url:'/chantier/savememo',
	        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			data: {
		        "id": chantier_ID,
				"memo": memo
		     },
	         success:function(data){
	            $("#save_memo").replaceWith('<span><i class="fa fa-check"></i> Modification enregistrée</span>');
	         }
	      });
}

function saveInformation(autorisation_ID)
{
	var memo = $('textarea#memo').val();
	$.ajax({
	        type:'POST',
	        url:'/chantier/saveautorisation',
	        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			data: {
		        "id": autorisation_ID,
				"memo": memo
		     },
	         success:function(data){
	            $("#save_memo").replaceWith('<span><i class="fa fa-check"></i> Modification enregistrée</span>');
	         }
	      });
}

function renouvelerAutorisation(autorisation_ID)
{
	$.ajax({
	        type:'POST',
	        url:'/chantier/changerAutorisation',
	        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			data: {
		        "id": autorisation_ID,
				"statut": "renew"
		     },
	         success:function(data){
	            $("#zone_message").html(data);
	         }
	      });
}

function validerAutorisation(autorisation_ID)
{
	$.ajax({
	        type:'POST',
	        url:'/chantier/changerAutorisation',
	        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			data: {
		        "id": autorisation_ID,
				"statut": "authorized"
		     },
	         success:function(data){
	            $("#zone_message").html(data);
	         }
	      });
}
function annulerAutorisation(autorisation_ID)
{
	$.ajax({
	        type:'POST',
	        url:'/chantier/changerAutorisation',
	        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			data: {
		        "id": autorisation_ID,
				"statut": "rejected"
		     },
	         success:function(data){
	            $("#zone_message").html(data);
	         }
	      });
}

function rechercherPrestataire(keywords)
{
	if(keywords.length > 3)
	{
		$("#les_presta").html('<span><i class="fa fa-spinner fa-pulse"></i> Recherche en cours</span>');
		
		$.ajax({
		        type:'POST',
		        url:'/chantier/rechercher-presta',
		        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
				data: {
			        "keywords": keywords
			     },
		         success:function(data){
		            $("#les_presta").html(data);
		         }
		      });
	}
	
}

function supprimerTitulairePrincipal(chantierID)
{
	$.ajax({
	        type:'POST',
	        url:'/chantier/supprimertitulaireprincipal',
	        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			data: {
		        "id": chantierID
		     },
	         success:function(data){
	            $('#les_presta2').html(data);
	         }
	      });
}

function supprimerTitulaire(titulaire_ID)
{
	$.ajax({
	        type:'POST',
	        url:'/chantier/supprimerpresta',
	        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			data: {
		        "id": titulaire_ID
		     },
	         success:function(data){
	            $('#les_presta2').html(data);
	         }
	      });
}

function proroger()
{
	$.ajax({
		type: "POST",
		url: "/chantier/proroger",
		headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		data: $("#prorogation").serialize(),
			success: function(code){
				alert('La date de fin du chantier a été modifiée');
			},
		
		error: function(){
			alert("Date invalide veuillez corriger l'erreur");
		}
	});
}

function refresh_liste_titulaires(chantierID)
{
	$.ajax({
		type: "POST",
		url: "/chantier/liste_titulaires",
	    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		data: {
	        "id": chantierID
	     },
         success:function(data){
            $('#les_presta2').html(data);
         }
	});
}

function cloturer(chantierID)
{
	if(confirm("Souhaitez-vous clôturer ce chantier ?"))
	{
		$.ajax({
			type: "POST",
			url: "/chantier/cloturer",
			headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},		
			data: {
		        "id": chantierID
		     },
	         success:function(data){
	            window.location.replace("/chantier/sent");
	         }
		});
	}
}

$(document).ready(function() {
	$("#charger-piece").submit(function( event ) {
		event.preventDefault();
		
		$.ajax({
			type: "POST",
			url: "/intervenant/addpiece",
			data: $("#charger-piece").serialize(),
				success: function(code){
					$('#activite').html(code);
				},
			
			error: function(){
				alert("Erreur, merci de contacter l'administrateur en lui donnant le code suivant : Erx0001");
			}
		});
	});
	
	$("#ajouterpresta").submit(function( event ) {
		event.preventDefault();
		
		$.ajax({
			type: "POST",
			url: "/chantier/addpresta",
			data: $("#ajouterpresta").serialize(),
				success: function(code){
					$('html,body').animate({scrollTop: 0}, 'slow');
					$('#ajouterpresta')[0].reset();
					$('#zone_notify').html(code);
					$('#mandataireID').val(0);
					refresh_liste_titulaires($('#chantierID').val());
				},
			
			error: function(){
				alert("Erreur, merci de contacter l'administrateur en lui donnant le code suivant : Erx0001");
			}
		});
	});
});