@extends('layout.default')

@section('content')
<!-- begin:: Content Head -->
<div class="kt-subheader   kt-grid__item" id="kt_subheader">
	<div class="kt-subheader__main">
		<h3 class="kt-subheader__title">Les types d'habilitations</h3>
		<span class="kt-subheader__separator kt-subheader__separator--v"></span>
		<a href="/parametres/add-habilitation" class="btn btn-label-warning btn-bold btn-sm btn-icon-h kt-margin-l-10">
			<i class="fa fa-plus"></i> Ajouter une habilitation
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
		<div class="col-xl-12">

			<!--begin:: Widgets/New Users-->
			<div class="card card-custom">
				<div class="card-body">
					<div class="tab-content">
						<div class="tab-pane active" id="kt_widget4_tab1_content">
							<div class="kt-widget4">
								@foreach ($habilitations as $habilitation)
									<div class="kt-widget4__item">
										<div class="kt-widget4__info">
											<a href="#" class="kt-widget4__username">
												{{ $habilitation->libelle }}
											</a>
										</div>
										<a href="/parametres/fichehabilitation/{{ $habilitation->id }}" class="btn btn-sm btn-label-brand btn-bold">Voir</a>&nbsp;
										<a href="/parametres/deletehabilitation/{{ $habilitation->id }}" class="btn btn-sm btn-danger btn-bold">Supprimer</a>
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
