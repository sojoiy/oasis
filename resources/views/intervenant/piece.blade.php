<div class="card card-custom" id="viewer">
	<div class="card-header">
		<div class="card-title">
			<h3>{{ $piece->type_piece() }} {{ ($piece->libelle) ? " - ".$piece->libelle : "" }}</h3>
		</div>
		<div class="card-toolbar">
			@if($piece->do == NULL)
				<div class="dropdown dropdown-inline">
					<a href="/intervenant/deletepiece/{{ $piece->id }}" class="btn btn-sm btn-icon btn-light-danger mr-2">
						<i id="addPiece" class="flaticon2-delete"></i>
					</a>
				</div>
			@endif
			
			@if($user->checkRights("rejuger_pieces"))
				<div class="dropdown dropdown-inline">
					<a href="/chantier/decisionpiece/{{ $piece->id }}" target="_blank" class="btn btn-sm btn-light-danger">
						<i id="addPiece" class="fa fa-gavel"></i> Rejuger la pièce
					</a>
				</div>
			@endif
			
			@if($piece->extension != 'pdf')
				<a href="#" class="btn btn-sm btn-icon btn-light-success mr-2">
					<i class="flaticon2-download"></i>
				</a>
			@endif
		</div>
	</div>
	<div class="card-body">
		@if($piece->extension == 'pdf')
			<iframe src = "/temp/ViewerJS/#../{{ $key }}.pdf" width='100%' height='600' allowfullscreen webkitallowfullscreen></iframe>
		@else
			<img src="/temp/{{ $key }}.{{ $piece->extension }}" width="300" />
		@endif
	</div>
</div>