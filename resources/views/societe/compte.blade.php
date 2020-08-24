@extends('layout.default')

@section('specificss')
	<link href="{{ asset('assets/vendors/general/bootstrap-timepicker/css/bootstrap-timepicker.css') }}" rel="stylesheet" type="text/css">
@endsection

@section('content')

@include('societe.head', ['active' => 'Utilisateurs'])

<!-- begin:: Content -->
<div class="card card-custom">
	<div id="activite"></div>
	
	<!--Begin::Section-->
	<div class="row">
		<div class="col-md-12">
			<!--begin:: Widgets/New Users-->
			<div class="card card-custom">
				<div class="card-body">
					<form method="post" action="/societe/modifiercompte">
						<input type="hidden" name="id" value="{{ $compte->id }}" />
						{{ csrf_field() }}
						<div class="tab-content">
							<div class="tab-pane active" id="kt_tabs_7_1" role="tabpanel">
								<div class="form-group row">
									<label class="col-xl-3 col-lg-3 col-form-label">Nom *</label>
									<div class="col-lg-6 col-xl-6">
										<input type="text" name="nom" required class="form-control" value="{{ $compte->nom }}" placeholder="Nom">
									</div>
								</div>
								
								<div class="form-group row">
									<label class="col-xl-3 col-lg-3 col-form-label">Prénom *</label>
									<div class="col-lg-6 col-xl-6">
										<input type="text" name="prenom" required value="{{ $compte->prenom }}" class="form-control" placeholder="Prénom">
									</div>
								</div>
								
								<div class="form-group row">
									<label class="col-xl-3 col-lg-3 col-form-label">Email *</label>
									<div class="col-lg-6 col-xl-6">
										<input type="email" name="email" value="{{ $compte->email }}" required class="form-control" placeholder="Email">
									</div>
								</div>
								
								<div class="form-group row">
									<label class="col-xl-3 col-lg-3 col-form-label">Téléphone</label>
									<div class="col-lg-6 col-xl-6">
										<input type="text" name="telephone" value="{{ $compte->telephone }}" class="form-control" placeholder="Téléphone">
									</div>
								</div>
								
								<div class="form-group row">
									<label class="col-xl-3 col-lg-3 col-form-label">Fonction</label>
									<div class="col-lg-6 col-xl-6">
										<input type="text" name="telephone" value="{{ $compte->fonction }}" class="form-control" placeholder="Téléphone">
									</div>
								</div>
								<br>
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

@section('specifijs')
	<script src="{{ asset('assets/js/societe.js') }}" type="text/javascript"></script>
	<script src="{{ asset('assets/js/demo1/pages/crud/forms/widgets/input-mask.js') }}" type="text/javascript"></script>
@endsection