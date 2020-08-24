@extends('layout.default')

@section('content')
<!-- begin:: Content Head -->
<div class="kt-subheader   kt-grid__item" id="kt_subheader">
	<div class="kt-subheader__main">
		<h3 class="kt-subheader__title">Fiche intervenant</h3>
		<span class="kt-subheader__separator kt-subheader__separator--v"></span>
		<span class="kt-subheader__desc">{{ $user->nomSociete() }}</span>
	</div>
	<div class="kt-subheader__toolbar">
		
	</div>
</div>

<!-- end:: Content Head -->

<!-- begin:: Content -->
<div class="card card-custom">
	<!--begin::Modal-->
	
	
	<!--end::Modal-->
	
	<!--Begin::Section-->
	<div class="row">
		<div class="col-md-4">
			<!--begin:: Widgets/New Users-->
			<div class="card card-custom">
				<div class="card-header">
					<div class="card-title">
						<h3>
							{{ $entite->name }}
						</h3>
					</div>
				</div>
				<div class="card-body">
					<!--begin::Form-->
					<div class="form-group">
						<label>ID : {{ $entite->id }}</label><br>
						<label>Nom : {{ $entite->nom }}</label><br>
						<label>Prénom : {{ $entite->prenom }}</label><br>
						<label>Date de naissance : {{ date("d/m/Y", strtotime($entite->date_naissance)) }}</label><br>
						<label>Fonction : {{ $entite->fonction }}</label><br>
						<label>Lieu de naissance : {{ $entite->lieu_naissance }}</label><br>
						<label>Adresse : {{ $entite->adresse }}</label><br>
						<label>Téléphone : {{ $entite->telephone }}</label><br>
						<label>Nationalité : {{ $entite->nationalite() }}</label><br>
						<label>Profil : {{ $entite->profil() }}</label><br>
						<label>Date embauche : </label><br>
						<label>Habilitations :  {{ $entite->habilitations() }}</label><br>
						<label>Employeur :  {{ $entite->societe() }}</label><br>
						<label>Nationalité Employeur :  {{ $entite->pays_societe() }}</label><br>
						<label>Téléphone Employeur :  {{ $entite->telephone_societe() }}</label><br>
					</div>
				</div>
			</div>

			<!--end:: Widgets/New Users-->
		</div>
		
		<div class="col-md-8" id="zone_decisive">
			@include('chantiers.zonedecision', ['user' => $user, 'piece' => $piece])
		</div>
	</div>
	
	<!--End::Section-->
	<div class="row">
		<div class="col-md-12">
			<!--begin:: Widgets/New Users-->
			
			@if($extension == 'pdf')
			<div class="card-body">
				<iframe src = "/temp/ViewerJS/#../{{ md5($key) }}.pdf" width='100%' height='600' allowfullscreen webkitallowfullscreen></iframe>
			</div>
			@else
			<div class="card-body">
				<img src="/temp/{{ md5($key) }}.{{ $extension }}" width="75%" style="text-align:center;" >
			</div>
			@endif
		</div>
	</div>
</div>
@endsection

@section('specifijs')
	<script src="{{ asset('assets/js/chantier.js') }}" type="text/javascript"></script>
@endsection