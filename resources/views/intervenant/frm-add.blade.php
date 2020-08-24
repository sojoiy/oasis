@extends('layout.default')

@section('content')
<!-- begin:: Content Head -->
<!-- begin:: Content -->
	<div class="row">
		<div class="col-lg-8">
			<div class="card card-custom">
				<div class="card-header flex-wrap border-0 pt-6 pb-0">
					<div class="card-title">
						<h3 class="card-label">Ajouter un intervenant</h3>
					</div>
				</div> 
				
				<div class="card-body">
					<!--begin::Form-->
					<form class="kt-form" method="POST" action="/intervenant/save">
						{{ csrf_field() }}
						<div class="card-body">
							<div class="kt-section kt-section--first">
								<div class="form-group row">
									<label class="col-lg-2 col-form-label">Nom : *</label>
									<div class="col-lg-6">
										<input type="text" name="nom" id="nom" onchange="verifierIntervenant(this.value, $('#prenom').val(), $('#example-date-input').val());" required class="form-control" placeholder="Nom">
									</div>
								</div>
								<div class="form-group row">
									<label class="col-lg-2 col-form-label">Prénom : *</label>
									<div class="col-lg-6">
										<input type="text" name="prenom" id="prenom" onchange="verifierIntervenant($('#nom').val(), this.value, $('#example-date-input').val());" required class="form-control" placeholder="Prénom">
									</div>
								</div>
								
								<div class="form-group row">
									<label class="col-lg-2 col-form-label">Date de naissance : </label>
									<div class="col-lg-6">
										<input class="form-control" onchange="verifierIntervenant($('#nom').val(), $('#prenom').val(), this.value);" type="date" name="date_naissance" value="" id="example-date-input">
									</div>
								</div>
								
								<div class="form-group row">
									<label class="col-lg-2 col-form-label">Fonction :</label>
									<div class="col-lg-6">
										<input type="text" name="fonction" class="form-control" placeholder="Fonction">
									</div>
								</div>
								
								<div class="form-group row">
									<label class="col-lg-2 col-form-label">Lieu de naissance :</label>
									<div class="col-lg-6">
										<input type="text" name="lieu_naissance" class="form-control" placeholder="ex : Paris">
									</div>
								</div>

								<div class="form-group row">
									<label class="col-lg-2 col-form-label">Adresse :</label>
									<div class="col-lg-6">
										<input type="text" name="adresse" class="form-control" placeholder="">
									</div>
								</div>

								<div class="form-group row">
									<label class="col-lg-2 col-form-label">Téléphone :</label>
									<div class="col-lg-6">
										<input type="text" name="telephone" class="form-control" placeholder="">
									</div>
								</div>

								<div class="form-group row">
									<label class="col-lg-2 col-form-label">Nationalité :</label>
									<div class="col-lg-6">
										<select name="nationalite" class="form-control selectpicker">
											@foreach($lesPays as $pays)
												<option value="{{ $pays->id }}" {{ $pays->id == 81 ? 'selected' : ''}}>{{ $pays->libelle }}</option>
											@endforeach
										</select>
									</div>
								</div>
								
								<div class="form-group row">
									<label class="col-lg-2 col-form-label">Date d'embauche : </label>
									<div class="col-lg-6">
										<input class="form-control" type="date" name="date_embauche" value="" >
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