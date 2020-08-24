<a href="/chantier/vehicule/{{ $vehicule->id }}"><i class="fa fa-eye fa-2x text-info"></i></a>
@if(!$vehicule->validation && $chantier->validation_rdv)
	@if(!$vehicule->complet())
		<i onclick="forcerValiderEquipier({{ $vehicule->id }})" class="fa fa-check-circle fa-2x text-warning"></i>
	@else
		<i onclick="validerEquipier({{ $vehicule->id }})" class="fa fa-check-circle fa-2x text-success"></i>
	@endif
	<i onclick="invaliderEquipier({{ $vehicule->id }})" class="fa fa-times-circle fa-2x text-danger"></i>
@else
	@if($chantier->validation_rdv == 0)
		
	@else
		@if($chantier->validation_rdv_niv2 <> 0)
			<i class="fa fa-info-circle fa-2x text-info" data-toggle="kt-popover" title="{{ ($vehicule->cle != NULL) ? 'Validé' : 'Invalidé' }} le {{ date('d/m/Y H:i', strtotime($vehicule->validation)) }}" data-content="Niveau 1 : {{ $vehicule->info_validation1() }} - Niveau 2 : {{ $vehicule->info_validation2() }}"></i>
		@else
			<i class="fa fa-info-circle fa-2x text-info" data-toggle="kt-popover" title="{{ ($vehicule->cle != NULL) ? 'Validé' : 'Invalidé' }} le {{ date('d/m/Y H:i', strtotime($vehicule->validation)) }}" data-content="{{ $vehicule->info_validation1() }}"></i>
		@endif
	@endif
@endif