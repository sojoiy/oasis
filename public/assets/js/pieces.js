// AFFICHE LA LISTE DES OPTIONS DISPONIBLE SELON LA SITUATION DU CLIENT
function savePiece(checked, field)
{
	$.ajax({
		type:'POST',
		url:'/comptes/savePiece',
		headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		data: {
			"key": checked,
			"field": field
		},
		success:function(data){
				
		     }
		});
}