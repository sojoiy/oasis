<div class="form-group row" id="date_{{ $id }}">
		<label class="col-lg-2 col-form-label">Date RDV *</label>
		<div class="col-lg-2">
			<input class="form-control" required name="date_rdv[]" type="datetime-local" required value="" id="example-datetime-local-input" >
		</div>
	
		<div class="col-lg-3">
			<button type="button" onclick="removeDate({{ $id }});" class="btn btn-danger"><i onclick="removeVisiteur({{ $id }});" class="fa fa-minus-circle"></i> Effacer</button>
		</div>
	</div>