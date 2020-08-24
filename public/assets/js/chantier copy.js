// AFFICHE LA LISTE DES OPTIONS DISPONIBLE SELON LA SITUATION DU CLIENT

function ajouterVisiteur()
{
	$.ajax({
	         type:'POST',
	         url:'/chantier/ajoutervisiteur',
	         headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			data: {
		        "id": 1
		        },
	         success:function(data){
	            $("#personnel_visite").append(data);
	         }
	      });
}