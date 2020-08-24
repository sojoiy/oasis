@extends('layout.default')

@section('content')
<!-- begin:: Content Head -->
<div class="kt-subheader   kt-grid__item" id="kt_subheader">
	<div class="kt-subheader__main">
		<h3 class="kt-subheader__title">Jour de fermeture</h3>
		<span class="kt-subheader__separator kt-subheader__separator--v"></span>
		<span class="kt-subheader__desc">{{ $user->name }}</span>
		<a href="/comptes/fermeture/0" class="btn btn-label-info btn-bold btn-sm btn-icon-h kt-margin-l-10">
			<i class="fa fa-user"></i> Créer une fermeture
		</a>
	</div>
	<div class="kt-subheader__toolbar">
		
	</div>
</div>

<!-- end:: Content Head -->

<!-- begin:: Content -->
<div class="card card-custom">
								
	<!--Begin::Section-->
	<div class="row">
		<div class="col-xl-6 col-md-6">
			<!--begin:: Widgets/New Users-->
			<div class="card card-custom">
				<div class="card-header">
					<div class="card-title">
						<h3>
							Les jours de fermeture ({{ $user->nomSociete() }})
						</h3>
					</div>
				</div>
				<div class="card-body">
					<div class="tab-content">
						<div class="tab-pane active" id="kt_widget4_tab1_content">
							<div class="kt-widget4">
								@foreach ($fermetures as $myFermeture)
									<div class="kt-widget4__item">
										<div class="kt-widget4__info">
											<a href="/comptes/fermeture/{{ $myFermeture->id }}" class="kt-widget4__username">
												{{ $myFermeture->libelle }}
											</a>
										</div>
										<a href="/calendrier/fermeture/{{ $myFermeture->id }}" class="btn btn-sm btn-label-brand btn-bold">Voir</a>&nbsp;
										<a href="/calendrier/deletefermeture/{{ $myFermeture->id }}" class="btn btn-sm btn-danger btn-bold">Supprimer</a>
									</div>
								@endforeach
							</div>
						</div>
					</div>
				</div>
			</div>

			<!--end:: Widgets/New Users-->
		</div>
		
		<div class="col-xl-6 col-md-6">
			<div class="card card-custom">
				<div class="card-header">
					<div class="card-title">
						<h3>
							@if($new)
								Nouvelle fermeture
							@else
								Modifier une fermeture
							@endif
						</h3>
					</div>
				</div>
				<div class="card-body">
					<!--begin::Form-->
					<form class="kt-form" method="POST" action="/calendrier/savefermeture">
						<input type="hidden" name="id" value="{{ $fermeture->id }}" />
						<input type="hidden" name="new" value="{{ $new }}" />
						{{ csrf_field() }}
						<div class="card-body">
							<div class="kt-section kt-section--first">
								<div class="form-group">
									<label>Libellé : *</label>
									<input type="text" name="libelle" value="{{ (!$new) ? $fermeture->libelle : '' }}" required class="form-control" placeholder="Libellé">
								</div>
							</div>
							
							<div class="kt-section kt-section--first">
								<div class="form-group">
									<label>Commentaire : *</label>
									<input type="text" name="commentaire" value="{{ (!$new) ? $fermeture->commentaire : '' }}"  class="form-control" placeholder="Commentaire">
								</div>
							</div>
							
							<div class="kt-section kt-section--first">
								<div class="form-group">
									<label>Date début : *</label>
									<input class="form-control" name="date_debut" type="date" value="{{ (!$new) ? $fermeture->date_debut : '' }}" id="example-date-input">
								</div>
							</div>
							
							<div class="kt-section kt-section--first">
								<div class="form-group">
									<label>Date fin : *</label>
									<input class="form-control" name="date_fin" type="date" value="{{ (!$new) ? $fermeture->date_fin : '' }}" id="example-date-input">
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
		</div>	
	</div>
	<!--End::Dashboard 1-->
</div>
<!--End::Section-->
@endsection
