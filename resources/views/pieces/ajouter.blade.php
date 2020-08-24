@extends('layout.default')

@section('content')
<!-- begin:: Content Head -->
<div class="kt-subheader   kt-grid__item" id="kt_subheader">
	<div class="kt-subheader__main">
		<h3 class="kt-subheader__title">Ajouter un type</h3>
		<span class="kt-subheader__separator kt-subheader__separator--v"></span>
		<a href="/parametres/pieces" class="btn btn-label-warning btn-bold btn-sm btn-icon-h kt-margin-l-10">
			Liste des types de pièces
		</a>
	</div>
	<div class="kt-subheader__toolbar">
		
	</div>
</div>

<!-- end:: Content Head -->

<!-- begin:: Content -->
<div class="card card-custom">
	<!--Begin::Section-->
	<div class="row">
		<div class="col-xl-12">

			<!--begin:: Widgets/New Users-->
			<div class="card card-custom">
				<div class="card-header">
					<div class="card-title">
						<h3>
							Ajouter un type de pièces
						</h3>
					</div>
				</div>
				<div class="card-body">
					<!--begin::Form-->
					<form class="kt-form" method="POST" action="/parametres/savepieces">
						<input type="hidden" name="id" value="0" />
						{{ csrf_field() }}
						<div class="card-body">
							<div class="kt-section kt-section--first">
								<div class="form-group row">
									<label class="col-3 col-form-label">Libellé : *</label>
									<div class="col-3">
										<input type="text" name="libelle" required class="form-control" value="{{ $typePiece->libelle }}" placeholder="Libellé">
									</div>
								</div>
								<div class="form-group row">
									<label class="col-3 col-form-label">Abbréviation : *</label>
									<div class="col-3">
										<input type="text" name="abbreviation" required class="form-control" value="{{ $typePiece->abbreviation }}" placeholder="Abbréviation">
									</div>
								</div>
								<div class="form-group row">
									<label class="col-3 col-form-label">Intervenant :</label>
									<div class="col-3">
										<span class="kt-switch">
											<label>
												<input type="checkbox" {{ $typePiece->intervenant ? 'checked' : '' }} name="intervenant" />
												<span></span>
											</label>
										</span>
									</div>
								</div>
								<div class="form-group row">
									<label class="col-3 col-form-label">Véhicule :</label>
									<div class="col-3">
										<span class="kt-switch">
											<label>
												<input type="checkbox" {{ $typePiece->vehicule ? 'checked' : '' }} name="vehicule" />
												<span></span>
											</label>
										</span>
									</div>
								</div>
								<div class="form-group row">
									<label class="col-3 col-form-label">Chantier :</label>
									<div class="col-3">
										<span class="kt-switch">
											<label>
												<input type="checkbox" {{ $typePiece->chantier ? 'checked' : '' }} name="chantier" />
												<span></span>
											</label>
										</span>
									</div>
								</div>
								<div class="form-group row">
									<label class="col-3 col-form-label">Intérimaire :</label>
									<div class="col-3">
										<span class="kt-switch">
											<label>
												<input type="checkbox" {{ $typePiece->interim ? 'checked' : '' }} name="interim" />
												<span></span>
											</label>
										</span>
									</div>
								</div>
								<div class="form-group row">
									<label class="col-3 col-form-label">Travailleur détaché :</label>
									<div class="col-3">
										<span class="kt-switch">
											<label>
												<input type="checkbox" {{ $typePiece->etranger ? 'checked' : '' }} name="etranger" />
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
					</form>
				</div>
			</div>

			<!--end:: Widgets/New Users-->
		</div>
	</div>

	<!--End::Section-->
</div>
@endsection
