<a href="/chantier/intervenant/{{ $entite->id }}"><i class="fa fa-eye fa-2x text-info"></i></a>

@if($user->checkRights("telecharger_pieces"))
	<a href="/chantier/archive/{{ $entite->id }}"><i class="fa fa-file-archive fa-2x text-success"></i></a>
@endif

@if($chantier->mecanisme == 3 || $chantier->mecanisme == 4)
	@if($chantier->niveau_validation() >= 1)
		@if($entite->validation1)
			<i class="fa fa-check-circle fa-2x text-success"></i>
		@else
			<i class="fa fa-question-circle fa-2x text-default"></i>
		@endif	
	@endif
	
	@if($chantier->niveau_validation() >= 2)
		@if($entite->validation2)
			<i class="fa fa-check-circle fa-2x text-success"></i>
		@else
			<i class="fa fa-question-circle fa-2x text-default"></i>
		@endif	
	@endif
	
	@if($chantier->niveau_validation() >= 3)
		@if($entite->validation3)
			<i class="fa fa-check-circle fa-2x text-success"></i>
		@else
			<i class="fa fa-question-circle fa-2x text-default"></i>
		@endif	
	@endif
@endif