<!-- DEBUT VALIDATION -->
<div class="kt-form kt-form--label-right">
	<div class="kt-form__body">
		@if($chantier->mecanisme == 2 || $chantier->mecanisme == 4)
			<div class="kt-section kt-section--first">
				<div class="kt-section__body">
					<div class="row">
						<label class="col-xl-3"></label>
						<div class="col-lg-9 col-xl-6">
							<h3 class="kt-section__title kt-section__title-sm":</h3>
						</div>
					</div>
					
					@if($intervenant->is_valid($chantier->do))
						<div class="form-group row">
							<label class="col-xl-3 col-lg-3 col-form-label">Validation Individuelle</label>
							<div class="col-lg-9 col-xl-9">
								<div class="input-group">
									<div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-stamp"></i></span></div>
									<input type="text" disabled name="password" class="form-control is-valid" value="{{ $intervenant->is_valid($chantier->do) }}" aria-describedby="basic-addon1">
								</div>
							</div>
						</div>
					@else
						<div class="form-group row">
							<label class="col-xl-3 col-lg-3 col-form-label">Validation Individuelle</label>
							<div class="col-lg-9 col-xl-9">
								<div class="input-group">
									<div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-stamp"></i></span></div>
									<input type="text" disabled name="password" class="form-control is-invalid" value="{{ $intervenant->is_valid($chantier->do) }}" aria-describedby="basic-addon1">
								</div>
							</div>
						</div>
					@endif
				</div>
			</div>
		@endif
		
		<!-- SI LE CHANTIER NECESSITE UNE VALIDATION DES INTERVENANTS ON LE DEMANDE -->
		
		@if($chantier->mecanisme == 3 || $chantier->mecanisme == 4)
			@if($intervenant->validation1)
				<div class="form-group row">
					<label class="col-xl-3 col-lg-3 col-form-label">Niveau 1</label>
					<div class="col-lg-9 col-xl-9">
						<div class="input-group">
							<div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-stamp"></i></span></div>
							<input type="text" disabled class="form-control is-valid" value="{{ $intervenant->info_validation1() }}" aria-describedby="basic-addon1">
						</div>
					</div>
				</div>
			@endif
			
			@if($intervenant->validation2)
				<div class="form-group row">
					<label class="col-xl-3 col-lg-3 col-form-label">Niveau 2</label>
					<div class="col-lg-9 col-xl-9">
						<div class="input-group">
							<div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-stamp"></i></span></div>
							<input type="text" disabled class="form-control is-valid" value="{{ $intervenant->info_validation1() }}" aria-describedby="basic-addon1">
						</div>
					</div>
				</div>
			@endif
			
			@if($intervenant->validation3)
				<div class="form-group row">
					<label class="col-xl-3 col-lg-3 col-form-label">Niveau 3</label>
					<div class="col-lg-9 col-xl-9">
						<div class="input-group">
							<div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-stamp"></i></span></div>
							<input type="text" disabled class="form-control is-valid" value="{{ $intervenant->info_validation1() }}" aria-describedby="basic-addon1">
						</div>
					</div>
				</div>
			@endif
			<br>
			@if($chantier->niveau_validation() >= 1 && !$intervenant->validation1 && $user->hasProfile($chantier->id, 1))
				<!-- VALIDATION DE NIVEAU 1 -->
				<div class="kt-section__body">
					<div class="form-group row">
						<label class="col-xl-3 col-lg-3 col-form-label"></label>
						<div class="col-lg-9 col-xl-9">
							<button type="button" {{ ($intervenant->complet()) ? '' : 'disabled' }} onclick="validerEquipier({{ $intervenant->id }}, 1)" class="btn btn-label-success btn-bold btn-sm "><i class="fa fa-check"></i> Valider l'intervenant (Niv 1)</button>
							<span class="form-text text-muted">
								@if($intervenant->complet())
									<i class="fa fa-exclamation-circle"></i> En validant ce dossier vous certifiez avoir vérifié les pièces obligatoires
								@else
									<i class="fa fa-exclamation-triangle"></i> Le dossier de cet intervenant est incomplet vous ne pouvez pas le valider
								@endif
							</span>
						</div>
					</div>
				</div>
			@endif
			
			@if($chantier->niveau_validation() >= 2 && $intervenant->validation1 && !$intervenant->validation2 && $user->hasProfile($chantier->id, 2))
				<div class="kt-section__body">
					<div class="form-group row">
						<label class="col-xl-3 col-lg-3 col-form-label"></label>
						<div class="col-lg-9 col-xl-9">
							<button type="button" {{ ($intervenant->complet()) ? '' : 'disabled' }} onclick="validerEquipier({{ $intervenant->id }}, 2)" class="btn btn-label-success btn-bold btn-sm "><i class="fa fa-check"></i> Valider l'intervenant (Niv 2)</button>
							<span class="form-text text-muted">
								@if($intervenant->complet())
									<i class="fa fa-exclamation-circle"></i> En validant ce dossier vous certifiez avoir vérifié les pièces obligatoires
								@else
									<i class="fa fa-exclamation-triangle"></i> Le dossier de cet intervenant est incomplet vous ne pouvez pas le valider
								@endif
							</span>
						</div>
					</div>
					<div class="form-group row kt-margin-t-10 kt-margin-b-10">
						<label class="col-xl-3 col-lg-3 col-form-label"></label>
						<div class="col-lg-9 col-xl-6">
							<button type="button" onclick="invaliderEquipier({{ $intervenant->id }})" class="btn btn-label-danger btn-bold btn-sm kt-margin-t-5 kt-margin-b-5"><i class="fa fa-ban"></i> Invalider</button>
						</div>
					</div>
				</div>
			@endif
			
			@if($chantier->niveau_validation() >= 3 && $intervenant->validation2 && !$intervenant->validation3 && $user->hasProfile($chantier->id, 3))
				<div class="kt-section__body">
					<div class="form-group row">
						<label class="col-xl-3 col-lg-3 col-form-label"></label>
						<div class="col-lg-9 col-xl-9">
							<button type="button" {{ ($user->complet()) ? '' : 'disabled' }} onclick="validerEquipier({{ $intervenant->id }}, 3)" class="btn btn-label-success btn-bold btn-sm "><i class="fa fa-check"></i> Valider l'intervenant (Niv 3)</button>
							<span class="form-text text-muted">
								@if($intervenant->complet())
									<i class="fa fa-exclamation-circle"></i> En validant ce dossier vous certifiez avoir vérifié les pièces obligatoires
								@else
									<i class="fa fa-exclamation-triangle"></i> Le dossier de cet intervenant est incomplet vous ne pouvez pas le valider
								@endif
							</span>
						</div>
					</div>
					<div class="form-group row kt-margin-t-10 kt-margin-b-10">
						<label class="col-xl-3 col-lg-3 col-form-label"></label>
						<div class="col-lg-9 col-xl-6">
							<button type="button" onclick="invaliderEquipier({{ $intervenant->id }})" class="btn btn-label-danger btn-bold btn-sm kt-margin-t-5 kt-margin-b-5"><i class="fa fa-ban"></i> Invalider</button>
						</div>
					</div>
				</div>
			@endif
		@else
			
		@endif
	</div>
</div>
<!-- FIN VALIDATION -->