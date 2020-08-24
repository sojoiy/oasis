// AFFICHE LA LISTE DES OPTIONS DISPONIBLE SELON LA SITUATION DU CLIENT

function saveTypeDossier(type_ID, value, field)
{
	$.ajax({
	         type:'POST',
	         url:'/comptes/saveTypeDossier',
	         headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			data: {
		        "type": type_ID,
		        "value": value,
		        "field": field
		        },
	         success:function(data){
	            $("#viewer").html(data);
	         }
	      });
}

function saveTypeLivraison(type_ID, value, field)
{
	$.ajax({
	         type:'POST',
	         url:'/comptes/saveTypeLivraison',
	         headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			data: {
		        "type": type_ID,
		        "value": value,
		        "field": field
		        },
	         success:function(data){
	            $("#viewer").html(data);
	         }
	      });
}

function refreshCas(cas, type_ID)
{
	if(cas == 1 || cas == 2)
	{
		$('#niv1_'+type_ID).html('Non requis');
		$('#niv2_'+type_ID).html('Non requis');
		$('#niv3_'+type_ID).html('Non requis');
	}
	else
	{
		refreshSelect(type_ID, 1);
		refreshSelect(type_ID, 2);
		refreshSelect(type_ID, 3);
	}
}

function refreshSelect(type_ID, niv)
{
	$.ajax({
	         type:'POST',
	         url:'/comptes/refreshSelect',
	         headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			data: {
		        "type": type_ID,
		        "niveau": niv
		        },
	         success:function(data){
	            $('#niv'+ niv +'_'+type_ID).html(data);
	         }
	      });
}