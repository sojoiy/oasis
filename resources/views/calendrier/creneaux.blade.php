@extends('layout.default')

@section('content')
<!-- begin:: Content Head -->
<div class="kt-subheader   kt-grid__item" id="kt_subheader">
	<div class="kt-subheader__main">
		<h3 class="kt-subheader__title">Planning</h3>
		<span class="kt-subheader__separator kt-subheader__separator--v"></span>
		<span class="kt-subheader__desc">{{ $user->name }}</span>
		<a href="/comptes/creneau/0" class="btn btn-label-info btn-bold btn-sm btn-icon-h kt-margin-l-10">
			<i class="fa fa-user"></i> Créer un nouveau créneau
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
							Planning ({{ $user->nomSociete() }})
						</h3>
					</div>
				</div>
				<div class="card-body">
					<div class="tab-content">
						<div class="tab-pane active" id="kt_widget4_tab1_content">
							<div class="kt-widget4">
								@foreach ($creneaux as $myCreneau)
									<div class="kt-widget4__item">
										<div class="kt-widget4__info">
											<a href="/comptes/creneau/{{ $myCreneau->id }}" class="kt-widget4__username">
												{{ date('d/m/Y H:i', strtotime($myCreneau->date_debut)) }} à {{ date('H:i', strtotime($myCreneau->date_debut."+".$myCreneau->duree."minutes")) }}
											</a>
										</div>
										<a href="/calendrier/creneau/{{ $myCreneau->id }}" class="btn btn-sm btn-label-brand btn-bold">Voir</a>&nbsp;
										<a href="/calendrier/deletecreneau/{{ $myCreneau->id }}" class="btn btn-sm btn-danger btn-bold">Supprimer</a>
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
								Nouveau creneau
							@else
								Modifier un creneau
							@endif
						</h3>
					</div>
				</div>
				<div class="card-body">
					<!--begin::Form-->
					<form class="kt-form" method="POST" action="/calendrier/savecreneau">
						<input type="hidden" name="id" value="{{ $creneau->id }}" />
						<input type="hidden" name="new" value="{{ $new }}" />
						{{ csrf_field() }}
						<div class="card-body">
							<div class="kt-section kt-section--first">
								<div class="form-group">
									<label>Date début : *</label>
									<input class="form-control" name="date_debut" type="datetime-local" required value="{{ (!$new) ? str_replace(' ', 'T', $creneau->date_debut) : '' }}" id="example-datetime-local-input" >
								</div>
							</div>
							
							<div class="kt-section kt-section--first">
								<div class="form-group">
									<label>Durée : *</label>
									<input type="text" name="duree" value="{{ (!$new) ? $creneau->duree : '' }}" required class="form-control" placeholder="Durée">
								</div>
							</div>
							
							<div class="kt-section kt-section--first">
								<div class="form-group">
									<label>Nombre places : *</label>
									<input type="text" name="nombre_places" value="{{ (!$new) ? $creneau->nombre_places : '' }}" required class="form-control" placeholder="Places">
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
