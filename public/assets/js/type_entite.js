// AFFICHE LA LISTE DES OPTIONS DISPONIBLE SELON LA SITUATION DU CLIENT
function supprimerDocument(documentID)
{
	if(confirm('Supprimer ce type de document ?'))
	{
		$.ajax({
		         type:'POST',
		         url:'/entite/supprimerdocument',
		         headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
				data: {
			        "id": documentID
			        },
		         success:function(data){
					 $('#ligne_'+documentID).remove();
		         }
		      });
	}
}

function supprimerTypeEntite(typeEntiteID)
{
	if(confirm('Supprimer ce type d\'entité ?'))
	{
		$.ajax({
		         type:'POST',
		         url:'/entite/supprimertype',
		         headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
				data: {
			        "id": typeEntiteID
			        },
		         success:function(data){
					 $('#ligne_entite_'+typeEntiteID).remove();
		         }
		      });
	}
}

$(document).ready(function() {
	$("#ajout_document").submit(function( event ) {
		event.preventDefault();
		
		$.ajax({
			type: "POST",
			url: "/entite/adddocument",
			data: $("#ajout_document").serialize(),
				success: function(code){
					$('#lesDocuments').html(code);
					$('#kt_modal_ajouterType').modal('hide');
				},
			
			error: function(){
				alert("Erreur, merci de contacter l'administrateur en lui donnant le code suivant : Erx0001");
			}
		});
	});
});