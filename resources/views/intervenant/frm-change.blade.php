@extends('layout.default')

@section('content')
<!-- begin:: Content Head -->
<div class="kt-subheader   kt-grid__item" id="kt_subheader">
	<div class="kt-subheader__main">
		<h3 class="kt-subheader__title">Fiche intervenant</h3>
		<span class="kt-subheader__separator kt-subheader__separator--v"></span>
		<span class="kt-subheader__desc">{{ $entite->name }}</span>
		
		<a href="/intervenants" class="btn btn-label-info btn-bold btn-sm btn-icon-h kt-margin-l-5">
			<i class="fa fa-arrow-left"></i> Retour
		</a>
	</div>
	<div class="kt-subheader__toolbar">
		
	</div>
</div>

<!-- end:: Content Head -->

<!-- begin:: Content -->
	
<div class="card card-custom">

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
		<div class="col-md-12">
			<div class="kt-portlet">
				<div class="card-body">
					<table class="table table-striped- table-bordered table-hover table-checkable">
						<tr>
							<td></td>
							@foreach($lesDo as $do)
								<td class="text-center">{{ $do->raisonSociale }} {{ $entite->getAutorisation($do->id) }} {{ $entite->getRenewState($do->id) }}</td>
							@endforeach	
						</tr>
						
						@foreach($typesPieces as $typePiece)
							<tr>
								@if($entite->getMyPiece($typePiece->id))
									@if($entite->checkMyPiece($typePiece->id) >= date("d/m/Y"))
										<td>{{ $typePiece->abbreviation }} Valide jusqu'au {{ $entite->checkMyPiece($typePiece->id) }} <a href="#" onclick="afficherDocument({{ $entite->getMyPiece($typePiece->id) }});"><i class="fa fa-eye"></i></a></td>
									@else
										<td>{{ $typePiece->abbreviation }} <span class="text-danger">EXP : {{ $entite->checkMyPiece($typePiece->id) }}</span> <a href="#" onclick="afficherDocument({{ $entite->getMyPiece($typePiece->id) }});"><i class="fa fa-eye"></i></a></td>
									@endif
								@else
									<td>{{ $typePiece->abbreviation }}</td>
								@endif
								
								@foreach($lesDo as $do)
									<td class="text-center" id="zone_{{ $typePiece->id }}_{{ $do->id }}">
										@if($entite->checkMyPiece($typePiece->id, $do->id) !== false)
											{{ $entite->checkMyPiece($typePiece->id, $do->id) < date("d/m/Y") ? "EXP" : $entite->checkMyPiece($typePiece->id, $do->id) }}
											
											@if($entite->getStatutPiece($typePiece->id, $do->id) == "refus")
												REFUS
											@endif
											de
										@else
											
										@endif
										
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
					</table>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6">
			<!--begin:: Widgets/New Users-->
			<div class="kt-portlet" id="viewer">
				<div class="card-header">
					<div class="card-title">
						<h3>
							Visualisation
						</h3>
					</div>
				</div>
				<div class="card-body">
					<iframe src = "/temp/ViewerJS/#../test_de.pdf" width='100%' height='600' allowfullscreen webkitallowfullscreen></iframe>
				</div>
			</div>
			
			<div class="kt-portlet">
				<div class="card-body">
					<!--begin::Form-->
					<form class="kt-form" method="POST" action="/intervenant/change">
						<input type="hidden" name="id" value="{{ $entite->id }}" />
						{{ csrf_field() }}
						<div class="card-body">
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
										<select name="nationalite" class="form-control selectpicker">
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
		
		<div class="col-md-6">
			<div class="kt-portlet">
				<div class="card-header">
					<div class="card-title">
						<h3>
							Charger une pièce
						</h3>
					</div>
				</div>

				<!--begin::Form-->
				<form class="kt-form kt-form--label-right" action="/intervenant/addpiece" method="POST" enctype="multipart/form-data">
					<input type="hidden" name="id" value="{{ $entite->id }}" />
					{{ csrf_field() }}
					<div class="card-body">
						<div class="form-group row">
							<label class="col-form-label col-lg-3 col-sm-12">Document</label>
							<div class="col-lg-8 col-md-9 col-sm-12">
								<select name="type_piece" class="form-control selectpicker">
									@foreach($typesPieces as $typePiece)
										<option value="{{ $typePiece->id }}">{{ $typePiece->libelle }}</option>
									@endforeach
								</select>
							</div>
						</div>

						<div class="form-group row">
							<label class="col-form-label col-lg-3 col-sm-12">Libellé (facultatif)</label>
							<div class=" col-lg-8 col-md-9 col-sm-12">
								<input class="form-control" type="text" name="libelle" value="" >
							</div>
						</div>
						
						<div class="form-group row">
							<label class="col-form-label col-lg-3 col-sm-12">Date expiration</label>
							<div class=" col-lg-8 col-md-9 col-sm-12">
								<input class="form-control" type="date" name="date_expiration" value="" id="example-date-input">
							</div>
						</div>
						
						<div class="form-group row">
							<label class="col-form-label col-lg-3 col-sm-12">Votre fichier</label>
							<div class="col-lg-8 col-md-9 col-sm-12">
								<input class="form-control" type="file" accept="image/png, image/jpeg, application/pdf" name="fichier" value="">
							</div>
						</div>
					</div>
					
					<div class="card-footer d-flex justify-content-between">
						<div class="kt-form__actions">
							<div class="row">
								<div class="col-lg-9 ml-lg-auto">
									<button type="submit" class="btn btn-brand">Valider</button>
									<button type="reset" class="btn btn-secondary">Annuler</button>
								</div>
							</div>
						</div>
					</div>
				</form>

				<!--end::Form-->
			</div>
			
			<div class="kt-portlet">
				<div class="card-header">
					<div class="card-title">
						<h3>
							Habilitations
						</h3>
					</div>
					<div class="kt-portlet__head-toolbar">
						<div class="dropdown dropdown-inline">
							<a href="/intervenant/carnet/{{ $entite->id }}" class="btn btn-clean btn-sm btn-icon btn-icon-md">
								<i class="fa fa-download"></i>
							</a>
						</div>
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
							<div class="col-5">
								<input type="date" class="form-control" id="" />
							</div>
						</div>
					@endforeach
					</form>
				</div>
				
				<!--end::Form-->
			</div>
		</div>
	</div>
	
	<!--End::Section-->
</div>
@endsection

@section('specifijs')
	<script src="{{ asset('assets/js/intervenant.js') }}" type="text/javascript"></script>
@endsection