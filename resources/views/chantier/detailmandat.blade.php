<div class="card-header">
	<div class="card-title">
		<h3>
			Mandat #{{ $mandat->id }}
		</h3>
	</div>
</div>
<div class="card-body">
	<div class="form-group">
		<label>Création : {{ date('d/m/Y', strtotime($mandat->created_at)) }}</label><br>
		<label>Mandant : {{ $mandat->getMandant() }}</label><br>
		@if($mandat->date_debut)
			<label>Date de début : {{ date('d/m/Y', strtotime($mandat->date_debut)) }}</label><br>
		@endif
		
		@if($mandat->date_fin)
			<label>Date de fin : {{ date('d/m/Y', strtotime($mandat->date_fin)) }}</label><br>
		@endif
			
		<button type="button" class="btn btn-sm btn-warning btn-sm">
			<i class="fa fa-undo"></i> Annuler le mandat
		</button>
	</div>
</div>