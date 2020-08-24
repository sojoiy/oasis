function demarrer(chantier)
{
	$.ajax({
         type:'POST',
         url:'/chantier/demarrer',
         headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		data: {
	        "id": chantier
	        },
         success:function(data){
            $("#actions_chantier").html(data);
         }
    });
}

function copierUrl(id)
{
	$('#js-copytextarea'+id).show();
	//var copyTextarea = document.querySelector('#js-copytextarea');
	$('#js-copytextarea'+id).select();
	
	try {
		var successful = document.execCommand('copy');
		var msg = successful ? 'L\'adresse a été copiée dans le presse papier, utilisez les touches Ctrl + V pour la copier dans votre message' : 'Erreur lors de la copie de l\'adresse';
		$('#resultatCopy').html(msg);
		$('#js-copytextarea'+id).hide();
	
	} catch (err) {
		$('#resultatCopy').html('Erreur lors de la copie de l\'adresse');
	}
}

function sendUrl(id)
{
	$.ajax({
         type:'POST',
         url:'/chantier/sendurl',
         headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		data: {
	        "id": id
	        },
         success:function(data){
            $("#intervenant_"+id).append(data);
         }
    });
}

function terminer(action)
{
	$.ajax({
         type:'POST',
         url:'/chantier/terminer',
         headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		data: {
	        "id": action
	        },
         success:function(data){
            $("#info_cloture").html(data);
         }
    });
}

function terminerGuest(action)
{
	$.ajax({
         type:'POST',
         url:'/chantier/terminerGuest',
         headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		data: {
	        "id": action
	        },
         success:function(data){
            $("#info_cloture").html(data);
         }
    });
}

function deleteAction(action)
{
	if(confirm('Souhaitez-vous supprimer cette action ?'))
	{
		$.ajax({
		         type:'POST',
		         url:'/chantier/deleteaction',
		         headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
				data: {
			        "id": action
			        },
		         success:function(data){
		            $("#action_"+action).remove();
		         }
		    });
	}
}

function deleteFile(justificatif)
{
	if(confirm('Souhaitez-vous supprimer ce document ?'))
	{
		$.ajax({
	         type:'POST',
	         url:'/chantier/deletefile',
	         headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			data: {
		        "id": justificatif
		        },
	         success:function(data){
	            $("#justificatif_"+justificatif).remove();
	         }
	    });
	}
}

function voirIntervenant(intervenant_ID)
{
	$.ajax({
         type:'POST',
         url:'/chantier/voirintervenantdo',
         headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		data: {
	        "id": intervenant_ID
	        },
         success:function(data){
            $("#frm-add").hide();
            $("#frm-change").show();
            $("#frm-change").html(data);
			$('html,body').animate({scrollTop: 0}, 'slow');
         }
    });
}

$(document).ready(function() {
	$("#ajouterIntervenant").submit(function( event ) {
		event.preventDefault();
		
		$.ajax({
			type: "POST",
			url: "/chantier/addnewintervenantdo",
			data: $("#ajouterIntervenant").serialize(),
				success: function(code){
					$('#listeIntervenants').html(code);
					$('#kt_modal_newintervenant').modal('hide');
				},
			
			error: function(){
				alert("Erreur, merci de contacter l'administrateur en lui donnant le code suivant : Erx0001");
			}
		});
	});
	
	$("#ajouterAction").submit(function( event ) {
		event.preventDefault();
		
		$.ajax({
			type: "POST",
			url: "/chantier/addnewaction",
			data: $("#ajouterAction").serialize(),
				success: function(code){
					$('#listeAction').html(code);
					$('#kt_modal_newaction').modal('hide');
				},
			
			error: function(){
				alert("Erreur, merci de contacter l'administrateur en lui donnant le code suivant : Erx0001");
			}
		});
	});
});
