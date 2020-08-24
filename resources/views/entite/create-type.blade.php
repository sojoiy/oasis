@extends('layout.default')

@section('content')
<!-- begin:: Content Head -->
<div class="kt-subheader   kt-grid__item" id="kt_subheader">
	<div class="kt-subheader__main">
		<h3 class="kt-subheader__title">Mes Ressources</h3>
		<span class="kt-subheader__separator kt-subheader__separator--v"></span>
		
		<form action="/entite/listertypes" method="post">
		{{ csrf_field() }}
		<div class="kt-input-icon kt-input-icon--right kt-subheader__search">
			<input type="text" name="keywords" class="form-control" value="{{ (isset($keywords)) ? $keywords : '' }}" placeholder="Rechercher..." id="generalSearch">
			<span class="kt-input-icon__icon kt-input-icon__icon--right">
				<span><i class="fa fa-search"></i></span>
			</span>
		</div>
		</form>
		
		<a href="/entite/listertypes" class="btn btn-label-info active btn-bold btn-sm btn-icon-h kt-margin-l-5">
			<i class="fa fa-arrow-left"></i> Retour
		</a>
	</div>
	<div class="kt-subheader__toolbar">
		
	</div>
</div>

<!-- end:: Content Head -->

<!-- begin:: Content -->
<div class="card card-custom">
	@if($message != "EMPTY")
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
	
	<!--end::Modal-->
	
	<!--Begin::Section-->
	<div class="row">
		<div class="col-md-12">
			<!--begin:: Widgets/New Users-->
			<div class="card card-custom">
				<div class="card-header">
					<div class="card-title">
						<h3>
							Nouvelle entité
						</h3>
					</div>
				</div>
				<div class="card-body">
					<!--begin::Form-->
					<form class="kt-form" method="POST" action="/entite/ajoutertype">
						{{ csrf_field() }}
						<div class="card-body">
							<div class="kt-section kt-section--first">
								<div class="form-group">
									<label>Nom : *</label>
									<input type="text" name="libelle" value="" required class="form-control" placeholder="Libellé">
								</div>
								<div class="form-group">
									<label>Champ 1 :</label>
									<input type="text" name="champ1" value="" class="form-control" placeholder="Libellé">
									<select class="form-control" name="type_champs1">
										<option value="texte">Texte</option>
										<option value="date">Date</option>
										<option value="email">Email</option>
									</select>
								</div>
								
								<div class="form-group">
									<label>Champ 2 :</label>
									<input type="text" name="champ2" value="" class="form-control" placeholder="Libellé">
									<select class="form-control" name="type_champs2">
										<option value="texte">Texte</option>
										<option value="date">Date</option>
										<option value="email">Email</option>
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
	<script src="{{ asset('assets/js/do.js') }}" type="text/javascript"></script>
@endsection