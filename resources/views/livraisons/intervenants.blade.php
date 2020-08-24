@extends('layout.default')

@section('content')
@include('livraisons.head', ['active' => 'Intervenants'])

<!-- end:: Content Head -->

<!-- begin:: Content -->
<div class="card card-custom">
	<!--Begin::Section-->
	@if($livraison->do <> $user->societeID)
		<div class="row">
			<div class="col-md-4">

				<!--begin:: Widgets/New Users-->
				<div class="card card-custom">
					<div class="card-header">
						<div class="card-title">
							<h3>
								Chantier : {{ $livraison->numero }}
							</h3>
						</div>
					</div>
					<div class="card-body">
						<!--begin::Form-->
						<div class="form-group">
							<label>Numéro : {{ $livraison->numero }}</label><br>
							<label>Date de début : {{ date('d/m/Y à H:i', strtotime($livraison->date_debut)) }}</label><br>
							<label>Date de fin : {{ date('d/m/Y à H:i', strtotime($livraison->date_fin)) }}</label>
						</div>
						<div class="kt-separator kt-separator--border-dashed kt-separator--space-lg"></div>
						<div class="form-group">
							<label>Médecin du Travail</label>
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
					<form class="kt-form" method="POST" action="/livraison/ajouterpiece" enctype="multipart/form-data">
					<div class="card-body">
						<!--begin::Form-->
						<input type="hidden" name="livraison" value="{{ $livraison->id }}" />
						<input type="hidden" name="entite" value="0" id="id_intervenant" />
						<input type="hidden" name="equipier" value="0" id="id_equipier" />
						{{ csrf_field() }}
						<div class="form-group row">
							<label class="col-form-label col-lg-3 col-sm-12">Intervenant</label>
							<div class=" col-lg-8 col-md-9 col-sm-12">
								<input class="form-control" type="text" name="intervenant" value="Veuillez choisir un intervenant" id="identite_intervenant" disabled>
							</div>
						</div>
				
						<div class="form-group row">
							<label class="col-form-label col-lg-3 col-sm-12">Document</label>
							<div class="col-lg-8 col-md-9 col-sm-12">
								<select id="typePiece" name="type_piece" class="form-control selectpicker">
									@foreach($livraison->pieces_oblig($categorie) as $piece)
										<option value="{{ $piece->id }}">{{ $piece->libelle }}</option>
									@endforeach
								</select>
							</div>
						</div>
				
						<div class="form-group row">
							<label class="col-form-label col-lg-3 col-sm-12">Date expiration</label>
							<div class=" col-lg-8 col-md-9 col-sm-12">
								<input class="form-control" type="date" name="date_expiration" value="{{ date('Y-m-d') }}" id="example-date-input">
							</div>
						</div>
				
						<div class="form-group row">
							<label class="col-form-label col-lg-3 col-sm-12">Votre fichier</label>
							<div class="col-lg-8 col-md-9 col-sm-12">
								<input class="form-control" type="file" name="fichier" value="">
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

				<!--end:: Widgets/New Users-->
			</div>
		</div>
	@endif
	
	<div class="row">
		<div class="col-md-12">
			<div class="kt-portlet">
				<div class="card-header">
					<div class="card-title">
						<h3>
							Les livreurs
						</h3>
					</div>
				</div>
				<div class="card-body">

					<!--begin::Section-->
					<div class="kt-section">
						@if($livraison->do <> $user->societeID)
							<div class="kt-section__info">
								Constituez ici l'équipe pour le livraison <code>{{ $livraison->libelle }}</code>.
								<select class="form-control" onchange="ajouterLivreur({{ $livraison->id }}, this.value)" id="selectEquipier" name="equipier">
									<option value="0">-- Ajouter un membre --</option>
									@foreach($remplacants as $entite)
										<option id="ligneEntite_{{ $entite->id }}" value="{{ $entite->id }}">{{ $entite->name }}</option>
									@endforeach
								</select>
							</div>
						@endif
						
						<div class="kt-section__content">
							<div class="table-responsive">
								<table class="table table-bordered">
									<thead>
										<tr>
											<th class="text-center">#</th>
											<th class="text-left">Nom</th>
											<!-- AFFICHAGE DE LA SOCIETE -->
											@if($livraison->do == $user->societeID)
												<th class="text-left">Société</th>
											@endif
											
											@if($livraison->mecanisme == 2 || $livraison->mecanisme == 4)
												<th class="text-center" style="width:80px;">Validation globale</th>
											@endif
											
											@foreach($livraison->pieces_immaginables() as $piece)
												<th class="text-center" style="width:80px;">{{ $piece->abbreviation }}</th>
											@endforeach
											<th class="text-center"></th>
										</tr>
									</thead>
									<tbody id="equipe_livraison">
										@foreach($equipe as $entite)
											<tr id="ligneEquipier_{{ $entite->id }}">
												<td class="text-center" scope="row" style="width:80px;">
													@if($entite->validation)
														<a href="/livraison/fic/{{ $entite->id }}"><i class="fa fa-check-circle text-success fa-2x" data-toggle="kt-popover" title="Entité validée" data-content="Validation effectuée le {{ date('d/m/Y à H:i', strtotime($entite->validation)) }} par {{ $entite->auteur_validation() }}"></i></a>
													@else
														{{ $entite->id }}
													@endif
												</td>
												<td>{{ $entite->name() }} {{ $entite->prenom }} ({{ $entite->nature() }})</td>
												
												<!-- AFFICHAGE DE LA SOCIETE -->
												@if($livraison->do == $user->societeID)
													<td>{{ $entite->employeur() }}</td>
												@endif
												
												@if($livraison->do == $user->societeID)
													@if($livraison->mecanisme == 2 || $livraison->mecanisme == 4)
														<td class="text-center" style="width:80px;">
															<a href="#" title="" class="btn">
																@if($entite->validation_globale($livraison->do))
																	<i class="fa fa-check-circle text-success fa-2x" data-toggle="kt-popover" title="Entité validée" data-content=""></i>
																@else
																	<i class="fa fa-exclamation-triangle text-warning fa-2x" data-toggle="kt-popover" title="En attente de validation" data-content=""></i>
																@endif
															</a>
														</td>
													@endif
												@else
													@if($livraison->mecanisme == 2 || $livraison->mecanisme == 4)
														<td class="text-center" style="width:80px;">
															<a href="#" title="" class="btn">
																@if($entite->validation_globale($livraison->do))
																	<i class="fa fa-check-circle text-success fa-2x" data-toggle="kt-popover" title="Entité validée" data-content=""></i>
																@else
																	<i class="fa fa-exclamation-triangle text-warning fa-2x" data-toggle="kt-popover" title="En attente de validation" data-content=""></i>
																@endif
															</a>
														</td>
													@endif
												@endif
												
												@foreach($livraison->pieces_immaginables() as $piece)
													<td class="text-center" style="width:80px;">
														<button class="btn" onclick="selectionnerLivreur({{ $entite->intervenant }}, 'name', {{ $entite->id }}, {{ $piece->id }});$('html,body').animate({scrollTop: 0}, 'slow');">
														<i class="far fa-clipboard fa-2x text-{{ $entite->checkPiece($livraison->id, $piece->id) }}"></i></button>
													</td>
												@endforeach
												
												@if($livraison->do <> $user->societeID)
													<td class="text-center" style="width:140px;" nowrap>
														@if(!$entite->validation)
															<button title="Retirer du livraison" class="btn btn-sm" onclick="enleverEquipier({{ $livraison->id }}, {{ $entite->id }})"><i class="fa fa-times fa-2x text-danger"></i></button>
														@endif
													</td>
												@else
													<td nowrap class="text-center" style="width:140px;padding-top:15px;">
														@include('livraison.tabintervenant', ['entite' => $entite])
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

	<!--End::Section-->
</div>
@endsection

@section('specifijs')
	<script src="{{ asset('assets/js/livraison.js') }}" type="text/javascript"></script>
@endsection