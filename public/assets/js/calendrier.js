// AFFICHE LA LISTE DES OPTIONS DISPONIBLE SELON LA SITUATION DU CLIENT
function ajouterHoraires()
{
	$.ajax({
	         type:'POST',
	         url:'/calendrier/ajouterLigne',
	         headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			data: {},
	         success:function(data){
	            $("#ligneAjoutLundi").before(data);
	         }
	      });
}

function refreshCas(cas, type_ID)
{
	if(cas == 1 || cas == 2)
	{
		$('#niv1_'+type_ID).html('Non requis');
		$('#niv2_'+type_ID).html('Non requis');
		$('#niv3_'+type_ID).html('Non requis');
	}
	else
	{
		refreshSelect(type_ID, 1);
		refreshSelect(type_ID, 2);
		refreshSelect(type_ID, 3);
	}
}

function refreshSelect(type_ID, niv)
{
	$.ajax({
	         type:'POST',
	         url:'/comptes/refreshSelect',
	         headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			data: {
		        "type": type_ID,
		        "niveau": niv
		        },
	         success:function(data){
	            $('#niv'+ niv +'_'+type_ID).html(data);
	         }
	      });
}


function recreerCreneaux(semaine)
{
	$.ajax({
	         type:'POST',
	         url:'/calendrier/creerCreneaux',
	         headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			data: {
		        "semaine": semaine
		        },
	         success:function(data){
	            
	         }
	      });
}



function changerNomTypeSemaine(libelle, type_ID)
{
	$.ajax({
	         type:'POST',
	         url:'/calendrier/changertype',
	         headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			data: {
		        "type": type_ID,
		        "libelle": libelle
		        },
	         success:function(data){
	         }
	      });
}

function removeCreneau(typeID, key, jour)
{
	if(confirm("Souhaitez-vous supprimer ce créneau ?"))
	{
		$.ajax({
			type: "POST",
			url: "/calendrier/delete",
			headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},		
			data: {
		        "id": typeID,
				"key": key,
		        "jour": jour
		     },
	         success:function(data){
	            $('#'+jour).html(data);
	         }
		});
	}
}

$(document).ready(function() {
	$("#ajoutLundi").submit(function( event ) {
		event.preventDefault();
		
		$.ajax({
			type: "POST",
			url: "/calendrier/ajoutercreneau",
			data: $("#ajoutLundi").serialize(),
				success: function(code){
					$('#Lundi').html(code);
					$("#ajoutLundi")[0].reset();
				},
			
			error: function(){
				alert("Erreur, merci de contacter l'administrateur en lui donnant le code suivant : Erx0001");
			}
		});
	});
	
	$("#ajoutMardi").submit(function( event ) {
		event.preventDefault();
		
		$.ajax({
			type: "POST",
			url: "/calendrier/ajoutercreneau",
			data: $("#ajoutMardi").serialize(),
				success: function(code){
					$('#Mardi').html(code);
					$("#ajoutMardi")[0].reset();
				},
			
			error: function(){
				alert("Erreur, merci de contacter l'administrateur en lui donnant le code suivant : Erx0001");
			}
		});
	});
	
	$("#ajoutMercredi").submit(function( event ) {
		event.preventDefault();
		
		$.ajax({
			type: "POST",
			url: "/calendrier/ajoutercreneau",
			data: $("#ajoutMercredi").serialize(),
				success: function(code){
					$('#Mercredi').html(code);
					$("#ajoutMercredi")[0].reset();
				},
			
			error: function(){
				alert("Erreur, merci de contacter l'administrateur en lui donnant le code suivant : Erx0001");
			}
		});
	});
	
	$("#ajoutJeudi").submit(function( event ) {
		event.preventDefault();
		
		$.ajax({
			type: "POST",
			url: "/calendrier/ajoutercreneau",
			data: $("#ajoutJeudi").serialize(),
				success: function(code){
					$('#Jeudi').html(code);
					$("#ajoutJeudi")[0].reset();
				},
			
			error: function(){
				alert("Erreur, merci de contacter l'administrateur en lui donnant le code suivant : Erx0001");
			}
		});
	});
	
	$("#ajoutVendredi").submit(function( event ) {
		event.preventDefault();
		
		$.ajax({
			type: "POST",
			url: "/calendrier/ajoutercreneau",
			data: $("#ajoutVendredi").serialize(),
				success: function(code){
					$('#Vendredi').html(code);
					$("#ajoutVendredi")[0].reset();
				},
			
			error: function(){
				alert("Erreur, merci de contacter l'administrateur en lui donnant le code suivant : Erx0001");
			}
		});
	});
	
	$("#ajoutSamedi").submit(function( event ) {
		event.preventDefault();
		
		$.ajax({
			type: "POST",
			url: "/calendrier/ajoutercreneau",
			data: $("#ajoutSamedi").serialize(),
				success: function(code){
					$('#Samedi').html(code);
					$("#ajoutSamedi")[0].reset();
				},
			
			error: function(){
				alert("Erreur, merci de contacter l'administrateur en lui donnant le code suivant : Erx0001");
			}
		});
	});
	
	$("#ajoutDimanche").submit(function( event ) {
		event.preventDefault();
		
		$.ajax({
			type: "POST",
			url: "/calendrier/ajoutercreneau",
			data: $("#ajoutDimanche").serialize(),
				success: function(code){
					$('#Dimanche').html(code);
					$("#ajoutDimanche")[0].reset();
				},
			
			error: function(){
				alert("Erreur, merci de contacter l'administrateur en lui donnant le code suivant : Erx0001");
			}
		});
	});
});