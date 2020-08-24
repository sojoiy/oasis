@extends('layout.default')

@section('specificss')
	<link href="{{ asset('assets/vendors/general/bootstrap-timepicker/css/bootstrap-timepicker.css') }}" rel="stylesheet" type="text/css">
@endsection

@section('content')
<!-- begin:: Content Head -->
<div class="kt-subheader   kt-grid__item" id="kt_subheader">
	<div class="kt-subheader__main">
		<h3 class="kt-subheader__title">Informations générales</h3>
		<span class="kt-subheader__separator kt-subheader__separator--v"></span>
		<a href="/admin/chantiers/{{ $societe->id }}" class="btn btn-label-brand btn-bold btn-sm btn-icon-h kt-margin-l-5">
			<i class="fa fa-wrench"></i> Les chantiers</a>
		
		<a href="/admin/intervenants/{{$societe->id}}" class="btn btn-label-primary btn-bold btn-sm btn-icon-h kt-margin-l-5">
			<i class="fa fa-users"></i> Intervenants
		</a>
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
	
			<div class="col-md-6" id="zone_statut">
				<!--end:: Widgets/Download Files-->
				@include('admin.statut', ['societe' => $societe])
			</div>
		</div>
	</form>
	
	
	<!--End::Section-->
</div>
@endsection

@section('specifijs')
	<script src="{{ asset('assets/js/admin.js') }}" type="text/javascript"></script>
@endsection