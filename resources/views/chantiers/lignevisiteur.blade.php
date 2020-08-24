<div class="form-group row" id="ligne_{{ $id }}">
	<label class="col-lg-2 col-form-label">Nom *</label>
	<div class="col-lg-2">
		<input type="text" required name="nom_visiteur[]" class="form-control" placeholder="Nom">
	</div>

	<label class="col-lg-1 col-form-label">Prénom *</label>
	<div class="col-lg-2">
		<input type="text" required name="prenom_visiteur[]" class="form-control" placeholder="Prénom">
	</div>

	<label class="col-lg-1 col-form-label">Société *</label>
	<div class="col-lg-2">
		<input type="text" required name="societe_visiteur[]" class="form-control" placeholder="Société">
	</div>
	<div class="col-lg-2">
		<label class="col-lg-1 col-form-label"><i onclick="removeVisiteur({{ $id }});" class="fa fa-2x fa-minus-circle"></i></label>
	</div>
</div>