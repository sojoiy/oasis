function supprimerDocument(document_ID)
{
	$.ajax({
	         type:'POST',
	         url:'/societe/deletedocument',
	         headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			data: {
		        "id": document_ID
		        },
	         success:function(data){
	            $("#p_"+document_ID).remove();
	         }
	      });
}

function deleteLink(link_ID)
{
	if(confirm('Souhaitez-vous supprimer le lien de consultation ?'))
	{
		$.ajax({
			         type:'POST',
			         url:'/societe/deletelink',
			         headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
					data: {
				        "id": link_ID
				        },
			         success:function(data){
			            $("#lien_"+link_ID).remove();
			         }
			      });
	}
	else
	{
		$("#link_"+link_ID).prop('checked', false);
		
	}
}

function sendLink(link_ID)
{
	$("#result_"+link_ID).html('<i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>');
	
	$.ajax({
         type:'POST',
         url:'/societe/sendlink',
         headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		data: {
	        "id": link_ID
	        },
         success:function(data){
            $("#result_"+link_ID).html(data);
         }
	});
}

function visualiserDocument(id)
{
	$('#acces_tiers').hide();$('#add_document').hide();$('#viewer').show();$('#seePiece').addClass('text-success');
	
	$.ajax({
         type:'POST',
         url:'/societe/visualiserdocument',
         headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		data: {
	        "id": id
	        },
         	success:function(data){
            	$('#viewer').html(data);
         	}
      });
}

function deleteCompte(user_ID)
{
	if(confirm('Souhaitez-vous supprimer ce compte ?'))
	{
		$.ajax({
			         type:'POST',
			         url:'/societe/deletecompte',
			         headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
					data: {
				        "id": user_ID
				        },
			         success:function(data){
			            $("#c_"+user_ID).remove();
			         }
			      });
	}
}

$(document).ready(function() {
	$("#frm-fiche-entreprise").submit(function( event ) {
		event.preventDefault();
		
		$.ajax({
			type: "POST",
			url: "/societe/change",
			data: $("#frm-fiche-entreprise").serialize(),
				success: function(code){
					$('#activite').html(code);
				},
			
			error: function(){
				alert("Erreur, merci de contacter l'administrateur en lui donnant le code suivant : Erx0001");
			}
		});
	});
	
	$("#creer-acces").submit(function( event ) {
		event.preventDefault();
		
		$.ajax({
			type: "POST",
			url: "/societe/addacces",
			data: $("#creer-acces").serialize(),
				success: function(code){
					$('#acces_tiers').html(code);
				},
			
			error: function(){
				alert("Erreur, merci de contacter l'administrateur en lui donnant le code suivant : Erx0001");
			}
		});
	});
});