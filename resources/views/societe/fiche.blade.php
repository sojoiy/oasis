@extends('layout.default')

@section('specificss')
	<link href="{{ asset('assets/vendors/general/bootstrap-timepicker/css/bootstrap-timepicker.css') }}" rel="stylesheet" type="text/css">
@endsection

@section('content')
<!-- begin:: Content Head -->
<div class="kt-subheader   kt-grid__item" id="kt_subheader">
	<div class="kt-subheader__main">
		<h3 class="kt-subheader__title">Profil général</h3>
		<span class="kt-subheader__separator kt-subheader__separator--v"></span>
	</div>
	<div class="kt-subheader__toolbar">
		
	</div>
</div>

<!-- end:: Content Head -->

<!-- begin:: Content -->
<div class="card card-custom">
	<!--Begin::Section-->
	<!--begin::Form-->
	<form class="kt-form" method="POST" action="/societe/change">
		<input type="hidden" name="id" value="{{ $societe->id }}" />
		{{ csrf_field() }}
		<div class="row">
			<div class="col-md-6">
				<!--begin:: Widgets/New Users-->
				<div class="card card-custom">
					<div class="card-header">
						<div class="card-title">
							<h3>
								{{ $societe->raisonSociale }}
							</h3>
						</div>
					</div>
					<div class="card-body">
						<div class="card-body">
							<div class="kt-section kt-section--first">
								<div class="form-group">
									<label>Raison sociale : {{ $societe->raisonSociale }}</label><br>
									<label>Nature juridique : {{ $societe->natureJuridique }}</label><br>
									<label>Numéro TVA : {{ $societe->numeroTva }}</label>
								</div>
								<div class="kt-separator kt-separator--border-dashed kt-separator--space-lg"></div>
								<div class="form-group">
									<label>Nom directeur : {{ $societe->nomDirecteur }}</label><br>
									<label>Prénom directeur : {{ $societe->prenomDirecteur }}</label><br>
									<label>Fonction : {{ $societe->fonctionDirecteur }}</label><br>
									<label>Responsable sécurité : {{ $societe->responsableSecurite }}</label><br>
									<label>CHSCT : {{ $societe->chsct }}</label><br>
									<label>Médecin du Travail : {{ $societe->medecinDuTravail }}</label>
								</div>
							</div>
						</div>
					</div>
				</div>

				<!--end:: Widgets/New Users-->
			</div>
	
			<div class="col-md-6">
				<!--end:: Widgets/Download Files-->
		
				<div class="kt-portlet">
					<div class="card-header">
						<div class="card-title">
							<h3>
								Compte 
							</h3>
						</div>
					</div>

					<!--begin::Form-->
					<div class="card-body">
						<div class="kt-section kt-section--first">
							<div class="form-group">
								<label>Identifiant : *</label>
								<input type="email" name="email" value="{{ $societe->email }}" required class="form-control" placeholder="Login">
							</div>
							<div class="form-group">
								<label>Réinitialiser le mot de passe : *</label>
								<input type="text" name="password" value="" class="form-control" placeholder="Saisissez un nouveau mot de passe">
							</div>
							<div class="form-group">
								<label>Statut</label>
								<div class="kt-checkbox-inline">
									<label class="kt-checkbox">
										<input type="checkbox"> Validé
										<span></span>
									</label>
									<label class="kt-checkbox">
										<input type="checkbox"> En attente
										<span></span>
									</label>
									<label class="kt-checkbox">
										<input type="checkbox"> Bloqué
										<span></span>
									</label>
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
					<!--end::Form-->
				</div>
			</div>
		</div>
	</form>
	
	
	<!--End::Section-->
</div>
@endsection

@section('specifijs')
	<script src="{{ asset('assets/js/societe.js') }}" type="text/javascript"></script>
	<script src="{{ asset('assets/js/demo1/pages/crud/forms/widgets/input-mask.js') }}" type="text/javascript"></script>
@endsection