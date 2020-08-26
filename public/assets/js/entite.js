// AFFICHE LA LISTE DES OPTIONS DISPONIBLE SELON LA SITUATION DU CLIENT
function refreshTypeEntite(typeEntiteID)
{
	$.ajax({
	         type:'POST',
	         url:'/entite/updateform',
	         headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			data: {
		        "id": typeEntiteID
		        },
	         success:function(data){
				 $('#zoneFormulaireEntite').html(data);
	         }
	      });
}

function afficherPiece(piece_ID)
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

function verifierIntervenant(nom, prenom, dateNaissance)
{
	$.ajax({
	         type:'POST',
	         url:'/intervenant/rechercher',
	         headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			data: {
		        "nom": nom,
				"prenom": prenom,
				"dateNaissance": dateNaissance
		        },
	         success:function(data){
	            $("#resultatRecherche").html(data);
	         }
	      });
}
function verifierVehicule(immatriculation)
{
	$.ajax({
	         type:'POST',
	         url:'/vehicule/rechercher',
	         headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			data: {
		        "immatriculation": immatriculation	
		        },
	         success:function(data){
	            $("#resultatRecherche").html(data);
	         }
	      });
}