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
						<label>Nom : {{ $entite->nom }}</label><br>
						<label>Prénom : {{ $entite->prenom }}</label><br>
						<label>Date de naissance : {{ date("d/m/Y", strtotime($entite->date_debut)) }}</label><br>
						<label>Fonction : {{ $entite->fonction }}</label><br>
						<label>Lieu de naissance : </label><br>
						<label>Adresse : </label><br>
						<label>Code postal : </label><br>
						<label>Ville : </label><br>
						<label>Nationalité : </label><br>
						<label>Employeur : </label><br>
						<label>Date embauche : </label>
					</div>
				</div>
			</div>

			<!--end:: Widgets/New Users-->
		</div>
		
		<div class="col-md-8">
			<div class="kt-portlet">
				<div class="card-header">
					<div class="card-title">
						<h3>
							Validation
						</h3>
					</div>
				</div>

				<!--begin::Form-->
				<form class="kt-form kt-form--label-right" id="decision-piece" method="POST">
					<input type="hidden" name="id" value="{{ $piece->id }}" />
					<input type="hidden" name="etat" value="valide" />
					{{ csrf_field() }}
					<div class="card-body">
						<div class="form-group row">
							<label class="col-form-label col-lg-3 col-sm-12">Document</label>
							<div class="col-lg-8 col-md-9 col-sm-12">
								<input class="form-control" type="text" disabled name="document" value="{{ $piece->type_piece() }}" >
							</div>
						</div>
						
						<div class="form-group row">
							<label class="col-form-label col-lg-3 col-sm-12">Date expiration</label>
							<div class=" col-lg-8 col-md-9 col-sm-12">
								<input class="form-control" type="date" name="date_expiration" value="{{ $piece->date_expiration }}" id="example-date-input">
							</div>
						</div>
						
						<div class="form-group row">
							<label class="col-form-label col-lg-3 col-sm-12">Commentaire</label>
							<div class="col-lg-8 col-md-9 col-sm-12">
								<textarea name="commentaire" id="commentaire" rows="5" class="form-control">{{ $piece->commentaire }}</textarea>
								<div style="margin-top:5px;">
									<button class="btn btn-default btn-sm" type="button" onclick="$('#commentaire').append('Pièce illisible ')">Pièce illisible</button>
									<button class="btn btn-default btn-sm" type="button" onclick="$('#commentaire').append('Pièce périmée ')">Pièce périmée</button>
									<button class="btn btn-default btn-sm" type="button" onclick="$('#commentaire').append('Autre motif ')">Autre motif</button>
								</div>
							</div>
						</div>
					</div>
					<div class="card-footer d-flex justify-content-between">
						<div class="kt-form__actions">
							<div class="row">
								<div class="col-lg-9 ml-lg-auto">
									<button type="button" onclick="accepterPiece('valide');" class="btn btn-success">Valider</button>
									<button type="button" onclick="accepterPiece('refus');" class="btn btn-danger">Refuser</button>
									<a href="/chantier/pieces" class="btn btn-secondary">Retour</a>
								</div>
							</div>
						</div>
					</div>
				</form>

				<!--end::Form-->
			</div>
		</div>
	</div>
	
	<!--End::Section-->
	<div class="row">
		<div class="col-md-12">
			<!--begin:: Widgets/New Users-->
			
			@if($extension == 'pdf')
			<div class="card-body">
				<iframe src = "/assets/ViewerJS/#../{{ $file }}" width='100%' height='600' allowfullscreen webkitallowfullscreen></iframe>
			</div>
			@else
			<div class="card-body">
				<img src="{{ $file }}" >
			</div>
			@endif
		</div>
	</div>
</div>
@endsection

@section('specifijs')
	<script src="{{ asset('assets/js/chantier.js') }}" type="text/javascript"></script>
@endsection