@extends('layout.default')

@section('content')

<!-- end:: Content Head -->
@include('chantier.modal_prorogation', ['chantier' => $chantier])

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
						<div class="form-group">
							<label>Numéro : {{ $chantier->numero }}</label><br>
							<label>DO : {{ $chantier->nomDo() }}</label><br>
							<label>Date de début : {{ date('d/m/Y', strtotime($chantier->date_debut)) }}</label><br>
							<label>Date de fin : {{ date('d/m/Y', strtotime($chantier->date_fin)) }}</label>
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
					<form class="kt-form" method="POST" action="/chantier/ajouterpiece" enctype="multipart/form-data">
					<input type="hidden" name="chantier" value="{{ $chantier->id }}" />
					<div class="card-body">
						<!--begin::Form-->
						{{ csrf_field() }}
						<div class="form-group row">
							<label class="col-form-label col-lg-3 col-sm-12">Intervenant</label>
							<div class=" col-lg-8 col-md-9 col-sm-12">
								<select onchange="selectionnerEquipier(this.value, {{ $chantier->id }})" name="entite" class="form-control selectpicker">
									@if(sizeof($equipe))
										<optgroup label="Intervenants" data-max-options="2">
											@foreach($equipe as $entite)
												<option value="{{ $entite->id }}">{{ $entite->name() }} {{ $entite->prenom }}</option>
											@endforeach
										</optgroup>
									@endif
									
									@if(sizeof($equipe_int))
										<optgroup label="Intérimaires" data-max-options="2">
											@foreach($equipe_int as $entite)
												<option value="{{ $entite->id }}">{{ $entite->name() }} {{ $entite->prenom }}</option>
											@endforeach
										</optgroup>
									@endif
									
									@if(sizeof($st_int))
										<optgroup label="ST Intérimaires" data-max-options="2">
											@foreach($st_int as  $entite)
												<option value="{{ $entite->id }}">{{ $entite->name() }} {{ $entite->prenom }}</option>
											@endforeach
										</optgroup>
									@endif
									
									@if(sizeof($equipe_etr))
										<optgroup label="Etrangers" data-max-options="2">
											@foreach($equipe_etr as $entite)
												<option value="{{ $entite->id }}">{{ $entite->name() }} {{ $entite->prenom }}</option>
											@endforeach
										</optgroup>
									@endif
								</select>
							</div>
						</div>
				
						<div class="form-group row">
							<label class="col-form-label col-lg-3 col-sm-12">Documents</label>
							<div class="col-lg-8 col-md-9 col-sm-12" id="zoneTypePiece">
								<select name="type_piece" class="form-control selectpicker">
									@foreach($chantier->pieces_chantier($categorie) as $piece)
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
	<br>
	<div class="row">
		<div class="col-md-12">
			<div class="card card-custom">
				<div class="card-header">
					<div class="card-title">
						<h3 class="card-label">L'équipe de ce chantier
					</div>
				</div>
				<div class="card-body">
					<div class="kt-section">
						@if($chantier->do <> $user->societeID)
							<div class="kt-section__info">
								Constituez ici l'équipe pour le chantier <code>{{ $chantier->libelle }}</code>.
								<select class="form-control" onchange="ajouterEquipier({{ $chantier->id }}, this.value)" id="selectEquipier" name="equipier">
									<option value="0">-- Ajouter un membre --</option>
									@foreach($remplacants as $entite)
										<option id="ligneEntite_{{ $entite->id }}" value="{{ $entite->id }}">{{ $entite->name }}</option>
									@endforeach
								</select>
							</div>
						@endif
						
						<div class="kt-section__content">
							<div class="table-responsive" id="equipe_chantier">
								@include('chantier.equipe', ['equipe' => $equipe, 'equipe_int' => $equipe_int, 'equipe_etr' => $equipe_etr])
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>	s
@endsection

@section('specifijs')
	<script src="{{ asset('assets/js/chantier.js') }}" type="text/javascript"></script>
@endsection