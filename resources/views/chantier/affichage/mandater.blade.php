@extends('layout.default')

@section('content')

	<!--Begin::Section-->
	<div class="row">
		<div class="col-md-5">
			
			<div class="card card-custom" id="viewer">
				<div class="card-header">
					<div class="card-title">
						<h3>Mandater un prestataire</h3>
					</div>
				</div>
				<div class="card-body">
					<form class="kt-form" method="POST" action="/chantier/creermandat">
						{{ csrf_field() }}
						<input type="hidden" name="chantierID" value="{{ $chantier->id }}" />
						<input type="hidden" name="mandataireID" id="mandataireID" value="0" />
						<input type="hidden" name="societeID" value="{{ $user->societeID }}" />
						<div class="card-body">
							<div class="kt-section kt-section--first">
								<div class="form-group">
									<label>Raison Sociale : *</label>
									<input class="form-control tt-input" name="rs" required onkeyup="rechercherPrestataire(this.value)" type="text" dir="ltr" id="saRaisonSociale" placeholder="ex : SARL Presta" autocomplete="off" spellcheck="false" style="position: relative; vertical-align: top; background-color: transparent;">
								</div>
								
								<div class="form-group">
									<label>Numéro SIRET : *</label>
									<input class="form-control" required name="siret" onkeyup="rechercherPrestataire(this.value)" type="text" id="sonNoSiret" placeholder="ex : 000111222 00000" autocomplete="off">
								</div>
								
								<div class="form-group">
									<label>Agence Intérim</label>
									<div class="kt-radio-inline">
										<label class="kt-radio">
											<input type="radio" name="agence_interim"> Oui
											<span></span>
										</label>
										<label class="kt-radio">
											<input type="radio" name="agence_interim" checked> Non
											<span></span>
										</label>
									</div>
									<span class="form-text text-muted">Indiquez si le prestataire est une agence intérim</span>
								</div>
								
								<div class="form-group">
									<label>Email dirigeant : *</label>
									<input class="form-control tt-input" type="email" name="email" required id="emailDirigeant" placeholder="ex : dirigeant@exmemple.com" autocomplete="off" spellcheck="false" style="position: relative; vertical-align: top; background-color: transparent;">
								</div>
								
								<div class="form-group">
									<label>Autre email : </label>
									<input class="form-control tt-input" type="email" name="autre_email" id="autreEmail" placeholder="ex : autre@exmemple.com" autocomplete="off" spellcheck="false" style="position: relative; vertical-align: top; background-color: transparent;">
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
		
		<div class="col-md-7">
			<div class="card card-custom" id="viewer">
				<div class="card-header">
					<div class="card-title">
						<h3>Les prestataires</h3>
					</div>
				</div>
				<div class="card-body" id="les_presta">
				</div>
			</div>
		</div>
	</div>
@endsection

@section('specifijs')
	<script src="{{ asset('assets/js/chantier.js') }}" type="text/javascript"></script>
	<script src="{{ asset('assets/js/demo1/pages/crud/forms/widgets/input-mask.js') }}" type="text/javascript"></script>
@endsection