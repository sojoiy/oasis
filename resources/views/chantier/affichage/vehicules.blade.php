@extends('layout.default')

@section('content')

<!-- end:: Content Head -->
@include('chantier.modal_prorogation', ['chantier' => $chantier])

<div class="modal fade" id="kt_modal_prorogation" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">

		<form class="kt-form" method="POST" id="prorogation" action="/chantier/proroger">
		<div class="modal-content">
			<div class="modal-header">
			<h5 class="modal-title" id="exampleModalLongTitle">Proroger le chantier</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				</button>
			</div>
			<div class="modal-body">
					<input type="hidden" name="chantierID" value="{{ $chantier->id }}" />
					{{ csrf_field() }}
					<div class="form-group row">
						<label class="col-form-label col-lg-3 col-sm-12">Date actuelle</label>
						<div class=" col-lg-8 col-md-9 col-sm-12">
							<input class="form-control" type="date" name="ancienne_date" disabled value="{{ date('Y-m-d', strtotime($chantier->date_fin)) }}" id="example-date-input">
						</div>
					</div>
					
					<div class="form-group row">
						<label class="col-form-label col-lg-3 col-sm-12">Nouvelle date</label>
						<div class=" col-lg-8 col-md-9 col-sm-12">
							<input class="form-control" type="date" name="date_fin" value="" id="example-date-input">
						</div>
					</div>
			</div>
			<div class="modal-footer">
				<button type="button" onclick="proroger()" data-dismiss="modal" class="btn btn-primary">Confirmer</button>
				<button type="button" data-dismiss="modal" class="btn btn-default">Annuler</button>
				<!-- ><button type="button" data-dismiss="modal" class="btn btn-danger">Non merci, je veux recharger mes pièces</button> -->
			</div>
		</div>
		</form>
	</div>
</div>

<div class="modal fade" id="kt_modal_newvehicule" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
			<h5 class="modal-title" id="exampleModalLongTitle">Ajouter un véhicule</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				</button>
			</div>
			<form class="kt-form" method="POST" action="/chantier/savevehicule">
				<div class="modal-body">
					<input type="hidden" name="chantierID" value="{{ $chantier->id }}" />
					{{ csrf_field() }}

					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label>Véhicule :</label>
								<select class="form-control" name="vehiculeID" onchange="chooseVehicule(this.value)">
									<option value="0">-- Créer un nouveau véhicule --</option>
									@foreach($remplacants as $entite)
										<option id="ligneEntite_{{ $entite->id }}" value="{{ $entite->id }}">{{ $entite->name }}</option>
									@endforeach
								</select>
							</div>
							<div class="form-group">
								<label>Immatriculation : *</label>
								<input type="text" name="immatriculation" id="sonImmatriculation" required class="form-control" placeholder="AM198RS">
							</div>
							
							<div class="form-group">
								<label>Marque :</label>
								<input type="text" name="marque" id="saMarque" required class="form-control" placeholder="Marque">
							</div>
							<div class="form-group">
								<label>Modèle :</label>
								<input type="text" name="modele" id="sonModele" required class="form-control" placeholder="Modèle">
							</div>
							
							<div class="form-group">
								<label>Type de véhicule :</label>
								<select class="form-control" id="sonType" name="type_vehicule">
									<option value="camionnette">Camionnette < 3.5t</option>
									<option value="navette">Navette</option>
									<option value="pl">PL</option>
									<option value="vl">VL Commerciale 2pl</option>
								</select>
							</div>
						</div>
						<div class="col-md-6">
							
							<div class="form-group">
								<label>Chauffeur :</label>
								<select class="form-control" name="chauffeur">
									@foreach($chantier->equipe($user->societeID) as $equipier)
										<option value="{{ $equipier->intervenant }}">{{ $equipier->name() }}</option>
									@endforeach
								</select>
							</div>

							<div class="form-group">
								<label>Motif :</label>
								<textarea class="form-control" name="motif"></textarea>
							</div>
							
							<div class="form-group">
								<label>Type de transport :</label>
								<select class="form-control" name="type_transport">
									<option value="materiel">Matériel</option>
									<option value="outillage">Outillage</option>
									<option value="pieces">Pièces</option>
								</select>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary">Valider</button>
					<button type="button" data-dismiss="modal" class="btn btn-danger">Annuler</button>
				</div>
			</form>
		</div>
	</div>
</div>

<div class="modal fade" id="kt_modal_avertissement" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
			<h5 class="modal-title" id="exampleModalLongTitle">Ajout des pièces</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				</button>
			</div>
			<div class="modal-body">
				<p>En ajoutant <span id="identite_intervenant2" class="kt-font-bolder"></span> à ce chantier vous allez transmettre les documents existants à <span id="donneur_dordre" class="kt-font-bolder">{{ $chantier->do() }}</span>.</p>
			</div>
			<div class="modal-footer">
				<button type="button" onclick="copierPieces();" class="btn btn-primary">Merci j'ai compris</button>
				<!-- ><button type="button" data-dismiss="modal" class="btn btn-danger">Non merci, je veux recharger mes pièces</button> -->
			</div>
		</div>
	</div>
</div>

