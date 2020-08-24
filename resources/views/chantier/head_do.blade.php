<!-- begin:: Content Head -->
<div class="kt-subheader   kt-grid__item" id="kt_subheader">
	<div class="kt-subheader__main">
		<h3 class="kt-subheader__title">
			<i class="fa fa-exchange-alt"></i>
			{{ $chantier->numero }}
		</h3>
		
		<span class="kt-subheader__separator kt-subheader__separator--v"></span>
		
		@if(isset($guest))
			<a href="/chantier/showDoGuest/{{ $intervenant->accesskey }}" class="btn btn-label-info {{ ($active == 'Informations') ? 'active' : '' }} btn-bold btn-sm btn-icon-h kt-margin-l-5">
				<i class="fa fa-info"></i> Informations
			</a>
		
			<!-- TODO QUI PEUT GERER CA -->
			<a href="/chantier/accesaction/{{ $intervenant->accesskey }}" class="btn btn-label-info {{ ($active == 'Actions') ? 'active' : '' }} btn-bold btn-sm btn-icon-h kt-margin-l-5">
				<i class="fa fa-user-check"></i> Actions
			</a>
		@else
			<a href="/chantier/showDo/{{$chantier->id}}" class="btn btn-label-info {{ ($active == 'Informations') ? 'active' : '' }} btn-bold btn-sm btn-icon-h kt-margin-l-5">
				<i class="fa fa-info"></i> Informations
			</a>
		
			<a href="/chantier/intervenantsDo/{{$chantier->id}}" class="btn btn-label-info {{ ($active == 'Intervenants') ? 'active' : '' }} btn-bold btn-sm btn-icon-h kt-margin-l-5">
				<i class="fa fa-user-friends"></i> Intervenants
			</a>
		
			<!-- TODO QUI PEUT GERER CA -->
			<a href="/chantier/actionsDo/{{$chantier->id}}" class="btn btn-label-info {{ ($active == 'Actions') ? 'active' : '' }} btn-bold btn-sm btn-icon-h kt-margin-l-5">
				<i class="fa fa-user-check"></i> Actions
			</a>
		
			<!-- TODO QUI PEUT GERER CA -->
			<a href="/chantier/validation/{{$chantier->id}}" class="btn btn-label-info btn-bold btn-sm btn-icon-h kt-margin-l-5">
				<i class="fa fa-user-check"></i> Exporter
			</a>
		@endif
	</div>
	<div class="kt-subheader__toolbar">
		
	</div>
</div>

<!-- end:: Content Head -->