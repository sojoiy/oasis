@extends('layout.default')

@section('content')
<!-- begin:: Content Head -->
<div class="kt-subheader   kt-grid__item" id="kt_subheader">
	<div class="kt-subheader__main">
		<h3 class="kt-subheader__title">Mes véhicules</h3>
		<span class="kt-subheader__separator kt-subheader__separator--v"></span>
		<span class="kt-subheader__desc">{{ $user->name }}</span>
		<a href="/add-vehicule" class="btn btn-label-warning btn-bold btn-sm btn-icon-h kt-margin-l-10">
			Ajouter un véhicule
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
							<li class="nav-item">
								<a class="nav-link" data-toggle="tab" href="#kt_widget4_tab2_content" role="tab">
									Supprimés
								</a>
							</li>
						</ul>
					</div>
				</div>
				<div class="card-body">
					<div class="tab-content">
						<div class="tab-pane active" id="kt_widget4_tab1_content">
							<div class="kt-widget4">
								@foreach ($entites as $entite)
									<div class="kt-widget4__item">
										<div class="kt-widget4__info">
											<a href="/intervenant/show/{{ $entite->id }}" class="kt-widget4__username">
												{{ $entite->name }}
											</a>
											<p class="kt-widget4__text">
												{{ $entite->type_vehicule }} - {{ $entite->marque }} {{ $entite->modele }}
											</p>
										</div>
										<a href="/vehicule/show/{{ $entite->id }}" class="btn btn-sm btn-label-brand btn-bold">Voir</a>&nbsp;
										<a href="/vehicule/delete/{{ $entite->id }}" class="btn btn-sm btn-danger btn-bold">Supprimer</a>
									</div>
								@endforeach
							</div>
						</div>
						
						<div class="tab-pane" id="kt_widget4_tab2_content">
							<div class="kt-widget4">
								@foreach ($deleted_entites as $entite)
									<div class="kt-widget4__item">
										<div class="kt-widget4__pic kt-widget4__pic--pic">
											<img src="assets/media/users/100_4.jpg" alt="">
										</div>
										<div class="kt-widget4__info">
											<a href="#" class="kt-widget4__username">
												{{ $entite->name }}
											</a>
											<p class="kt-widget4__text">
												Visual Designer,Google Inc
											</p>
										</div>
										<a href="/intervenant/restore/{{ $entite->id }}" class="btn btn-sm btn-label-brand btn-bold">Restaurer</a>
									</div>
								@endforeach
							</div>
						</div>
					</div>
				</div>
			</div>

			<!--end:: Widgets/New Users-->
		</div>
	</div>
	<!--End::Dashboard 1-->
</div>
<!--End::Section-->
@endsection