<!-- begin:: Content -->
<!--Begin::Section-->
@if($chantier->do <> $user->societeID)
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
					<div class="pt-8 pb-6">
						<div class="d-flex align-items-center justify-content-between mb-2">
							<span class="font-weight-bold mr-2">Type de dossier :</span>
							{{ $chantier->type_chantier2($user->societe) }}
						</div>
						<div class="d-flex align-items-center justify-content-between mb-2">
							<span class="font-weight-bold mr-2">Date de début :</span>
							{{ date('d/m/Y', strtotime($chantier->date_debut)) }}
						</div>
						<div class="d-flex align-items-center justify-content-between mb-2">
							<span class="font-weight-bold mr-2">Date de fin :</span>
							{{ date('d/m/Y', strtotime($chantier->date_fin)) }}
						</div>
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
							Ajouter des pièces
						</h3>
					</div>
				</div>
				<div class="card-body">
					<!--begin::Form-->
					<form class="kt-form" method="POST" action="/chantier/ajouterpiece" enctype="multipart/form-data">
						<input type="hidden" name="chantierID" value="{{ $chantier->id }}" />
						<input type="hidden" name="intervenantID" value="0" id="id_intervenant" />
						<input type="hidden" name="equipierID" value="0" id="id_equipier" />
						<input type="hidden" name="vehicule" value="true" />
						{{ csrf_field() }}
						<div class="form-group row">
							<label class="col-form-label col-lg-3 col-sm-12">Véhicule</label>
							<div class=" col-lg-8 col-md-9 col-sm-12">
								<input class="form-control" type="text" name="intervenant" value="Veuillez choisir un véhicule" id="identite_intervenant" disabled>
							</div>
						</div>
			
						<div class="form-group row">
							<label class="col-form-label col-lg-3 col-sm-12">Document</label>
							<div class="col-lg-8 col-md-9 col-sm-12">
								<select name="type_piece" class="form-control selectpicker">
									<optgroup label="Pièces obligatoires" data-max-options="2">
										<option value="6">Carte grise</option>
									</optgroup>
								</select>
							</div>
						</div>
			
						<div class="form-group row">
							<label class="col-form-label col-lg-3 col-sm-12">Votre fichier</label>
							<div class="col-lg-8 col-md-9 col-sm-12">
								<input class="form-control" type="file" name="fichier" value="">
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
@endif

<br>

<div class="row">
	<div class="col-md-12">
		<div class="card card-custom">
			<div class="card-header">
				<div class="card-title">
					<h3>
						Les véhicules du chantier {{ $chantier->numero }}
					</h3>
				</div>
			</div>
			<div class="card-body">

				<!--begin::Section-->
				<div class="kt-section">
					@if($chantier->do <> $user->societeID)
						<a class="btn btn-label-brand btn-bold btn-sm btn-icon-h" href="#" data-toggle="modal" data-target="#kt_modal_newvehicule" tabindex="-1" id="p_addv_anchor">Ajouter un véhicule</a>
						<br><br>
					@endif
					
					<div class="kt-section__content">
						<div class="table-responsive">
							<table class="table table-bordered">
								<thead>
									<tr>
										<th class="text-center">#</th>
										<th class="text-left">Véhicule</th>
										<th class="text-left">Chauffeur</th>
										<!-- AFFICHAGE DE LA SOCIETE -->
										@if($chantier->do == $user->societeID)
											<th class="text-left">Société</th>
										@endif
										
										<th class="text-center" style="width:80px;">Type</th>
										<th class="text-center" style="width:80px;">Carte grise</th>
										<th class="text-center" style="width:80px;">Autorisation</th>
										<th class="text-center"></th>
									</tr>
								</thead>
								<tbody id="equipe_chantier">
									@foreach($vehicules as $vehicule)
										<tr id="ligneEquipier_{{ $vehicule->id }}">
											<td class="text-center" scope="row" style="width:80px;">{{ $vehicule->numero() }}</td>
											<td>{{ $vehicule->name() }} </td>
											<td>{{ $vehicule->chauffeur() }} </td>
											
											<!-- AFFICHAGE DE LA SOCIETE -->
											@if($chantier->do == $user->societeID)
												<td>{{ $vehicule->employeur() }}</td>
											@endif
											
											<td class="text-center" style="width:80px;">{{ $vehicule->type_vehicule() }}</button></td>
											
											<td class="text-center" style="width:80px;"><button class="btn" onclick="selectionnerEquipier({{$vehicule->intervenant }}, 'name', {{ $vehicule->id }}, 6)">
												<i class="far fa-clipboard fa-2x text-{{ $vehicule->checkPiece($chantier->id, 6) }}"></i></button>
											</td>
											<td class="text-center" style="width:80px;"><button class="btn" onclick="selectionnerEquipier({{$vehicule->intervenant }}, 'name', {{ $vehicule->id }})">
												<i class="far fa-clipboard fa-2x text-success"></i></button>
											</td>
											
											@if($chantier->do <> $user->societeID)
												<td class="text-center" style="width:120px;"><button class="btn btn-sm" onclick="enleverEquipier({{ $chantier->id }}, {{ $vehicule->id }})"><i class="fa fa-times fa-2x text-danger"></i></button></td>
											@else
												<td nowrap class="text-center" style="width:120px;padding-top:15px;" id="validationVehicule_{{ $vehicule->id }}">
													@include('chantier.tabvehicule', ['vehicule' => $vehicule])
												</td>
											@endif
										</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					</div>
				</div>

				<!--end::Section-->
			</div>

			<!--end::Form-->
		</div>
	</div>
</div>
@endsection

@push('scripts')
	<script src="{{ asset('assets/js/chantier.js') }}" type="text/javascript"></script>
@endpush