<!-- begin:: Content Head -->
<div class="kt-subheader   kt-grid__item" id="kt_subheader">
	<div class="kt-subheader__main">
		<h3 class="kt-subheader__title">
			@if($livraison->do == $user->societeID)
				<i class="fa fa-share"></i>
			@else
				<i class="fa fa-reply"></i>
			@endif
			{{ $livraison->numero }}
		</h3>
		
		<span class="kt-subheader__separator kt-subheader__separator--v"></span>
		
		
		<a href="/livraisons/show/{{$livraison->id}}" class="btn btn-label-info {{ ($active == 'Informations') ? 'active' : '' }} btn-bold btn-sm btn-icon-h kt-margin-l-5">
			<i class="fa fa-info"></i> Informations
		</a>
		
		<a href="/livraisons/documents/{{$livraison->id}}" class="btn btn-label-info {{ ($active == 'Documents') ? 'active' : '' }} btn-bold btn-sm btn-icon-h kt-margin-l-5">
			<i class="fa fa-file"></i> Documents
		</a>
		
		<a href="/livraisons/intervenants/{{$livraison->id}}" class="btn btn-label-info {{ ($active == 'Intervenants') ? 'active' : '' }} btn-bold btn-sm btn-icon-h kt-margin-l-5">
			<i class="fa fa-user-friends"></i> Livreurs
		</a>
		
		<a href="/livraisons/vehicules/{{$livraison->id}}" class="btn btn-label-info {{ ($active == 'Véhicules') ? 'active' : '' }} btn-bold btn-sm btn-icon-h kt-margin-l-5">
			<i class="fa fa-truck"></i> Véhicules
		</a>
		
		<a href="/livraisons/mandats/{{$livraison->id}}" class="btn btn-label-info {{ ($active == 'Mandats') ? 'active' : '' }} btn-bold btn-sm btn-icon-h kt-margin-l-5">
			<i class="fa fa-sitemap"></i> Mandats
		</a>
		
		@if($livraison->do == $user->societeID)
			<a href="/livraisons/choixpresta/{{$livraison->id}}" class="btn btn-label-warning btn-bold btn-sm btn-icon-h kt-margin-l-5">
				<i class="fa fa-plus"></i> Gérer les titulaires
			</a>
		@else
			<a href="/livraisons/mandater/{{$livraison->id}}" class="btn btn-label-warning btn-bold btn-sm btn-icon-h kt-margin-l-5">
				<i class="fa fa-plus"></i> Ajouter un transporteur
			</a>
		@endif
	</div>
	<div class="kt-subheader__toolbar">
		
	</div>
</div>

<!-- end:: Content Head -->