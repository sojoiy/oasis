// AFFICHE LA LISTE DES OPTIONS DISPONIBLE SELON LA SITUATION DU CLIENT
function deleteEntite(entite_ID)
{
	if(confirm('Souhaitez-vous définitivement supprimer cet élément ?'))
	{
		$.ajax({
		         type:'POST',
		         url:'/entite/deleteelement',
		         headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
				data: {
			        "id": entite_ID
			        },
		         success:function(data){
		            $("#e_" + entite_ID).remove();
		         }
		      });
	}
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