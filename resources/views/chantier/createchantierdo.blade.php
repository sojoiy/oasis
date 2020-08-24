@extends('layout.default')

@section('content')
<!-- begin:: Content Head -->
<div class="kt-subheader   kt-grid__item" id="kt_subheader">
	<div class="kt-subheader__main">
		<h3 class="kt-subheader__title">Nouveau chantier</h3>
		<span class="kt-subheader__separator kt-subheader__separator--v"></span>
		<a href="/chantier/do" class="btn btn-label-warning btn-bold btn-sm btn-icon-h kt-margin-l-10">
			Liste des chantiers
		</a>
		<div class="kt-input-icon kt-input-icon--right kt-subheader__search kt-hidden">
			<input type="text" class="form-control" placeholder="Search order..." id="generalSearch">
			<span class="kt-input-icon__icon kt-input-icon__icon--right">
				<span><i class="flaticon2-search-1"></i></span>
			</span>
		</div>
	</div>
	<div class="kt-subheader__toolbar">
		
	</div>
</div>

<!-- end:: Content Head -->

<!-- begin:: Content -->
<div class="card card-custom">
	@if($message == "ITEM_EXISTS")
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
	
	@if($message == "DATE_ERROR")
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
	
	<!--Begin::Section-->
	<div class="row">
		<div class="col-xl-12">

			<!--begin:: Widgets/New Users-->
			<div class="card card-custom">
				<div class="card-header">
					<div class="card-title">
						<h3>
							Créer un chantier
						</h3>
					</div>
				</div>
				<div class="card-body">
					<!--begin::Form-->
					<form class="kt-form" method="POST" action="/chantier/savechantierdo">
						<input type="hidden" name="type_chantier" value="2" />
						{{ csrf_field() }}
						<div class="card-body">
							<div class="kt-section kt-section--first">
								<div class="form-group">
									<label>Numéro : *</label>
									<input type="text" name="numero" required class="form-control" value="{{ $infos['numero'] }}" placeholder="Numéro">
								</div>

								<div class="form-group">
									<label>Libellé :</label>
									<input type="text" name="libelle" class="form-control" value="{{ $infos['libelle'] }}" placeholder="libellé">
								</div>

								<div class="form-group">
									<label>Ressource :</label>
									<select name="ressource" class="form-control chosen">
										@foreach($lesRessources as $ressource)
											<option value="{{ $ressource->id }}">{{ $ressource->name }}</option>
										@endforeach
									</select>
								</div>
								
								<div class="form-group">
									<label>Date de début :</label>
									<input class="form-control" type="date" name="date_debut" value="{{ $infos['date_debut'] }}" id="example-date-input">
								</div>
								
								<div class="form-group">
									<label>Date de fin :</label>
									<input class="form-control" type="date" name="date_fin" value="{{ $infos['date_fin'] }}" id="example-date-input">
								</div>
								
								<!-- <div class="form-group">
									<label>Validation des entités ?</label>
									<div class="kt-radio-inline">
										<label class="kt-radio">
											<input type="radio" name="validation_entite" checked value="1"> Oui
											<span></span>
										</label>
										<label class="kt-radio">
											<input type="radio" name="validation_entite" value="0"> Non
											<span></span>
										</label>
									</div>
									<span class="form-text text-muted">Some help text goes here</span>
								</div>
								
								<div class="form-group">
									<label>Prise de Rendez-vous ?</label>
									<div class="kt-radio-inline">
										<label class="kt-radio">
											<input type="radio" name="validation_rdv" checked value="1"> Oui
											<span></span>
										</label>
										<label class="kt-radio">
											<input type="radio" name="validation_rdv" value="0"> Non
											<span></span>
										</label>
									</div>
									<span class="form-text text-muted">Some help text goes here</span>
								</div> -->
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
