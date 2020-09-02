<a href="/chantier/intervenant/{{ $entite->id }}"><i class="fa fa-eye fa-2x text-info"></i></a>

@if($user->checkRights("telecharger_pieces"))
	<a href="/chantier/archive/{{ $entite->id }}"><i class="fa fa-file-archive fa-2x text-success"></i></a>
@endif

@if($livraison->mecanisme == 3 || $livraison->mecanisme == 4)
	@if($livraison->niveau_validation() >= 1)
		@if($entite->validation1)
			<i class="fa fa-check-circle fa-2x text-success"></i>
		@else
			<i class="fa fa-question-circle fa-2x text-default"></i>
		@endif	
	@endif
	
	@if($livraison->niveau_validation() >= 2)
		@if($entite->validation2)
			<i class="fa fa-check-circle fa-2x text-success"></i>
		@else
			<i class="fa fa-question-circle fa-2x text-default"></i>
		@endif	
	@endif
	
	@if($livraison->niveau_validation() >= 3)
		@if($entite->validation3)
			<i class="fa fa-check-circle fa-2x text-success"></i>
		@else
			<i class="fa fa-question-circle fa-2x text-default"></i>
		@endif	
	@endif
@endif