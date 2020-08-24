@extends('layout.default')

@section('content')
<!-- begin:: Content Head -->
<div class="kt-subheader   kt-grid__item" id="kt_subheader">
	<div class="kt-subheader__main">
		<h3 class="kt-subheader__title">Mes services</h3>
		<span class="kt-subheader__separator kt-subheader__separator--v"></span>
		<span class="kt-subheader__desc">{{ $user->name }}</span>
		<a href="/comptes/service/0" class="btn btn-label-info btn-bold btn-sm btn-icon-h kt-margin-l-10">
			<i class="fa fa-user"></i> Créer un service
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
		<div class="col-xl-6">
			<!--begin:: Widgets/New Users-->
			<div class="card card-custom">
				<div class="card-header">
					<div class="card-title">
						<h3>
							{{ $user->nomSociete() }}
						</h3>
					</div>
					<div class="kt-portlet__head-toolbar">
						<ul class="nav nav-tabs nav-tabs-line nav-tabs-bold nav-tabs-line-brand" role="tablist">
							<li class="nav-item">
								<a class="nav-link active" data-toggle="tab" href="#kt_widget4_tab1_content" role="tab">
									Actif
								</a>
							</li>
						</ul>
					</div>
				</div>
				<div class="card-body">
					<div class="tab-content">
						<div class="tab-pane active" id="kt_widget4_tab1_content">
							<div class="kt-widget4">
								@foreach ($services as $myService)
									<div class="kt-widget4__item">
										<div class="kt-widget4__info">
											<a href="/comptes/service/{{ $myService->id }}" class="kt-widget4__username">
												{{ $myService->libelle }}
											</a>
										</div>
										<a href="/comptes/service/{{ $myService->id }}" class="btn btn-sm btn-label-brand btn-bold">Voir</a>&nbsp;
										<a href="/comptes/deleteservice/{{ $myService->id }}" class="btn btn-sm btn-danger btn-bold">Supprimer</a>
									</div>
								@endforeach
							</div>
						</div>
					</div>
				</div>
			</div>

			<!--end:: Widgets/New Users-->
		</div>
		
		<div class="col-xl-6">
			<div class="card card-custom">
				<div class="card-header">
					<div class="card-title">
						<h3>
							@if($new)
								Nouveau service
							@else
								Modifier un service
							@endif
						</h3>
					</div>
				</div>
				<div class="card-body">
					<!--begin::Form-->
					<form class="kt-form" method="POST" action="/comptes/saveservice">
						<input type="hidden" name="id" value="{{ $service->id }}" />
						<input type="hidden" name="new" value="{{ $new }}" />
						{{ csrf_field() }}
						<div class="card-body">
							<div class="kt-section kt-section--first">
								<div class="form-group">
									<label>Libellé : *</label>
									<input type="text" name="libelle" value="{{ (!$new) ? $service->libelle : '' }}" required class="form-control" placeholder="Libellé">
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
