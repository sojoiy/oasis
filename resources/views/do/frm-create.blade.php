@extends('layout.default')

@section('content')
<!-- begin:: Content Head -->
<div class="kt-subheader   kt-grid__item" id="kt_subheader">
	<div class="kt-subheader__main">
		<h3 class="kt-subheader__title">Mes comptes</h3>
		<span class="kt-subheader__separator kt-subheader__separator--v"></span>
		<form action="/comptes" method="post">
		{{ csrf_field() }}
		<div class="kt-input-icon kt-input-icon--right kt-subheader__search">
			<input type="text" name="keywords" class="form-control" value="{{ (isset($keywords)) ? $keywords : '' }}" placeholder="Rechercher..." id="generalSearch">
			<span class="kt-input-icon__icon kt-input-icon__icon--right">
				<span><i class="fa fa-search"></i></span>
			</span>
		</div>
		</form>
		
		<a href="/comptes" class="btn btn-label-info btn-bold btn-sm btn-icon-h kt-margin-l-10">
			<i class="fa fa-arrow-left"></i> Retour
		</a>
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
							Nouveau compte
						</h3>
					</div>
				</div>
				<div class="card-body">
					<!--begin::Form-->
					<form class="kt-form" method="POST" action="/comptes/save">
						<input type="hidden" name="id" value="{{ $compte->id }}" />
						{{ csrf_field() }}
						<div class="card-body">
							<div class="kt-section kt-section--first">
								<div class="form-group">
									<label>Nom : *</label>
									<input type="text" name="nom" value="{{ $compte->nom }}" required class="form-control" placeholder="Nom">
								</div>
								<div class="form-group">
									<label>Prénom :</label>
									<input type="text" name="prenom" value="{{ $compte->prenom }}" class="form-control" placeholder="Prénom">
								</div>
								<div class="form-group">
									<label>Email : *</label>
									<input type="text" name="email" value="{{ $compte->email }}" required class="form-control" placeholder="Email">
								</div>
								<div class="form-group">
									<label>Téléphone :</label>
									<input type="text" name="telephone" value="{{ $compte->telephone }}" class="form-control" placeholder="Téléphone">
								</div>
								<div class="form-group">
									<label>Service :</label>
									<select class="form-control" name="service">
										@foreach($services as $service)
											<option value="{{ $service->id }}">{{ $service->libelle }}</option>
										@endforeach
									</select>
								</div>
								<div class="form-group">
									<label>Groupe :</label>
									<select class="form-control" name="profil">
										@foreach($profils as $profil)
											<option value="{{ $profil->id }}">{{ $profil->libelle }}</option>
										@endforeach
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