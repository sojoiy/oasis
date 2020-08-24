@extends('layout.default')

@section('content')

<!-- end:: Content Head -->

<!-- begin:: Content -->

	@if($message == "WRONG_FORMAT")
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
	
	<!--begin::Modal-->
	@foreach ($pieces as $piece)
		<div class="modal fade" id="kt_modal_{{ $piece->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
					<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLongTitle">{{ $piece->type_piece() }}</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						</button>
					</div>
					<div class="modal-body">
						<p>Visuel de la pièce.</p>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
						<button type="button" class="btn btn-primary">Télécharger</button>
						<button type="button" data-dismiss="modal" onclick="supprimerPiece({{ $piece->id }})" class="btn btn-danger">Supprimer</button>
					</div>
				</div>
			</div>
		</div>
	@endforeach
	
	@foreach ($habilitations as $habilitation)
		<div class="modal fade" id="hab_modal_{{ $habilitation->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLongTitle">{{ $habilitation->id }}</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						</button>
					</div>
					<div class="modal-body">
						<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
						<button type="button" class="btn btn-primary">Valider</button>
						<button type="button" data-dismiss="modal" onclick="supprimerHabilitation({{ $habilitation->id }})" class="btn btn-danger">Supprimer</button>
					</div>
				</div>
			</div>
		</div>
	@endforeach
	
	<!--end::Modal-->
	
	<!--Begin::Section-->
			
			<div class="row">
				<div class="col-lg-12">
			
					<div class="card card-custom">
						<div class="card-body">
							<!--begin: Datatable-->
							<table class="table table-bordered table-hover table-checkable mt-10" id="kt_datatable">
								<thead>
									<tr>
										<th colspan="2">Mes pièces</th>
						
										@foreach($lesDo as $do)
											<th class="text-center" colspan="2">{{ $do->raisonSociale }} {{ $entite->getAutorisation($do->id) }} {{ $entite->getRenewState($do->id) }}</th>
										@endforeach
									</tr>
									<tr>
										<th>Type</th>
										<th>Action</th>
						
										@foreach($lesDo as $do)
											<th class="text-center">Etat</th>
											<th class="text-center">Action</th>
										@endforeach
									</tr>
								</thead>
								<tbody>
									@foreach($typesPieces as $typePiece)
										<tr>
											<td>{{ $typePiece->abbreviation }}</td>
											@if($entite->getMyPiece($typePiece->id))
												@if($entite->expMyPiece($typePiece->id))
													<td> Valide jusqu'au {{ $entite->checkMyPiece($typePiece->id) }} <a href="#" onclick="afficherDocument({{ $entite->getMyPiece($typePiece->id) }});"><i class="fa fa-eye"></i></a></td>
												@else
													<td><span class="text-danger">EXP : {{ $entite->checkMyPiece($typePiece->id) }}</span> <a href="#" onclick="afficherDocument({{ $entite->getMyPiece($typePiece->id) }});"><i class="fa fa-eye"></i></a></td>
												@endif
											@else
												<td></td>
											@endif
							
											@foreach($lesDo as $do)
												<td class="text-center" id="zone_{{ $typePiece->id }}_{{ $do->id }}">
													@if($entite->checkMyPiece($typePiece->id, $do->id) !== false)
														@if($entite->expMyPiece($typePiece->id, $do->id))
															{{ $entite->checkMyPiece($typePiece->id, $do->id) }}
														@else
															<span class="text-danger">EXP : {{ $entite->checkMyPiece($typePiece->id, $do->id) }}</span>
														@endif
														
														@if($entite->getStatutPiece($typePiece->id, $do->id) == "refus")
															REFUS
														@endif
													@else
										
													@endif
												</td>
												<td class="text-center">	
													@if($entite->getMyPiece($typePiece->id, $do->id))
														<a href="#" onclick="afficherDocument({{ $entite->getMyPiece($typePiece->id, $do->id) }});"><i class="fa fa-eye"></i></a>
														@if($entite->getStatutPiece($typePiece->id, $do->id) == "valide")
															<i class="fa fa-check-circle text-success"></i>&nbsp;<a href="#" data-container="body" data-toggle="kt-popover" data-placement="bottom" data-content="Attention cette pièce est déjà validée"><i class="fa fa-redo text-danger" onclick="rechargerPiece({{ $entite->id }}, {{ $typePiece->id }}, {{ $do->id }});"></i></a>
														@elseif($entite->getStatutPiece($typePiece->id, $do->id) == "refus")
															<a href="#"><i class="fa fa-times-circle text-danger" data-container="body" data-toggle="kt-popover" data-placement="bottom" data-content="{{ $entite->getCommentairePiece($typePiece->id, $do->id) }}"></i>&nbsp;<i class="fa fa-redo" onclick="rechargerPiece({{ $entite->id }}, {{ $typePiece->id }}, {{ $do->id }});"></i></a>
														@else
															<a href="#" onclick="rechargerPiece({{ $entite->id }}, {{ $typePiece->id }}, {{ $do->id }});" ><i class="fa fa-redo"></i></a>
														@endif
													@endif
												</td>
											@endforeach
										</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-lg-8">
					<div class="card card-custom" id="viewer">
						<div class="card-header flex-wrap border-0 pt-6 pb-0">
							<div class="card-title">
								<h3 class="card-label">Visualisation</h3>
							</div>
			
							<div class="card-toolbar">
				
							</div>
						</div>
		
						<div class="card-body" id="">
							<iframe src = "/temp/ViewerJS/#../test_de.pdf" width='100%' height='600' allowfullscreen webkitallowfullscreen></iframe>
						</div>
					</div>
				</div>
				
				<div class="col-lg-4">
					<div class="card card-custom">
						<div class="card-header flex-wrap ">
							<div class="card-title">
								<h3 class="card-label">Charger une pièce</h3>
							</div>
						</div>
		
						<div class="card-body">
							<form class="kt-form kt-form--label-right" action="/intervenant/addpiece" method="POST" enctype="multipart/form-data">
								<input type="hidden" name="id" value="{{ $entite->id }}" />
								{{ csrf_field() }}
								<div class="card-body">
									<div class="form-group">
										<label >Document</label>
										<div class="col-lg-12 col-md-12 col-sm-12">
											<select name="type_piece" class="form-control selectpicker">
												@foreach($typesPieces as $typePiece)
													<option value="{{ $typePiece->id }}">{{ $typePiece->libelle }}</option>
												@endforeach
											</select>
										</div>
									</div>

									<div class="form-group">
										<label >Libellé (facultatif)</label>
										<div class=" col-lg-12 col-md-12 col-sm-12">
											<input class="form-control" type="text" name="libelle" value="" >
										</div>
									</div>
						
									<div class="form-group">
										<label >Date expiration</label>
										<div class=" col-lg-12 col-md-12 col-sm-12">
											<input class="form-control" type="date" name="date_expiration" value="" id="example-date-input">
										</div>
									</div>
						
									<div class="form-group">
										<label >Votre fichier</label>
										<div class="col-lg-12 col-md-12 col-sm-12">
											<input class="form-control" type="file" accept="image/png, image/jpeg, application/pdf" name="fichier" value="">
										</div>
									</div>
								</div>
					
								<div class="card-footer d-flex justify-content-between">
									<div class="kt-form__actions">
										<div class="row">
											<div class="col-lg-12 ml-lg-auto">
												<button type="submit" class="btn btn-success">Valider</button>
												<button type="reset" class="btn btn-secondary">Annuler</button>
											</div>
										</div>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-lg-8">
					<div class="card card-custom">
						<div class="card-header flex-wrap border-0 pt-6 pb-0">
							<div class="card-title">
								<h3 class="card-label">Informations</h3>
							</div>
						</div> 
		
						<div class="card-body">
							<form class="kt-form" method="POST" action="/intervenant/change">
								<input type="hidden" name="id" value="{{ $entite->id }}" />
								{{ csrf_field() }}
								<div class="kt-section kt-section--first">
									<div class="form-group row">
										<label class="col-lg-4 col-form-label">Nom : *</label>
										<div class="col-lg-6">
											<input type="text" name="nom" id="nom" required value="{{ $entite->nom }}" class="form-control" placeholder="Nom">
										</div>
									</div>
									<div class="form-group row">
										<label class="col-lg-4 col-form-label">Prénom : *</label>
										<div class="col-lg-6">
											<input type="text" name="prenom" id="prenom" value="{{ $entite->prenom }}" required class="form-control" placeholder="Prénom">
										</div>
									</div>

									<div class="form-group row">
										<label class="col-lg-4 col-form-label">Date de naissance : </label>
										<div class="col-lg-6">
											<input class="form-control" type="date" value="{{ $entite->date_naissance }}" name="date_naissance" value="" id="example-date-input">
										</div>
									</div>

									<div class="form-group row">
										<label class="col-lg-4 col-form-label">Fonction :</label>
										<div class="col-lg-6">
											<input type="text" name="fonction" value="{{ $entite->fonction }}" class="form-control" placeholder="Fonction">
										</div>
									</div>

									<div class="form-group row">
										<label class="col-lg-4 col-form-label">Lieu de naissance :</label>
										<div class="col-lg-6">
											<input type="text" name="lieu_naissance" value="{{ $entite->lieu_naissance }}" class="form-control" placeholder="ex : Paris">
										</div>
									</div>

									<div class="form-group row">
										<label class="col-lg-4 col-form-label">Adresse :</label>
										<div class="col-lg-6">
											<textarea name="adresse" class="form-control" rows="3">{{ $entite->adresse }}</textarea>
										</div>
									</div>

									<div class="form-group row">
										<label class="col-lg-4 col-form-label">Téléphone :</label>
										<div class="col-lg-6">
											<input type="text" name="telephone" value="{{ $entite->telephone }}" class="form-control" placeholder="">
										</div>
									</div>

									<div class="form-group row">
										<label class="col-lg-4 col-form-label">Nationalité :</label>
										<div class="col-lg-6">
											<select name="pays" class="form-control selectpicker">
												@foreach($lesPays as $pays)
													<option {{ ($pays->id == $entite->pays) ? 'selected' : '' }} value="{{ $pays->id }}">{{ $pays->libelle }}</option>
												@endforeach
											</select>
										</div>
									</div>

									<div class="form-group row">
										<label class="col-lg-4 col-form-label">Date d'embauche : </label>
										<div class="col-lg-6">
											<input class="form-control" type="date" value="{{ $entite->date_embauche }}" name="date_embauche" value="" >
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
				</div>
				<div class="col-lg-4">
					<div class="card card-custom">
						<div class="card-header flex-wrap border-0 pt-6 pb-0">
							<div class="card-title">
								<h3 class="card-label">Habilitations</h3>
							</div>
			
							<div class="card-toolbar">
				
							</div>
						</div>
		
						<div class="card-body">
							<form class="kt-form" method="POST" action="#">
							@foreach($typesHabilitations as $habilitation)
								<div class="form-group row">
									<label class="col-4 col-form-label">{{ $habilitation->libelle }} :</label>
									<div class="col-3">
										<span class="kt-switch">
											<label>
												<input type="checkbox" {{ ($entite->hasHabilitation($habilitation->id)) ? 'checked' : '' }} onchange="saveHabilitation({{ $entite->id }}, {{ $habilitation->id }})" />
												<span></span>
											</label>
										</span>
									</div>
								</div>
							@endforeach
						</div>
					</div>
					<br>
					<div class="card card-custom">
						<div class="card-header flex-wrap border-0 pt-6 pb-0">
							<div class="card-title">
								<h3 class="card-label">Chantiers</h3>
							</div>
						</div>
		
						<div class="card-body">
							<form class="kt-form" method="POST" action="#">
							@foreach($chantiers as $chantier)
								<div><a href="/chantier/show/{{ $chantier->id }}">{{ $chantier->numero }}</a></div>
							@endforeach
						</div>
					</div>
				</div>
			</div>
			
@endsection

@section('specifijs')
	<script src="{{ asset('assets/js/intervenant.js') }}" type="text/javascript"></script>
@endsection