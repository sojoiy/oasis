@extends('layout.default')

@section('content')

@include('chantier.head_autorisation', ['active' => 'Autorisation'])

<!-- begin:: Content -->
<div class="card card-custom">
	
	<div class="modal fade" id="kt_modal_accord" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">

			<form class="kt-form" method="POST" id="autorisation" action="/chantier/changerAutorisation">
			<div class="modal-content">
				<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLongTitle">Accorder l'autorisation</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					</button>
				</div>
				<div class="modal-body">
						<input type="hidden" name="autorisation" value="{{ $autorisation->id }}" />
						{{ csrf_field() }}
						<div class="form-group row">
							<label class="col-form-label col-lg-3 col-sm-12">Date de fin de validité</label>
							<div class=" col-lg-8 col-md-9 col-sm-12">
								<input class="form-control" type="date" min="{{ date('Y-m-d') }}" required name="date_fin_validite" value="{{ date('Y-m-d', strtotime(date('Y-m-d') .'+ '.$societe->validite_global.'month ')) }}" id="example-date-input">
							</div>
						</div>
					
						<div class="form-group row">
							<label class="col-form-label col-lg-3 col-sm-12">Commentaire</label>
							<div class=" col-lg-8 col-md-9 col-sm-12">
								<textarea name="commentaire" required class="form-control" ></textarea>
							</div>
						</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary">Valider</button>
					<button type="button" data-dismiss="modal" class="btn btn-default">Annuler</button>
					<!-- ><button type="button" data-dismiss="modal" class="btn btn-danger">Non merci, je veux recharger mes pièces</button> -->
				</div>
			</div>
			</form>
		</div>
	</div>
	
	<div class="modal fade" id="kt_modal_refus" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">

			<form class="kt-form" method="POST" id="autorisation2" action="/chantier/annulerAutorisation">
			<div class="modal-content">
				<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLongTitle">Refuser l'autorisation</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					</button>
				</div>
				<div class="modal-body">
						<input type="hidden" name="autorisation" value="{{ $autorisation->id }}" />
						{{ csrf_field() }}
						<div class="form-group row">
							<label class="col-form-label col-lg-3 col-sm-12">Date de fin d'invalidité</label>
							<div class=" col-lg-8 col-md-9 col-sm-12">
								<input class="form-control" type="date" min="{{ date('Y-m-d') }}" required name="date_fin_invalidite" value="{{ date('Y-m-d', strtotime(date('Y-m-d') .'+ '.$societe->validite_global.'month ')) }}" id="example-date-input">
							</div>
						</div>
					
						<div class="form-group row">
							<label class="col-form-label col-lg-3 col-sm-12">Commentaire</label>
							<div class=" col-lg-8 col-md-9 col-sm-12">
								<textarea name="commentaire" required class="form-control" ></textarea>
							</div>
						</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary">Valider</button>
					<button type="button" data-dismiss="modal" class="btn btn-default">Annuler</button>
					<!-- ><button type="button" data-dismiss="modal" class="btn btn-danger">Non merci, je veux recharger mes pièces</button> -->
				</div>
			</div>
			</form>
		</div>
	</div>
	
	<!--Begin::Section-->
	<div class="row">
		<div class="col-md-4">

			<!--begin:: Widgets/New Users-->
			<div class="card card-custom">
				<div class="card-header">
					<div class="card-title">
						<h3>
							{{ $entite->name }}
						</h3>
					</div>
				</div>
				<div class="card-body">
					<!--begin::Form-->
					<div class="form-group">
						<label>Employeur : {{ $prestataire->raisonSociale }}</label><br>
						<label>Nationalité Employeur : {{ $entite->nationalite }}</label><br>
						<label>Entreprise Travail Temporaire : {{ $entite->nationalite }}</label><br>
						<label>Nationalité : {{ $entite->nationalite }}</label><br>
						<label>Date de naissance : {{ date('d/m/Y', strtotime($entite->date_naissance)) }}</label><br>
						<label>Fonction : {{ $entite->fonction }}</label><br>
						<label>Personnel détaché : {{ $entite->isPersonnelDetache() ? 'Oui' : 'Non'  }}</label><br>
						<label>Personnel intérimaire : {{ $entite->isInterimaire() ? 'Oui' : 'Non' }}</label><br>
						<label>Nature de la demande : {{ $autorisation->nature }}</label><br>
						<label>Date de fin de validité : <b>{{ ($autorisation->date_fin != NULL) ? date('d/m/Y', strtotime($autorisation->date_fin)) : "-" }}</b></label>
						<label>Date de fin d' invalidité : <b>{{ ($autorisation->date_fin_invalidite != NULL) ? date('d/m/Y', strtotime($autorisation->date_fin_invalidite)) : "-" }}</b></label>
					</div>
					<div class="kt-separator kt-separator--border-dashed kt-separator--space-lg"></div>
					<div class="form-group" id="info_cloture">
						@if($autorisation->statut != "authorized")
							<a href="#" data-toggle="modal" data-target="#kt_modal_accord"  class="btn btn-success"><i class="fa fa-check-circle"></i> Valider l'intervenant</a>
						@endif
					
						@if($autorisation->statut != "rejected")
							<a href="#" data-toggle="modal" data-target="#kt_modal_refus" type="button" onclick="annulerAutorisation({{ $autorisation->id }})" class="btn btn-danger"><i class="fa fa-times-circle"></i> Refuser l'intervenant</a>
						@endif
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
							Informations
						</h3>
					</div>
				</div>
				<div class="card-body">
					<!--begin::Form-->
					<div class="form-group">
						<textarea name="informations" id="memo" rows="5" onkeyup="$('#save_memo').show();" class="form-control">{{ $autorisation->informations }}</textarea>
						<br><button type="button" onclick="saveInformation({{ $autorisation->id }})" id="save_memo" class="btn btn-info btn-sm" style="display:none;"><i class="fa fa-save"></i> Enregistrer</button>
					</div>
				</div>
			</div>

			<!--end:: Widgets/New Users-->
		</div>
	</div>
	
	<div class="row">
		<div class="col-md-4">
			<div class="card card-custom">
				<div class="card-header">
					<div class="card-title">
						<h3>
							Chantiers
						</h3>
					</div>
				</div>
				<div class="card-body">
					@foreach($chantiers as $chantier)
						{{ $chantier->numero }}<br>
					@endforeach
				</div>
			</div>
		</div>
		
		<div class="col-md-8">
			<div class="card card-custom">
			<div class="card-body">
				<!--begin::Form-->
				<form class="kt-form" method="POST" action="/chantier/saveattributs">
					<input type="hidden" name="id" value="{{ $autorisation->id }}" />
					{{ csrf_field() }}
					<div class="card-body">
						<div class="kt-section kt-section--first">
							@if(in_array('enquete_administrative', $oblig5))
								<div class="form-group row">
									<label class="col-4 col-form-label">Enquête administrative :</label>
									<div class="col-3">
										<div class="kt-radio-list">
											<label class="kt-radio">
												<input type="radio" {{ ($autorisation->enquete_administrative == 0) ? 'checked' : '' }} name="enquete_administrative" value="0"> En attente
												<span></span>
											</label>
											<label class="kt-radio">
												<input type="radio" {{ ($autorisation->enquete_administrative == 1) ? 'checked' : '' }} name="enquete_administrative" value="1"> Valide
												<span></span>
											</label>
											<label class="kt-radio">
												<input type="radio" {{ ($autorisation->enquete_administrative == 2) ? 'checked' : '' }} name="enquete_administrative" value="2"> Refusée
												<span></span>
											</label>
										</div>
									</div>
									<div class="col-4">
										<input type="date" name="date_ea" value="{{ ($autorisation->date_ea != NULL) ? date('Y-m-d', strtotime($autorisation->date_ea)) : '' }}" class="form-control" />
									</div>
								</div>
							@endif
							
							@if(in_array('enquete_interne', $oblig5))
								<div class="form-group row">
									<label class="col-4 col-form-label">Enquête interne :</label>
									<div class="col-3">
										<div class="kt-radio-list">
											<label class="kt-radio">
												<input type="radio" {{ ($autorisation->enquete_interne == 0) ? 'checked' : '' }} name="enquete_interne" value="0"> En attente
												<span></span>
											</label>
											<label class="kt-radio">
												<input type="radio" {{ ($autorisation->enquete_interne == 1) ? 'checked' : '' }} name="enquete_interne" value="1"> Valide
												<span></span>
											</label>
											<label class="kt-radio">
												<input type="radio" {{ ($autorisation->enquete_interne == 2) ? 'checked' : '' }} name="enquete_interne" value="2"> Refusée
												<span></span>
											</label>
										</div>
									</div>
									<div class="col-4">
										<input type="date" name="date_ei" value="{{ ($autorisation->date_ei != NULL) ? date('Y-m-d', strtotime($autorisation->date_ei)) : '' }}" class="form-control" />
									</div>
								</div>				
							@endif
							
							@if(in_array('avis_interne', $oblig5))
								<div class="form-group row">
									<label class="col-4 col-form-label">Avis interne :</label>
									<div class="col-3">
										<div class="kt-radio-list">
											<label class="kt-radio">
												<input type="radio" {{ ($autorisation->avis_interne == 0) ? 'checked' : '' }} name="avis_interne" value="0"> En attente
												<span></span>
											</label>
											<label class="kt-radio">
												<input type="radio" {{ ($autorisation->avis_interne == 1) ? 'checked' : '' }} name="avis_interne" value="1"> Valide
												<span></span>
											</label>
											<label class="kt-radio">
												<input type="radio" {{ ($autorisation->avis_interne == 2) ? 'checked' : '' }} name="avis_interne" value="2"> Refusée
												<span></span>
											</label>
										</div>
									</div>
									<div class="col-4">
										<input type="date" name="date_ai" value="{{ ($autorisation->date_ai != NULL) ? date('Y-m-d', strtotime($autorisation->date_ai)) : '' }}" class="form-control" />
									</div>
								</div>
							@endif
							
							<div class="form-group" id="info_cloture">
								<button type="submit" class="btn btn-info">Valider</button>
							</div>
						</div>
					</div>
				</form>
			</div>
			</div>
		</div>
	</div>
	
	<div class="row">
		<div class="col-md-4">
			<div class="card card-custom">
				<div class="card-header">
					<div class="card-title">
						<h3>
							Pièces
						</h3>
					</div>
				</div>
				<div class="card-body">
					@foreach($oblig4 as $typePiece)
						@if($entite->getMyPiece($typePiece->id, $user->societeID))
							<span>{{ $typePiece->libelle }} <a href="javascript:return false;" onclick="afficherDocument({{ $entite->getMyPiece($typePiece->id, $user->societeID) }});"><i class="fa fa-eye"></i></a></span>
						@else
							<span>{{ $typePiece->libelle }}</span>
						@endif
					@endforeach
				</div>
			</div>
		</div>

		<div class="col-md-8">
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
		</div>	
	</div>

	<!--End::Section-->
</div>
@endsection

@section('specifijs')
	<script src="{{ asset('assets/js/chantier.js') }}" type="text/javascript"></script>
@endsection