// AFFICHE LA LISTE DES OPTIONS DISPONIBLE SELON LA SITUATION DU CLIENT
function changerStatut(societeID, value)
{
	$.ajax({
	         type:'POST',
	         url:'/admin/changerstatut',
	         headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			data: {
		        "id": societeID,
		        "value": value
		        },
	         success:function(data){
				 $('#zone_statut').html(data);
	         }
	      });
}

function resetPassword(societeID)
{
	$.ajax({
	        type:'POST',
	        url:'/admin/resetpassword',
	        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			data: {
		        "id": societeID
		        },
	         success:function(data){
				 alert(data);
	         }
	      });
}

function addPieceDetachement(soc, ent, value)
{
	$.ajax({
	         type:'POST',
	         url:'/admin/enregistrerpieces',
	         headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			data: {
		        "soc": soc,
		        "ent": ent,
		        "value": value
		        },
	         success:function(data){
				 
	         }
	      });
}

function removePieceDetachement(soc, ent)
{
	console.log('TOTO');
}