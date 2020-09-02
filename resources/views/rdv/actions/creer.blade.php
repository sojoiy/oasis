@extends('layout.default')

@section('content')
<!-- begin:: Content Head -->
			<div class="card card-custom" id="viewer">
				<div class="card-body">
					<!--begin::Form-->
					<!--begin::Form-->
					<form class="kt-form kt-form--fit kt-form--label-right" method="POST" action="/rdv/creerrdv">
						<input type="hidden" name="type_chantier" value="2" />
						{{ csrf_field() }}
						<div class="card-body">
							<p class="font-size-h4 font-size-lg-h2">1. Visiteur :</p>
							<div class="kt-separator kt-separator--border-dashed "></div>
							
							<div id="visitors">
								<div class="form-group row" id="personnel_visite">
									<label class="col-lg-2 col-form-label">Nom *</label>
									<div class="col-lg-2">
										<input type="text" required name="nom_visiteur[]" class="form-control" placeholder="Nom">
									</div>
								
									<label class="col-lg-1 col-form-label">Prénom *</label>
									<div class="col-lg-2">
										<input type="text" required name="prenom_visiteur[]" class="form-control" placeholder="Prénom">
									</div>
								
									<label class="col-lg-1 col-form-label">Société *</label>
									<div class="col-lg-2">
										<input type="text" required name="societe_visiteur[]" class="form-control" placeholder="Société">
									</div>
									<div class="col-lg-2">
										<label class="col-lg-1 col-form-label"><i onclick="ajouterVisiteur();" class="fa fa-2x fa-plus-circle"></i></label>
									</div>
								</div>
							</div>
							
							<p class="font-size-h4 font-size-lg-h2">2. Personne visitée :</p>
							<div class="kt-separator kt-separator--border-dashed "></div>
							
							<div class="form-group row">
								<label class="col-lg-2 col-form-label">Nom *</label>
								<div class="col-lg-2">
									<input type="text" required name="nom_do" class="form-control" placeholder="Nom" value="{{ $user->nom }}">
								</div>
								
								<label class="col-lg-1 col-form-label">Prénom *</label>
								<div class="col-lg-2">
									<input type="text" required name="prenom_do" class="form-control" placeholder="Prénom" value="{{ $user->prenom }}">
								</div>
								
								<label class="col-lg-1 col-form-label">Service *</label>
								<div class="col-lg-2">
									<div class="kt-input-icon">
										<select class="form-control" onchange="if(this.value == 0){$('#nom_societe').show();}else{$('#nom_societe').hide();$('#societe').val('');}" name="service">
											@foreach($services as $service)
												<option value="{{ $service->id }}">{{ $service->libelle }}</option>
											@endforeach
											<option value="0">-- Société Externe --</option>
										</select>
									</div>
								</div>
							</div>
							
							<div class="form-group row" id="nom_societe" style="display:none;">
								<label class="col-lg-2 col-form-label">Société</label>
								<div class="col-lg-2">
									<input type="text" name="societe" class="form-control" id="societe" placeholder="Société">
								</div>
							</div>
							
							<div id="dates">
								<div class="form-group row">
									<label class="col-lg-2 col-7form-label">Date RDV *</label>
									<div class="col-lg-2 date">
										<input class="form-control" required name="date_rdv[]" type="text" required placeholder="jj / mm / aaaa --:--" id="kt_datetimepicker_3">
									</div>
								
									<div class="col-lg-3">
										<button type="button" onclick="addDate()" class="btn btn-success"><i class="fa fa-calendar"></i> Ajouter une date</button>
									</div>
								</div>
							</div>
							
							<div class="form-group row">
								<label class="col-lg-2 col-form-label">Zone d'accès</label>
								<div class="col-lg-2">
									<div class="kt-input-icon">
										<select class="form-control" name="zone">
											<option value="0">-- Veuillez choisir une zone --</option>
											@foreach($zones as $zone)
												<option value="{{ $zone->id }}">{{ $zone->libelle }}</option>
											@endforeach
										</select>
									</div>
								</div>
							</div>
							
							<div class="form-group row">
								<label class="col-lg-2 col-form-label">Commentaire</label>
								<div class="col-lg-8">
									<textarea class="form-control" name="commentaire"></textarea>
								</div>
							</div>
							
							<p class="font-size-h4 font-size-lg-h2">3. Valideur :</p>
							<div class="kt-separator kt-separator--border-dashed "></div>
							
							<div class="form-group row">
								<label class="col-lg-2 col-form-label">Choix du valideur *</label>
								<div class="col-lg-4">
									<div class="kt-input-icon">
										<select required onchange="refreshValideur2(this.value)" class="form-control" name="valideur">
											<option value="0">-- Veuillez choisir un valideur --</option>
											@foreach($users as $valideur)
												<option {{ $valideur->id == $user->dernier_valideur ? 'selected' : '' }} value="{{ $valideur->id }}">{{ $valideur->name }}</option>
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
										<option value="0">-- Validation niveau 2 uniquement --</option>
										@foreach($users as $valideur)
											<option value="{{ $valideur->id }}">{{ $valideur->name }}</option>
										@endforeach
									</select>
									</div>
								</div>
								@endif
							</div>
						</div>
						<div class="kt-portlet__foot kt-portlet__foot--fit-x">
							<div class="kt-form__actions">
								<div class="row">
									<div class="col-lg-2"></div>
									<div class="col-lg-10">
										<button type="submit" class="btn btn-success">Valider</button>
										<button type="reset" class="btn btn-secondary">Annuler</button>
									</div>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
			
@endsection

@section('specifijs')
	<script src="{{ asset('assets/js/rdv.js') }}" type="text/javascript"></script>
	<script src="{{ asset('assets/js/pages/crud/forms/widgets/bootstrap-datetimepicker.js?v=7.0.5') }}" type="text/javascript" charset="UTF-8"></script>
	
	
@endsection