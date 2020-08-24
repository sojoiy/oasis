@extends('layout.default')

@section('content')
<!-- begin:: Content Head -->
<div class="kt-subheader   kt-grid__item" id="kt_subheader">
	<div class="kt-subheader__main">
		<h3 class="kt-subheader__title">Les types de pièces</h3>
		<span class="kt-subheader__separator kt-subheader__separator--v"></span>
		<a href="/parametres/add-type-pieces" class="btn btn-label-warning btn-bold btn-sm btn-icon-h kt-margin-l-10">
			Ajouter un type de pièces
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
				<div class="card-body">
					<div class="tab-content">
						<div class="tab-pane active" id="kt_widget4_tab1_content">
							<div class="kt-widget4">
								@foreach ($pieces as $piece)
									<div class="kt-widget4__item">
										<div class="kt-widget4__pic kt-widget4__pic--pic">
											<img src="assets/media/users/100_4.jpg" alt="">
										</div>
										<div class="kt-widget4__info">
											<a href="#" class="kt-widget4__username">
												{{ $piece->libelle }}
											</a>
										</div>
										<a href="/parametres/fichepiece/{{ $piece->id }}" class="btn btn-sm btn-label-brand btn-bold">Voir</a>&nbsp;
										<a href="/parametres/deletepiece/{{ $piece->id }}" class="btn btn-sm btn-danger btn-bold">Supprimer</a>
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
