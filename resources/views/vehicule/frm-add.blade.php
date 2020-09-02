@extends('layout.default')

@section('content')
<!-- begin:: Content Head -->
<!-- begin:: Content -->
<div class="row">
		<div class="col-lg-8">
			<div class="card card-custom">
				<div class="card-header flex-wrap border-0 pt-6 pb-0">
					<div class="card-title">
						<h3 class="card-label">Ajouter un vehicule</h3>
					</div>
				</div> 
				
				<div class="card-body">
					<!--begin::Form-->
					<form class="kt-form" method="POST" action="/vehicule/save">
						{{ csrf_field() }}
						<div class="card-body">
							<div class="kt-section kt-section--first">
								<div class="form-group row">
									<label class="col-lg-2 col-form-label">Immatriculation : *</label>
									<div class="col-lg-6">
										<input type="text" name="immatriculation" id="immatriculation" onchange="verifierVehicule(this.value, $('#immatriculation').val());"
										 required class="form-control" placeholder="Immatriculation">
									</div>
								</div>
								<div class="form-group row">
									<label class="col-lg-2 col-form-label">Type de vehicule : *</label>
									<div class="col-lg-6">
										<input type="text" name="type_vehicule" id="type_vehicule"  required class="form-control" placeholder="Type de vehicule">
									</div>
								</div>
								<div class="form-group row">
									<label class="col-lg-2 col-form-label">Marque :</label>
									<div class="col-lg-6">
										<input type="text" name="marque" class="form-control" placeholder="Marque">
									</div>
								</div>
								
								<div class="form-group row">
									<label class="col-lg-2 col-form-label">Modèle :</label>
									<div class="col-lg-6">
										<input type="text" name="modele" class="form-control" placeholder="Modèle">
									</div>
								</div>
								
								<div class="form-group row" id="resultatRecherche">
									
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
@endsection

@section('specifijs')
	<script src="{{ asset('assets/js/entite.js') }}" type="text/javascript"></script>
@endsection
