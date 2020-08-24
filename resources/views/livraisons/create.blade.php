@extends('layout.default')

@section('content')
<!-- begin:: Content Head -->
<div class="kt-subheader   kt-grid__item" id="kt_subheader">
	<div class="kt-subheader__main">
		<h3 class="kt-subheader__title">Nouveau chantier</h3>
		<span class="kt-subheader__separator kt-subheader__separator--v"></span>
		<a href="/livraisons/lister" class="btn btn-label-warning btn-bold btn-sm btn-icon-h kt-margin-l-10">
			Liste des livraisons
		</a>
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
				<div class="card-body">
					<!--begin::Form-->
					<form class="kt-form" method="POST" action="/livraisons/save">
						{{ csrf_field() }}
						<div class="card-body">
							<div class="kt-section kt-section--first">
								@if($user->do == 1)
									<div class="form-group">
										<label>Type de chantier : *</label>
										<select name="typeChantier" required onchange="refreshValideurs(this.value)" class="form-control">
											@foreach($typeChantiers as $typeChantier)
												<option value="{{ $typeChantier->id }}">{{ $typeChantier->id }} {{ $typeChantier->libelle }}</option>
											@endforeach
										</select>
									</div>
								@else
									<input type="hidden" name="type_chantier" value="0" />
								@endif
								
								<div class="form-group">
									<label>Numéro : *</label>
									<input type="text" name="numero" required class="form-control" value="{{ $infos['numero'] }}" placeholder="Numéro">
								</div>

								<div class="form-group">
									<label>Libellé :</label>
									<input type="text" name="libelle" class="form-control" value="{{ $infos['libelle'] }}" placeholder="libellé">
								</div>
								
								<div class="form-group">
									<label>Date : *</label>
									<input class="form-control" type="date" required name="date_livraison" value="{{ $infos['date_livraison'] }}" id="example-date-input">
								</div>
								
								<div class="form-group">
									<label>Récurrence :</label>
									<select name="recurrence" class="form-control">
										<option value="">Aucune</option>
										<option value="hebdomadaire">Hebdomadaire</option>
										<option value="mensuel">Mensuelle</option>
										<option value="annuel">Annuelle</option>
									</select>
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
	</div>

	<!--End::Section-->
</div>
@endsection

@section('specifijs')
	<script src="{{ asset('assets/js/chantier.js') }}" type="text/javascript"></script>
@endsection