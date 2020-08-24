@extends('layout.default')

@section('content')
<!-- begin:: Content Head -->
<div class="kt-subheader   kt-grid__item" id="kt_subheader">
	<div class="kt-subheader__main">
		<h3 class="kt-subheader__title">Ajouter un intervenant</h3>
		<span class="kt-subheader__separator kt-subheader__separator--v"></span>
		<span class="kt-subheader__desc">{{ $user->name }}</span>
		<a href="/intervenants" class="btn btn-label-warning btn-bold btn-sm btn-icon-h kt-margin-l-10">
			Liste des types de pièces
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
	<!--Begin::Section-->
	<div class="row">
		<div class="col-xl-12">

			<!--begin:: Widgets/New Users-->
			<div class="card card-custom">
				<div class="card-header">
					<div class="card-title">
						<h3>
							Ajouter un type de pièces
						</h3>
					</div>
				</div>
				<div class="card-body">
					<!--begin::Form-->
					<form class="kt-form" method="POST" action="/parametres/savechantiers">
						{{ csrf_field() }}
						<div class="card-body">
							<div class="kt-section kt-section--first">
								<div class="form-group">
									<label>Libellé : *</label>
									<input type="text" name="libelle" required class="form-control" placeholder="Libellé">
								</div>
								<div class="form-group">
									<label>Abbréviation :</label>
									<input type="text" name="abbreviation" class="form-control" placeholder="Abbréviation">
								</div>
								<div class="form-group">
									<label>Pièces obligatoires :</label>
										<select name="obligatoire[]" class="form-control selectpicker" multiple>
											@foreach($pieces as $piece)
											<option value="{{$piece->id}}">{{ $piece->libelle }}</option>
											@endforeach
										</select>
								</div>
								<div class="form-group">
									<label>Pièces optionnelles :</label>
										<select name="optionnelles[]" class="form-control selectpicker" multiple>
											@foreach($pieces as $piece)
											<option value="{{$piece->id}}">{{ $piece->libelle }}</option>
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
