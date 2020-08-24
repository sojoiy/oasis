// AFFICHE LA LISTE DES OPTIONS DISPONIBLE SELON LA SITUATION DU CLIENT
function saveHabilitation(habilitation_ID)
{
	$.ajax({
		type:'POST',
		url:'/comptes/addhabilitation',
		headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		data: {
			"id": habilitation_ID
		},
		success:function(data){
				
		     }
		});
}