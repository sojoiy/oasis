@extends('layout.default')

@include('chantier.head_do', ['active' => 'Informations'])

@section('content')
<!-- begin:: Content Head -->
@include('chantier.modal_prorogation', ['chantier' => $chantier])	

<!-- begin:: Content -->
<div class="card card-custom">
								
	<!--Begin::Section-->
	<div class="row">
		
		<div class="col-xl-6">
			<div class="card card-custom">
				<div class="card-header">
					<div class="card-title">
						<h3>
							Chantier
						</h3>
					</div>
				</div>
				<div class="card-body">
					<!--begin::Form-->
					<form class="kt-form" method="POST" action="/chantier/savevalidation">
						<input type="hidden" name="chantier" value="{{ $chantier->id }}">
						{{ csrf_field() }}
						<div class="card-body">
							<div class="kt-section kt-section--first">
								<div class="form-group row">
									<label class="col-4  col-form-label">Validation pièces : *</label>
									<div class="col-3">
										<span class="kt-switch">
											<label>
												<input type="checkbox" {{ ($chantier->validation_pieces == 1) ? 'checked' : '' }} name="validation_pieces" />
												<span></span>
											</label>
										</span>
									</div>
								</div>
								
								<div class="form-group row">
									<label class="col-4  col-form-label">Validation des intervenants : *</label>
									<div class="col-3">
										<span class="kt-switch">
											<label>
												<input type="checkbox" {{ ($chantier->validation_entites == 1) ? 'checked' : '' }} onclick="if(this.checked){$('#intervenant_niv1').prop('disabled', false);$('#intervenant_niv2').prop('disabled', false);}else{$('#intervenant_niv1').prop('disabled', true);$('#intervenant_niv2').prop('disabled', true);}" name="validation_entites" />
												<span></span>
											</label>
										</span>
									</div>
								</div>
								
								<div class="form-group row">
									<label class="col-4  col-form-label">Habilité niveau 1 : *</label>
									<div class="col-3">
										<span class="kt-switch">
											<label>
												<select id="intervenant_niv1" {{ ($chantier->validation_entites == 1) ? '' : 'disabled' }} name="niveau_1" class="form-control">
													@foreach($profils as $profil)
														<option {{ ($chantier->validation_entites == $profil->id) ? 'selected' : '' }} value="{{ $profil->id }}">{{ $profil->libelle_complet() }}</option>
													@endforeach
												</select>
												<span></span>
											</label>
										</span>
									</div>
								</div>
								
								<div class="form-group row">
									<label class="col-4  col-form-label">Habilité niveau 2 : *</label>
									<div class="col-3">
										<span class="kt-switch">
											<label>
												<select id="intervenant_niv2" {{ ($chantier->validation_entites == 1) ? '' : 'disabled' }}  name="niveau_2" class="form-control">
													<option value="0">Non requis</option>
													@foreach($profils as $profil)
														<option {{ ($chantier->validation_entites == $profil->id) ? 'selected' : '' }} value="{{ $profil->id }}">{{ $profil->libelle_complet() }}</option>
													@endforeach
												</select>
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
				</div>
			</div>
		</div>
	</div>
	<!--End::Dashboard 1-->
</div>
<!--End::Section-->
@endsection
