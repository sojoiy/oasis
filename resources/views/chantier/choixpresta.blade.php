@extends('layout.default')

@section('content')

@include('chantier.head', ['active' => 'Titulaires'])

<!-- begin:: Content -->
@include('chantier.modal_prorogation', ['chantier' => $chantier])

<div class="card card-custom">
	@if(!$chantier->societe)
		<div id="zone_notify">
			<div class="alert alert-warning alert-elevate fade show" role="alert">
				<div class="alert-icon"><i class="fa fa-trash"></i></div>
				<div class="alert-text">
					S'il s'agit d'une erreur vous pouvez supprimer ce chantier en cliquant ce bouton <button class="btn btn-danger" onclick="cloturer({{ $chantier->id }})">Supprimer le dossier</button>
				</div>
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
							Choisir un prestataire
						</h3>
					</div>
				</div>
				<div class="card-body">
					<!--begin::Form-->
					<form class="kt-form" method="POST" id="ajouterpresta" action="#">
						{{ csrf_field() }}
						<input type="hidden" name="chantierID" id="chantierID" value="{{ $chantier->id }}" />
						<input type="hidden" name="mandataireID" id="mandataireID" value="0" />
						<div class="card-body">
							<div class="kt-section kt-section--first">
								<div class="form-group">
									<label>Raison Sociale : *</label>
									<input class="form-control tt-input" required onkeyup="rechercherPrestataire(this.value)" type="text" name="raisonSociale" id="saRaisonSociale" placeholder="ex : SARL Presta" autocomplete="off";">
								</div>
								
								<div class="form-group">
									<label>Numéro SIRET : *</label>
									<input class="form-control tt-input" required onkeyup="rechercherPrestataire(this.value)" type="text" name="noSiret" id="sonNoSiret" placeholder="ex : SARL Presta" autocomplete="off">
								</div>
								
								<div class="form-group">
									<label>Titulaire principal</label>
									<div class="kt-radio-inline">
										<label class="kt-radio">
											<input type="radio" checked name="titulaire" value="1"> Oui
											<span></span>
										</label>
										<label class="kt-radio">
											<input type="radio" name="titulaire" value="0"> Non
											<span></span>
										</label>
									</div>
									<span class="form-text text-muted">Indiquez si le prestataire sera le prestataire de référence sur le chantier</span>
								</div>
								
								<div class="form-group" id="ligne_interim">
									<label>Agence intérim</label>
									<div class="kt-radio-inline">
										<label class="kt-radio">
											<input type="radio" name="interim" value="1"> Oui
											<span></span>
										</label>
										<label class="kt-radio">
											<input type="radio" checked name="interim" value="0"> Non
											<span></span>
										</label>
									</div>
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
								<button type="submit" class="btn btn-primary">Ajouter</button>
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
		
		@foreach($titulaires as $titulaire)
		<div class="modal fade" id="kt_modal_{{ $titulaire->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
					<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLongTitle">{{ $titulaire->raisonSociale() }}</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						</button>
					</div>
					<div class="modal-body">
						<p>N°SIRET : {{ $titulaire->noSiret() }}</p>
						<p>Adresse : {{ $titulaire->adresse() }}</p>
						<p>Téléphone : {{ $titulaire->telephone() }}</p>
						<p>Email dirigeant : {{ $titulaire->emailDirigeant() }}</p>
						<p>Autre Email : {{ $titulaire->autreEmail() }}</p>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
						<button type="button" data-dismiss="modal" onclick="supprimerTitulaire({{ $titulaire->id }})" class="btn btn-danger">Supprimer</button>
					</div>
				</div>
			</div>
		</div>
		@endforeach
		
		<div class="col-md-3">

				<!--begin:: Widgets/Last Updates-->
				<div class="kt-portlet kt-portlet--height-fluid">
					<div class="card-header">
						<div class="card-title">
							<h3>
								Les prestataires du chantier
							</h3>
						</div>
					</div>
					<div class="kt-portlet__body" id="les_presta2">
						@foreach($titulaires as $titulaire)
						
							<li role="treeitem" data-jstree="{ &quot;opened&quot; : true }" aria-selected="false" aria-level="2" aria-labelledby="j2_{{$titulaire->id}}_anchor" aria-expanded="true" id="j2_{{$titulaire->id}}" class="jstree-node  jstree-open">
								<i class="jstree-icon jstree-ocl" role="presentation"></i>
								<a data-toggle="modal" data-target="#kt_modal_{{ $titulaire->id }}" class="jstree-anchor" href="#" tabindex="-1" id="j2_{{$titulaire->id}}_anchor">
									<i class="jstree-icon jstree-themeicon fa fa-folder kt-font-warning jstree-themeicon-custom" role="presentation"></i>
									{{ $titulaire->raisonSociale() }} {{ ($titulaire->societe == $chantier->societe) ? '(P)' : '' }} 
								</a>
							</li>
						@endforeach
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
	<script src="{{ asset('assets/js/demo1/pages/crud/forms/widgets/input-mask.js') }}" type="text/javascript"></script>
@endsection