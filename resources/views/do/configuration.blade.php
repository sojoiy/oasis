@extends('layout.default')

@section('content')

<!-- end:: Content Head -->

<!-- begin:: Content -->

								
	<!--Begin::Section-->
				<div class="card card-custom">
					<!--begin::Form-->
					<form class="kt-form" method="POST" action="/comptes/saveconfiguration">
						{{ csrf_field() }}
						<div class="card-body">
							<div class="kt-section kt-section--first">
								<div class="form-group row">
									<label class="col-4  col-form-label">Activer les rendez-vous :</label>
									<div class="col-3">
										<span class="kt-switch">
											<label>
												<input type="checkbox" {{ $societe->rdv_active ? 'checked' : '' }} name="rdv_active" />
												<span></span>
											</label>
										</span>
									</div>
								</div>
								
								<div class="form-group form-group-last">
									<div class="alert alert-secondary" role="alert">
										<div class="alert-icon"><i class="fa fa-clock"></i></div>
										<div class="alert-text">
											Durées de validité suite à une validation (exprimées en mois)
										</div>
									</div>
								</div>
								
								<div class="form-group row">
									<label class="col-4  col-form-label">Durée de validation de la "VG" :</label>
									<div class="col-3">
										<input type="number" name="validite_global" required class="form-control" value="{{ $societe->validite_global }}" />
									</div>
								</div>
								
								<div class="form-group row">
									<label class="col-4  col-form-label">Renouvellement de la "VG" :</label>
									<div class="col-8 ion-range-slider">
										<input type="hidden" name="delai_vg" id="kt_slider_1" value="{{ $societe->delai_vg }}" /> jour(s) avant expiration
									</div>
								</div>
								
								<div class="form-group row">
									<label class="col-4  col-form-label">Durée d'invalidation de la "VG" : <i data-container="body" data-toggle="kt-popover" data-placement="bottom" data-content="Définit la durée pendant laquelle une nouvelle présentation de l'intervenant est interdite" class="fa fa-info-circle"></i></label>
									<div class="col-3">
										<input type="number" name="invalidite_global" required class="form-control" value="{{ $societe->invalidite_global }}" />
										
									</div>
								</div>
								
								<div class="form-group row">
									<label class="col-4  col-form-label">Autorisations chantier :</label>
									<div class="col-3">
										<input type="text" name="validite_chantier" required class="form-control" value="{{ $societe->validite_chantier }}" />
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
					</form>
				</div>
	
<!--End::Section-->
@endsection

@section('specifijs')
	<script src="{{ asset('assets/js/pages/crud/forms/widgets/ion-range-slider.js?v=7.0.4') }}" type="text/javascript"></script>
@endsection
