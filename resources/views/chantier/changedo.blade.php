@extends('layout.default')

@section('content')

@include('chantier.head_do', ['active' => 'Informations'])

<!-- begin:: Content -->
@include('chantier.modal_prorogation', ['chantier' => $chantier])					
					
<div class="card card-custom">
	@if($message != "EMPTY" && $message != "PROROGATION_OK")
		<div class="alert alert-warning fade show" role="alert">
			<div class="alert-icon"><i class="fa fa-exclamation-triangle"></i></div>
			<div class="alert-text">{{ $message }}</div>
			<div class="alert-close">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true"><i class="fa fa-times"></i></span>
				</button>
			</div>
		</div>
	@endif
	
	@if($message == "PROROGATION_OK")
		<div class="alert alert-success fade show" role="alert">
			<div class="alert-icon"><i class="fa fa-exclamation-triangle"></i></div>
			<div class="alert-text">Le chantier été prorogé</div>
			<div class="alert-close">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true"><i class="fa fa-times"></i></span>
				</button>
			</div>
		</div>
	@endif
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
					<div class="kt-separator kt-separator--border-dashed kt-separator--space-lg"></div>
					<div class="form-group" id="info_cloture">
						<button type="button" onclick="cloturer({{ $chantier->id }})" data-dismiss="modal" class="btn btn-danger"><i class="fa fa-times-circle"></i> Fermer ce chantier</button>
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
						@if($chantier->do == $user->societeID)
							<textarea name="memo" id="memo" rows="5" onkeyup="$('#save_memo').show();" class="form-control">{{ $chantier->memo }}</textarea>
						@else
							<p>{{ $chantier->memo }}</p>
						@endif
						<br><button type="button" onclick="saveMemo({{ $chantier->id }})" id="save_memo" class="btn btn-info btn-sm" style="display:none;"><i class="fa fa-save"></i> Enregistrer</button>
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