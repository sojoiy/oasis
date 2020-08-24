<!-- begin:: Content Head -->
<div class="kt-subheader   kt-grid__item" id="kt_subheader">
	<div class="kt-subheader__main">
		<h3 class="kt-subheader__title">
			@if($chantier->do == $user->societeID)
				<i class="fa fa-share"></i>
			@else
				<i class="fa fa-reply"></i>
			@endif
			{{ $chantier->numero }}
		</h3>
		
		<span class="kt-subheader__separator kt-subheader__separator--v"></span>
		
		
		<a href="/chantier/show/{{$chantier->id}}" class="btn btn-label-info {{ ($active == 'Informations') ? 'active' : '' }} btn-bold btn-sm btn-icon-h kt-margin-l-5">
			<i class="fa fa-info"></i> Informations
		</a>
		
		<a href="/chantier/intervenants/{{$chantier->id}}" class="btn btn-label-info {{ ($active == 'Intervenants') ? 'active' : '' }} btn-bold btn-sm btn-icon-h kt-margin-l-5">
			<i class="fa fa-user-friends"></i> Intervenants
		</a>
		
		<a href="/chantier/vehicules/{{$chantier->id}}" class="btn btn-label-info {{ ($active == 'Véhicules') ? 'active' : '' }} btn-bold btn-sm btn-icon-h kt-margin-l-5">
			<i class="fa fa-truck"></i> Véhicules
		</a>
		
		<a href="/chantier/mandats/{{$chantier->id}}" class="btn btn-label-info {{ ($active == 'Mandats') ? 'active' : '' }} btn-bold btn-sm btn-icon-h kt-margin-l-5">
			<i class="fa fa-sitemap"></i> Mandats
		</a>
		
		@if($chantier->do == $user->societeID)
			<a href="#" data-toggle="modal" data-target="#kt_modal_prorogation" class="btn btn-label-warning btn-bold btn-sm btn-icon-h kt-margin-l-5">
				<i class="fa fa-stopwatch"></i> Proroger
			</a>
			
			<a href="/chantier/choixpresta/{{$chantier->id}}" class="btn btn-label-warning btn-bold btn-sm btn-icon-h kt-margin-l-5 {{ ($active == 'Titulaires') ? 'active' : '' }} ">
				<i class="fa fa-plus"></i> Gérer les titulaires
			</a>
		@else
			<a href="/chantier/mandater/{{$chantier->id}}" class="btn btn-label-warning btn-bold btn-sm btn-icon-h kt-margin-l-5">
				<i class="fa fa-plus"></i> Ajouter un prestataire
			</a>
		@endif
	</div>
	<div class="kt-subheader__toolbar">
		
	</div>
</div>

<!-- end:: Content Head -->