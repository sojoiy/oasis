@extends('layout.default')

@section('content')
<!-- begin:: Content Head -->
<div class="kt-subheader   kt-grid__item" id="kt_subheader">
	<div class="kt-subheader__main">
		<h3 class="kt-subheader__title">Ajouter un véhicule</h3>
		<span class="kt-subheader__separator kt-subheader__separator--v"></span>
		<span class="kt-subheader__desc">{{ $user->name }}</span>
		<a href="/vehicules" class="btn btn-label-warning btn-bold btn-sm btn-icon-h kt-margin-l-10">
			Liste des véhicules
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
							Ajouter un véhicule
						</h3>
					</div>
				</div>
				<div class="card-body">
					<!--begin::Form-->
					<form class="kt-form" method="POST" action="/vehicule/save">
						{{ csrf_field() }}
						<div class="card-body">
							<div class="kt-section kt-section--first">
								<div class="form-group">
									<label>Immatriculation : *</label>
									<input type="text" name="immatriculation" required class="form-control" placeholder="AM198RS">
								</div>
								<div class="form-group">
									<label>Type de véhicule :</label>
									<select class="form-control" name="type_vehicule">
										<option value="camionnette">Camionnette < 3.5t</option>
										<option value="navette">Navette</option>
										<option value="pl">PL</option>
										<option value="vl">VL Commerciale 2pl</option>
									</select>
								</div>
								<div class="form-group">
									<label>Marque :</label>
									<input type="text" name="marque" required class="form-control" placeholder="Marque">
								</div>
								<div class="form-group">
									<label>Modèle :</label>
									<input type="text" name="modele" required class="form-control" placeholder="Modèle">
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
