@extends('layout.default')

@section('content')
<!-- begin:: Content Head -->
<div class="kt-subheader   kt-grid__item" id="kt_subheader">
	<div class="kt-subheader__main">
		<h3 class="kt-subheader__title">Nouveau chantier</h3>
		<span class="kt-subheader__separator kt-subheader__separator--v"></span>
		<a href="/chantier/sent" class="btn btn-label-warning btn-bold btn-sm btn-icon-h kt-margin-l-10">
			Liste des chantiers
		</a>
	</div>
	<div class="kt-subheader__toolbar">
		
	</div>
</div>

<!-- end:: Content Head -->

<!-- begin:: Content -->
<div class="card card-custom">
	@if($message == "ITEM_EXISTS")
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
	
	@if($message == "DATE_ERROR")
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
	
	<!--Begin::Section-->
	<div class="row">
		<div class="col-md-7">

			<!--begin:: Widgets/New Users-->
			<div class="card card-custom">
				<div class="card-body">
					<!--begin::Form-->
					<form class="kt-form" method="POST" action="/chantier/savevirtuel">
						<input type="hidden" name="mandataireID" id="mandataireID" value="0" />
						{{ csrf_field() }}
						<div class="card-body">
							<div class="kt-section kt-section--first">
								<div class="form-group">
									<label>Numéro : *</label>
									<input type="text" name="numero" required class="form-control" value="{{ $infos['numero'] }}" placeholder="Numéro">
								</div>
								
								<div class="form-group">
									<label>Raison Sociale : *</label>
									<input class="form-control tt-input" required onkeyup="rechercherPrestataire(this.value)" type="text" name="raisonSociale" id="saRaisonSociale" placeholder="ex : SARL Presta" autocomplete="off";">
								</div>
								
								<div class="form-group">
									<label>Numéro SIRET : *</label>
									<input class="form-control tt-input" required onkeyup="rechercherPrestataire(this.value)" type="text" name="noSiret" id="sonNoSiret" placeholder="ex : SARL Presta" autocomplete="off">
								</div>
								
								<div class="form-group">
									<label>Email dirigeant : *</label>
									<input class="form-control tt-input" required type="email" name="emailDirigeant" id="emailDirigeant" placeholder="ex : dirigeant@exmemple.com" autocomplete="off" spellcheck="false">
								</div>
								
								<div class="form-group">
									<label>Autre email : </label>
									<input class="form-control tt-input" type="email" name="autreEmail" id="autreEmail" placeholder="ex : autre@exmemple.com" autocomplete="off" spellcheck="false">
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
		
		<div class="col-md-5">

				<!--begin:: Widgets/Last Updates-->
				<div class="kt-portlet kt-portlet--height-fluid">
					<div class="card-header">
						<div class="card-title">
							<h3>
								Zone de recherche
							</h3>
						</div>
					</div>
					<div class="kt-portlet__body" id="les_presta">
						
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