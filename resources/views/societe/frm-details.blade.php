@extends('layout.default')

@section('specificss')
	<link href="{{ asset('assets/vendors/general/bootstrap-timepicker/css/bootstrap-timepicker.css') }}" rel="stylesheet" type="text/css">
@endsection

@section('content')
<!-- begin:: Content Head -->

<!-- end:: Content Head -->

<!-- begin:: Content -->
<div class="card card-custom">
	<div id="activite"></div>
	
	<!--Begin::Section-->
	<div class="row">
		<div class="col-md-12">
			<!--begin:: Widgets/New Users-->
			<div class="card card-custom">
				<div class="card-body">
					<ul class="nav nav-tabs nav-bold nav-tabs-line">
						<li class="nav-item">
							<a class="nav-link active" data-toggle="tab" href="#kt_tab_pane_1_1">
								<span class="nav-icon">
									<i class="flaticon2-architecture-and-city"></i>
								</span>
								<span class="nav-text">Entreprise</span>
							</a>
						</li>
						
						<li class="nav-item">
							<a class="nav-link" data-toggle="tab" href="#kt_tab_pane_1_2">
								<span class="nav-icon">
									<i class="flaticon2-mail-1"></i>
								</span>
								<span class="nav-text">Adresse</span>
							</a>
						</li>
						
						<li class="nav-item">
							<a class="nav-link" data-toggle="tab" href="#kt_tab_pane_1_3">
								<span class="nav-icon">
									<i class="flaticon2-group"></i>
								</span>
								<span class="nav-text">Contacts</span>
							</a>
						</li>
					</ul>
					
					<form method="post" id="frm-fiche-entreprise">
						<input type="hidden" name="id" value="{{ $societe->id }}" />
						{{ csrf_field() }}
						<div class="tab-content">
							<div class="tab-pane active" id="kt_tab_pane_1_1" role="tabpanel">
								<br />
									<div class="form-group row">
										<label class="col-xl-3 col-lg-3 col-form-label">Raison sociale *</label>
										<div class="col-lg-9 col-xl-9">
											<input type="text" name="raisonSociale" value="{{ $societe->raisonSociale }}" required class="form-control" placeholder="Raison Sociale">
										</div>
									</div>
									<div class="form-group row">
										<label class="col-xl-3 col-lg-3 col-form-label">Nom d'usage</label>
										<div class="col-lg-9 col-xl-9">
										<input type="text" name="nomUsage" value="{{ $societe->nom_usage }}" class="form-control" placeholder="Nom d'usage">
										</div>
									</div>
									<div class="form-group row">
										<label class="col-xl-3 col-lg-3 col-form-label">Sigle</label>
										<div class="col-lg-9 col-xl-9">
											<input type="text" name="sigle" value="{{ $societe->sigle }}" class="form-control" placeholder="Sigle">
										</div>
									</div>
									<div class="form-group row">
										<label class="col-xl-3 col-lg-3 col-form-label">Numéro Siret</label>
										<div class="col-lg-9 col-xl-9">
										<input type="text" name="noSiret" id="sjy_inputmask_siret" value="{{ $societe->noSiret }}" class="form-control" placeholder="SIRET">
										<span class="form-text text-muted">Format <code>111 222 333 00000</code></span>
									</div>
									</div>
									<div class="form-group row">
										<label class="col-xl-3 col-lg-3 col-form-label">Critère différenciateur</label>
										<div class="col-lg-9 col-xl-9">
											<input class="form-control" type="text" name="critere" value="{{ $societe->critere }}">
										</div>
									</div>
							
									<div class="form-group row">
										<label class="col-xl-3 col-lg-3 col-form-label">Travail temporaire</label>
										<div class="kt-radio-inline">
											<label class="kt-radio">
												<input type="radio" name="temporaire" {{ ($societe->temporaire == 1) ? 'checked' : '' }} value="1"> Oui
												<span></span>
											</label>
											<label class="kt-radio">
												<input type="radio" name="temporaire" {{ ($societe->temporaire == 0) ? 'checked' : '' }} value="0"> Non
												<span></span>
											</label>
										</div>
									</div>
							
									<div class="form-group row">
										<label class="col-xl-3 col-lg-3 col-form-label">Transport</label>
										<div class="kt-radio-inline">
											<label class="kt-radio">
												<input type="radio" name="transport" {{ ($societe->transport == 1) ? 'checked' : '' }} value="1"> Oui
												<span></span>
											</label>
											<label class="kt-radio">
												<input type="radio" name="transport" {{ ($societe->transport == 0) ? 'checked' : '' }} value="0"> Non
												<span></span>
											</label>
										</div>
									</div>
							
									<div class="form-group row">
										<label class="col-xl-3 col-lg-3 col-form-label">N° TVA</label>
										<div class="col-lg-9 col-xl-9">
											<input class="form-control" type="text" name="TVA" value="{{ $societe->tva }}">
										</div>
									</div>
							
									<div class="form-group row">
										<label class="col-xl-3 col-lg-3 col-form-label">N° CERFI</label>
										<div class="col-lg-9 col-xl-9">
											<input class="form-control" type="text" value="{{ $societe->cerfi }}" name="CERFI">
										</div>
									</div>
							
									<div class="form-group row">
										<label class="col-xl-3 col-lg-3 col-form-label">N° DUNS</label>
										<div class="col-lg-9 col-xl-9">
											<input class="form-control" type="text" value="{{ $societe->duns }}" name="DUNS">
										</div>
									</div>
							</div>
							<div class="tab-pane" id="kt_tab_pane_1_2" role="tabpanel">
								<br />
								<div class="form-group row">
									<label class="col-xl-3 col-lg-3 col-form-label">N° et libellé de la Voie</label>
									<div class="col-lg-9 col-xl-9">
										<input type="text" class="form-control" name="adresse" placeholder="75 Rue de la paix" value="{{ $societe->adresse }}">
									</div>
								</div>
							
								<div class="form-group row">
									<label class="col-xl-3 col-lg-3 col-form-label">Complément</label>
									<div class="col-lg-9 col-xl-9">
										<input type="text" class="form-control" name="complement" placeholder="BP00000" value="{{ $societe->complement }}">
									</div>
								</div>
							
								<div class="form-group row">
									<label class="col-xl-3 col-lg-3 col-form-label">Code postal</label>
									<div class="col-lg-9 col-xl-9">
										<input type="text" class="form-control" name="code_postal" placeholder="75000" value="{{ $societe->codePostal }}">
									</div>
								</div>
							
								<div class="form-group row">
									<label class="col-xl-3 col-lg-3 col-form-label">Ville</label>
									<div class="col-lg-9 col-xl-9">
										<input type="text" class="form-control" name="ville" placeholder="Paris" value="{{ $societe->ville }}">
									</div>
								</div>
							
								<div class="form-group row">
									<label class="col-xl-3 col-lg-3 col-form-label">Pays</label>
									<div class="col-lg-9 col-xl-9">
										<select name="pays" class="form-control selectpicker">
											@foreach($lesPays as $pays)
												<option {{ ($pays->id == $societe->pays) ? 'selected' : '' }} value="{{ $pays->id }}">{{ $pays->libelle }}</option>
											@endforeach
										</select>
									</div>
								</div>
							
								<div class="form-group row">
									<label class="col-xl-3 col-lg-3 col-form-label">Téléphone</label>
									<div class="col-lg-9 col-xl-9">
										<div class="input-group">
											<input type="text" class="form-control" name="telephone" value="{{ $societe->telephone }}" placeholder="Téléphone" aria-describedby="basic-addon1">
										</div>
									</div>
								</div>
							</div>
							<div class="tab-pane" id="kt_tab_pane_1_3" role="tabpanel">
								<br>
								<div class="form-group row">
									<label class="col-xl-3 col-lg-3 col-form-label">Nom directeur</label>
									<div class="col-lg-9 col-xl-9">
										<input type="text" name="nomDirecteur" value="{{ $societe->nomDirecteur }}" class="form-control" placeholder="Nom du directeur">
									</div>
								</div>
								<div class="form-group row">
									<label class="col-xl-3 col-lg-3 col-form-label">Prénom directeur</label>
									<div class="col-lg-9 col-xl-9">
										<input type="text" name="prenomDirecteur" value="{{ $societe->prenomDirecteur }}" class="form-control" placeholder="Prénom du directeur">
									</div>
								</div>
								<div class="form-group row">
									<label class="col-xl-3 col-lg-3 col-form-label">Titre directeur</label>
									<div class="col-lg-9 col-xl-9">
										<input type="text" name="titreDirecteur" value="{{ $societe->titreDirecteur }}" class="form-control" placeholder="Titre du directeur">
									</div>
								</div>
								<div class="kt-separator kt-separator--dashed"></div>
								<div class="form-group row">
									<label class="col-xl-3 col-lg-3 col-form-label">Responsable sécurité</label>
									<div class="col-lg-9 col-xl-9">
										<input type="text" name="responsableSecurite" value="{{ $societe->responsableSecurite }}" class="form-control" placeholder="Nom du Responsable sécurité">
									</div>
								</div>
								<div class="form-group row">
									<label class="col-xl-3 col-lg-3 col-form-label">CHSCT</label>
									<div class="col-lg-9 col-xl-9">
										<input type="text" name="chsct" value="{{ $societe->chsct }}" class="form-control" placeholder="Nom du CHSCT">
									</div>
								</div>
								<div class="form-group row">
									<label class="col-xl-3 col-lg-3 col-form-label">Médecin du Travail</label>
									<div class="col-lg-9 col-xl-9">
										<input type="text" name="medecinDuTravail" value="{{ $societe->medecinDuTravail }}" class="form-control" placeholder="Nom du médecin du travail">
									</div>
								</div>
								
								@if($societe->noSiret == "")
									<div class="kt-separator kt-separator--dashed"></div>
									<div class="form-group row">
										<label class="col-xl-3 col-lg-3 col-form-label">Nom du représentant</label>
										<div class="col-lg-9 col-xl-9">
											<input type="text" name="nomRepresentant" value="{{ $societe->nomRepresentant }}" class="form-control" placeholder="Nom du représentant en France">
										</div>
									</div>
									<div class="form-group row">
										<label class="col-xl-3 col-lg-3 col-form-label">Prénom du représentant</label>
										<div class="col-lg-9 col-xl-9">
											<input type="text" name="prenomRepresentant" value="{{ $societe->prenomRepresentant }}" class="form-control" placeholder="Prénom du représentant en France">
										</div>
									</div>
									<div class="form-group row">
										<label class="col-xl-3 col-lg-3 col-form-label">Fonction du représentant</label>
										<div class="col-lg-9 col-xl-9">
											<input type="text" name="fonctionRepresentant" value="{{ $societe->fonctionRepresentant }}" class="form-control" placeholder="Fonction du représentant en France">
										</div>
									</div>
									<div class="form-group row">
										<label class="col-xl-3 col-lg-3 col-form-label">Téléphone du représentant</label>
										<div class="col-lg-9 col-xl-9">
											<input type="text" name="telephoneRepresentant" value="{{ $societe->telephoneRepresentant }}" class="form-control" placeholder="Téléphone du représentant en France">
										</div>
									</div>
								@endif
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