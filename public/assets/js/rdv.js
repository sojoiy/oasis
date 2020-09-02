// AFFICHE LA LISTE DES OPTIONS DISPONIBLE SELON LA SITUATION DU CLIENT
function refreshValideur2(valideur)
{
	if(valideur != 0)
	{
		$.ajax({
		         type:'POST',
		         url:'/rdv/listeValideur',
		         headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
				data: {
					"valideur": valideur
			        },
		         success:function(data){
					$("#valideur2").html(data); 
		         }
		      });
	}
	else
	{
		$("#valideur2").html('');
	}
	
}


function supprimerRDV(rdvID)
{
	$.ajax({
	         type:'POST',
	         url:'/rdv/supprimer',
	         headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			data: {
		        "id": rdvID
		        },
	         success:function(data){
				$("#ligne_element"+rdvID).remove(); 
	         }
	      });
}


function ajouterVisiteur()
{
	$.ajax({
	         type:'POST',
	         url:'/chantier/getlignevisiteur',
	         headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			data: {
		        "id": 0
		        },
	         success:function(data){
	            $("#visitors").append(data);
	         }
	      });
}

function removeVisiteur(id)
{
	$("#ligne_"+id).remove();
	
}


function addDate()
{
	$.ajax({
	         type:'POST',
	         url:'/chantier/getlignedate',
	         headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			data: {
		        "id": 0
		        },
	         success:function(data){
	            $("#dates").append(data);
	         }
	      });
}


function removeDate(id)
{
	$("#date_"+id).remove();
}

function accepterRdv(id)
{
	if(confirm("Valider cet avis de rendez-vous ?"))
	{
		$.ajax({
		         type:'POST',
		         url:'/rdv/validerrdv',
		         headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
				data: {
			        "id": id
			        },
		         success:function(data){
		            $("#resultat").html(data);
		            $("#RdvForm")[0].submit();
		         }
		      });
	}
}


function refuserRdv(id)
{
	if(confirm("Refuser cet avis de rendez-vous ?"))
	{
		$.ajax({
		         type:'POST',
		         url:'/rdv/refuserrdv',
		         headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
				data: {
			        "id": id
			        },
		         success:function(data){
		            $("#resultat").html(data);
		            $("#RdvForm")[0].submit();
		         }
		      });
	}
}