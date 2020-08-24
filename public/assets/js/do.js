// AFFICHE LA LISTE DES OPTIONS DISPONIBLE SELON LA SITUATION DU CLIENT
function changeStatus(compteID, field)
{
	$.ajax({
	         type:'POST',
	         url:'/comptes/changerdroits',
	         headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			data: {
		        "id": compteID,
		        "field": field
		        },
	         success:function(data){
	            
	         }
	      });
}

function resetPassword(user_ID)
{
	$.ajax({
	     type:'POST',
	     url:'/user/resetpassword',
	     headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		data: {
	        "user_ID": (user_ID)
	        },
	     success:function(data){
			 alert('Mot de passe modifier : Password*');
	     }
	});
}