@extends('layouts.visitor')

@section('content')

@include('chantier.head_do', ['active' => 'Informations', 'guest' => true])

<!-- begin:: Content -->
@include('chantier.modal_prorogation', ['chantier' => $chantier])					
					
<div class="card card-custom">
	
	<!--Begin::Section-->
	<div class="row">
		<div class="col-md-4">

			<!--begin:: Widgets/New Users-->
			<div class="card card-custom">
				<div class="card-header">
					<div class="card-title">
						<h3>
							Chantier : {{ $chantier->numero }}
						</h3>
					</div>
				</div>
				<div class="card-body">
					<!--begin::Form-->
					<div class="form-group">
						<label>Type de dossier : {{ $chantier->type_chantier() }}</label><br>
						<label>Numéro : {{ $chantier->numero }}</label><br>
						<label>Date de début : {{ date('d/m/Y', strtotime($chantier->date_debut)) }}</label><br>
						<label>Date de fin : {{ date('d/m/Y', strtotime($chantier->date_fin)) }}</label>
					</div>
				</div>
			</div>

			<!--end:: Widgets/New Users-->
		</div>
		
		<div class="col-md-8">

			<!--begin:: Widgets/New Users-->
			<div class="card card-custom">
				<div class="card-header">
					<div class="card-title">
						<h3>
							Mémo
						</h3>
					</div>
				</div>
				<div class="card-body">
					<!--begin::Form-->
					<div class="form-group">
						<p>{{ $chantier->memo }}</p>
					</div>
				</div>
			</div>

			<!--end:: Widgets/New Users-->
		</div>
	</div>

	<!--End::Section-->
</div>
@endsection

@section('specifijs')
	<script src="{{ asset('assets/js/chantier.js') }}" type="text/javascript"></script>
@endsection