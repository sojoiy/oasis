// AFFICHE LA LISTE DES OPTIONS DISPONIBLE SELON LA SITUATION DU CLIENT
function supprimerPiece(piece_ID)
{
	$.ajax({
	         type:'POST',
	         url:'/intervenant/deletepiece',
	         headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			data: {
		        "id": piece_ID
		        },
	         success:function(data){
	            $("#p_"+piece_ID).remove();
	         }
	      });
}

function rechargerPiece(entite, typePiece, myDo)
{
	if(confirm('Souhaitez-vous recharger la pièce ?'))
	{
		$.ajax({
			         type:'POST',
			         url:'/intervenant/rechargerpiece',
			         headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
					data: {
				        "entite": entite,
				        "typePiece": typePiece,
						"do": myDo
				        },
			         success:function(data){
						 $('#zone_'+typePiece+'_'+myDo).html(data);
			         }
			      });
	}
}

function saveHabilitation(entite, habilitation)
{
	$.ajax({
	         type:'POST',
	         url:'/intervenant/savehabilitation',
	         headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			data: {
		        "entite": entite,
		        "habilitation": habilitation
		        },
	         success:function(data){
	            
	         }
	      });
}

function afficherDocument(piece_ID, myDo)
{
	$.ajax({
	         type:'POST',
	         url:'/intervenant/afficherpiece',
	         headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			data: {
		        "id": piece_ID,
		        "do": myDo
		        },
	         success:function(data){
	            $("#viewer").html(data);
	         }
	      });
}

function updateFileID()
{
	$.ajax({
	        type:'POST',
	        url:'/intervenant/gettoken',
	       	headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			success:function(data){
	            $("#fileID").val(data);
	         }
	      });
}
 
function renewAuthorisation(autorisation)
{
	$.ajax({
	        type:'POST',
	        url:'/intervenant/renewautorisation',
	       	headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			data: {
		        "autorisation": piece_ID,
		        },
			success:function(data){
	            $("#infos_autorisation").html(data);
	         }
	      });
}

$(document).ready(function() {
	var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
	var myDropzone = new Dropzone("div#m_dropzone_three", { 
		url: "/intervenant/upload",
		headers: { 'x-csrf-token': CSRF_TOKEN }
	});
	
	myDropzone.on("complete", function(file) {
	   	// ON MET A JOUR LE TOKEN DU FILE ID
	});
	
	myDropzone.on("sending", function(file, xhr, formData) {
	      formData.append("data", $('#file_ID').val());
	});
	
	
	$("#charger-piece").submit(function( event ) {
		event.preventDefault();
		
		$.ajax({
			type: "POST",
			url: "/intervenant/addpiece",
			data: $("#charger-piece").serialize(),
				success: function(code){
					$('#activite').html(code);
					myDropzone.removeAllFiles();
					updateFileID();
				},
			
			error: function(){
				alert("Erreur, merci de contacter l'administrateur en lui donnant le code suivant : Erx0001");
			}
		});
	});
});