<!-- DEBUT VALIDATION -->
<div class="kt-form kt-form--label-right">
	<div class="kt-form__body">
		@if($chantier->validation_rdv)
			<div class="kt-section kt-section--first">
				<div class="kt-section__body">
					<div class="row">
						<label class="col-xl-3"></label>
						<div class="col-lg-9 col-xl-6">
							<h3 class="kt-section__title kt-section__title-sm":</h3>
						</div>
					</div>
					
					@if($chantier->validation_rdv_niv1 <> 0)
						<div class="form-group row">
							<label class="col-xl-3 col-lg-3 col-form-label">Validation niv 1</label>
							<div class="col-lg-9 col-xl-9">
								<div class="input-group">
									<div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-{{ ($vehicule->validation1) ? 'stamp' : 'hourglass-start'}}"></i></span></div>
									<input type="text" disabled name="password" class="form-control {{ ($vehicule->validation1) ? 'is-valid' : ''}}" value="{{ $vehicule->info_validation1() }}" aria-describedby="basic-addon1">
								</div>
							</div>
						</div>
					@endif
					
					@if($chantier->validation_rdv_niv2 <> 0)
						<div class="form-group row">
							<label class="col-xl-3 col-lg-3 col-form-label">Validation niv 2</label>
							<div class="col-lg-9 col-xl-9">
								<div class="input-group">
									<div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-{{ ($vehicule->validation2) ? 'stamp' : 'hourglass-start'}}"></i></span></div>
									<input type="text" disabled name="password" class="form-control {{ ($vehicule->validation2) ? 'is-valid' : ''}}" value="{{ $vehicule->info_validation2() }}" aria-describedby="basic-addon1">
								</div>
							</div>
						</div>
					@endif
				</div>
			</div>
		@endif
		
		<!-- SI LE CHANTIER NECESSITE UNE VALIDATION DES vehiculeS ON LE DEMANDE -->
		@if($chantier->validation_rdv)
		
			<!-- VALIDATION DE NIVEAU 1 -->
			@if(!$vehicule->validation1 && $chantier->validation_rdv_niv1 == $user->profil)
				<div class="kt-section__body">
					<div class="form-group row">
						<label class="col-xl-3 col-lg-3 col-form-label"></label>
						<div class="col-lg-9 col-xl-9">
							<button type="button" {{ ($vehicule->complet()) ? '' : 'disabled' }} onclick="validerEquipier2({{ $vehicule->id }})" class="btn btn-label-success btn-bold btn-sm "><i class="fa fa-check"></i> Valider le véhicule (Niv 1)</button>
							<span class="form-text text-muted">
								@if($vehicule->complet())
									<i class="fa fa-exclamation-circle"></i> En validant ce dossier vous certifiez avoir vérifié les pièces obligatoires
								@else
									<i class="fa fa-exclamation-triangle"></i> Le dossier de cet vehicule est incomplet vous ne pouvez pas le valider
								@endif
							</span>
						</div>
					</div>
					<div class="form-group row kt-margin-t-10 kt-margin-b-10">
						<label class="col-xl-3 col-lg-3 col-form-label"></label>
						<div class="col-lg-9 col-xl-6">
							<button type="button" onclick="invaliderEquipier({{ $vehicule->id }})" class="btn btn-label-danger btn-bold btn-sm kt-margin-t-5 kt-margin-b-5"><i class="fa fa-ban"></i> Invalider</button>
						</div>
					</div>
				</div>
			@endif
			
			<!-- VALIDATION DE NIVEAU 2 -->
			@if(!$vehicule->validation2 && $chantier->validation_rdv_niv2 == $user->profil)
				<div class="kt-section__body">
					<div class="form-group row">
						<label class="col-xl-3 col-lg-3 col-form-label"></label>
						<div class="col-lg-9 col-xl-9">
							<button type="button" {{ ($vehicule->complet()) ? '' : 'disabled' }} onclick="validerEquipier2({{ $vehicule->id }})" class="btn btn-label-success btn-bold btn-sm "><i class="fa fa-check"></i> Valider le véhicule (Niv 2)</button>
							<span class="form-text text-muted">
								@if($vehicule->complet())
									<i class="fa fa-exclamation-circle"></i> En validant ce dossier vous certifiez avoir vérifié les pièces obligatoires
								@else
									<i class="fa fa-exclamation-triangle"></i> Le dossier de cet vehicule est incomplet vous ne pouvez pas le valider
								@endif
							</span>
						</div>
					</div>
					<div class="form-group row kt-margin-t-10 kt-margin-b-10">
						<label class="col-xl-3 col-lg-3 col-form-label"></label>
						<div class="col-lg-9 col-xl-6">
							<button type="button" onclick="invaliderEquipier({{ $vehicule->id }})" class="btn btn-label-danger btn-bold btn-sm kt-margin-t-5 kt-margin-b-5"><i class="fa fa-ban"></i> Invalider</button>
						</div>
					</div>
				</div>
			@endif
		@else
			
		@endif
	</div>
</div>
<!-- FIN VALIDATION -->