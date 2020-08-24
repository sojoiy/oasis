<input type="hidden" name="id" value="{{ $habilitation->id }}" />
	{{ csrf_field() }}
	<div class="card-body">
		<div class="kt-section kt-section--first">
			<div class="form-group row">
				<label class="col-4  col-form-label">Libéllé : *</label>
				<div class="col-3">
					<input type="text" name="libelle" value="{{ $habilitation->libelle }}" required class="form-control" placeholder="Libellé">
				</div>
			</div>
			<div class="form-group row">
				<label class="col-4  col-form-label">Obligatoire :</label>
				<div class="col-3">
					<span class="kt-switch">
						<label>
							<input type="checkbox" {{ $habilitation->obligatoire ? 'checked' : '' }} name="obligatoire" />
							<span></span>
						</label>
					</span>
				</div>
			</div>
		</div>
	</div>
	<div class="card-footer d-flex justify-content-between">
		<div class="kt-form__actions">
			<button type="submit" class="btn btn-primary">Valider</button>
			<button type="reset" class="btn btn-secondary">Annuler</button>
		</div>
	</div>