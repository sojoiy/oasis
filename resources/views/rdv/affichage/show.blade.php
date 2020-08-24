@extends('layout.default')

@section('content')
<!-- begin:: Content -->
	@if($rdv->validation > 0)
		<div class="alert alert-success fade show" role="alert">
			<div class="alert-icon"><i class="fa fa-thumbs-up"></i></div>
			<div class="alert-text">Rendez-vous validé par {{ $rdv->auteur_validation() }} le {{ $rdv->date_validation }}</div>
			<div class="alert-close">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true"><i class="fa fa-times"></i></span>
				</button>
			</div>
		</div>
	@endif
	
	<!--Begin::Section-->
	<div class="card card-custom" id="viewer">
		<div class="card-body">
		<!--begin::Form-->
		<!--begin::Form-->
		<form class="kt-form kt-form--fit kt-form--label-right" method="POST" id="RdvForm" action="/rdv/save">
			<input type="hidden" name="id" value="{{ $rdv->id }}" />
			{{ csrf_field() }}
			<div class="card-body">
				<p class="font-size-h4 font-size-lg-h2">1. Visiteur :</p>
				<div class="kt-separator kt-separator--border-dashed "></div>
				
				<div id="visitors">
					@foreach($visiteurs as $visiteur)
						<div class="form-group row" id="personnel_visite">
							<label class="col-lg-2 col-form-label">Nom *</label>
							<div class="col-lg-2">
								<input type="text" required name="nom_visiteur[]" class="form-control" {{ $disabled }} value="{{ $visiteur->nom}}" placeholder="Nom">
							</div>
					
							<label class="col-lg-1 col-form-label">Prénom *</label>
							<div class="col-lg-2">
								<input type="text" required name="prenom_visiteur[]" class="form-control" {{ $disabled }} value="{{ $visiteur->prenom}}" placeholder="Prénom">
							</div>
					
							<label class="col-lg-1 col-form-label">Société *</label>
							<div class="col-lg-2">
								<input type="text" required name="societe_visiteur[]" class="form-control" {{ $disabled }} value="{{ $visiteur->societe}}" placeholder="Société">
							</div>
							@if(!$rdv->validation)
								<div class="col-lg-2">
									<label class="col-lg-1 col-form-label"><i onclick="removeDate({{ $visiteur->id }});" class="fa fa-2x fa-plus-circle"></i></label>
								</div>
							@endif
						</div>
					@endforeach
				</div>
				
				<p class="font-size-h4 font-size-lg-h2">2. Personne visitée :</p>
				<div class="kt-separator kt-separator--border-dashed "></div>
				
				<div class="form-group row">
					<label class="col-lg-2 col-form-label">Nom *</label>
					<div class="col-lg-2">
						<input type="text" required name="nom_do" class="form-control" placeholder="Nom" {{ $disabled }} value="{{ $rdv->nom_do}}">
					</div>
					
					<label class="col-lg-1 col-form-label">Prénom *</label>
					<div class="col-lg-2">
						<input type="text" required name="prenom_do" class="form-control" placeholder="Prénom" {{ $disabled }} value="{{ $rdv->prenom_do}}">
					</div>
					
					<label class="col-lg-1 col-form-label">Service *</label>
					<div class="col-lg-2">
						<div class="kt-input-icon">
							<select class="form-control" {{ $disabled }} name="service">
								@foreach($services as $service)
									<option {{ (($service->id == $rdv->service) ? 'selected' : '') }} value="{{ $service->id }}">{{ $service->libelle }}</option>
								@endforeach
								<option {{ (($rdv->service == 0) ? 'selected' : '') }} value="0">-- Société Externe --</option>
							</select>
						</div>
					</div>
				</div>
				
				@if($rdv->societe_externe != "")
					<div class="form-group row" id="nom_societe">
				@else
					<div class="form-group row" id="nom_societe" style="display:none;">
				@endif
				
					<label class="col-lg-2 col-form-label">Société</label>
					<div class="col-lg-2">
						<input type="text" name="societe" {{ $disabled }}  class="form-control" id="societe" value="{{ $rdv->societe_externe }}" placeholder="Société">
					</div>
				</div>
				
				<div id="dates">
					@foreach($creneaux as $creneau)
						<div class="form-group row">
							<label class="col-lg-2 col-form-label">Date RDV *</label>
							<div class="col-lg-2">
								<input class="form-control" required {{ $disabled }} name="date_rdv[]" type="datetime-local" value="{{ $creneau }}" required value="" id="example-datetime-local-input" >
							</div>
							@if(!$rdv->validation)
							<div class="col-lg-3">
								<button type="button" onclick="addDate()" class="btn btn-success"><i class="fa fa-calendar"></i> Ajouter une date</button>
							</div>
							@endif
						</div>
					@endforeach
				</div>

				<div class="form-group row">
					<label class="col-lg-2 col-form-label">Zone d'accès</label>
					<div class="col-lg-2">
						<div class="kt-input-icon">
							<select class="form-control" name="zone">
								<option value="0">-- Veuillez choisir une zone --</option>
								@foreach($zones as $zone)
									<option {{ ($zone->id == $rdv->zone) ? 'selected' : '' }} value="{{ $zone->id }}">{{ $zone->libelle }}</option>
								@endforeach
							</select>
						</div>
					</div>
				</div>
				
				<div class="form-group row">
					<label class="col-lg-2 col-form-label">Commentaire</label>
					<div class="col-lg-8">
						<textarea class="form-control" name="commentaire" {{ $disabled }}>{{ $rdv->commentaire }}</textarea>
					</div>
				</div>
				
				<p class="font-size-h4 font-size-lg-h2">3. Valideur :</p>
				<div class="kt-separator kt-separator--border-dashed "></div>
				
				<div class="form-group row">
					<label class="col-lg-2 col-form-label">Choix du valideur *</label>
					<div class="col-lg-4">
						<div class="kt-input-icon">
							<select required class="form-control" {{ $disabled }} name="valideur">
								@foreach($users as $valideur)
									<option {{ ($valideur->id == $rdv->valideur) ? 'selected' : '' }} value="{{ $valideur->id }}">{{ $valideur->name }}</option>
								@endforeach
							</select>
						</div>
					</div>
				</div>
				
				<div class="form-group row" id="valideur2">
					@if($user->dernier_valideur)
					<label class="col-lg-2 col-form-label">Choix du valideur niv 2</label>
					<div class="col-lg-4">
						<div class="kt-input-icon">
						<select required class="form-control" name="valideur2">
							<option value="0">-- Validation niveau 1 uniquement --</option>
							@foreach($users as $valideur)
								<option {{ ($valideur->id == $rdv->valideur2) ? 'selected' : '' }} value="{{ $valideur->id }}">{{ $valideur->name }}</option>
							@endforeach
						</select>
						</div>
					</div>
					@endif
				</div>
			</div>
			@if(!$rdv->validation)
					<div class="kt-form__actions">
						<div class="row">
							<div class="col-lg-2"></div>
							<div class="col-lg-2">
								<button type="submit" class="btn btn-success">Enregistrer</button>
							</div>
							<div class="col-lg-1"></div>
							
							<div class="col-lg-2">
								@if($user->id == $rdv->valideur || $user->checkRights("valider_rdv"))
									<button type="button" onclick="accepterRdv({{ $rdv->id }});" class="btn btn-success"><i class="fa fa-check"></i>Valider</button>
									<button type="button" onclick="refuserRdv({{ $rdv->id }});" class="btn btn-danger"><i class="fa fa-minus-circle"></i> Refuser</button>
								@endif
							</div>
						</div>
					</div>
			@endif
		</form>
	</div>
</div>
@endsection

@section('specifijs')
	<script src="{{ asset('assets/js/rdv.js') }}" type="text/javascript"></script>
@endsection