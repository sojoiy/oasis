<!-- begin:: Content Head -->
<div class="kt-subheader   kt-grid__item" id="kt_subheader">
	<div class="kt-subheader__main">
		<h3 class="kt-subheader__title">{{ $active }}</h3>
		<span class="kt-subheader__separator kt-subheader__separator--v"></span>
		@if($active == 'Profil général' || $active == 'Profil détaillé')
			<a href="/societe/details" class="btn btn-label-info btn-bold btn-sm btn-icon-h kt-margin-l-10">
				<i class="fa fa-plus"></i> Profil général
			</a>
			<a href="/societe/details" class="btn btn-label-info btn-bold btn-sm btn-icon-h kt-margin-l-10">
				<i class="fa fa-plus"></i> Profil détaillé
			</a>
		@endif
		
		@if($active == 'Utilisateurs')
			<a href="/societe/creercompte" class="btn btn-label-info btn-bold btn-sm btn-icon-h kt-margin-l-10">
				<i class="fa fa-plus"></i> Ajouter
			</a>
		@endif
		
		@if($active == 'Documents')
			<button onclick="$('#viewer').hide();$('#add_document').show();" class="btn btn-label-info btn-bold btn-sm btn-icon-h kt-margin-l-10">
				<i class="fa fa-plus"></i> Ajouter un document
			</button>
			
			<a href="#" data-toggle="modal" data-target="#kt_modal_createlink" class="btn btn-label-info btn-bold btn-sm btn-icon-h kt-margin-l-10">
				<i class="fa fa-plus"></i> Ajouter un accès
			</a>
		@endif
	</div>
</div>

<!-- end:: Content Head -->