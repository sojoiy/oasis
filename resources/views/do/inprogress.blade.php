@extends('layout.default')

@section('content')
<!-- begin:: Content Head -->
<div class="kt-subheader   kt-grid__item" id="kt_subheader">
	<div class="kt-subheader__main">
		<h3 class="kt-subheader__title">{{ $user->name }}</h3>
		<span class="kt-subheader__separator kt-subheader__separator--v"></span>
	</div>
	<div class="kt-subheader__toolbar">
		{{ $user->nomSociete() }}
	</div>
</div>

<!-- end:: Content Head -->

<!-- begin:: Content -->
					
					
<div class="card card-custom">
	<!--Begin::Section-->
	<div class="row">
			<div class="card card-custom">
				<div class="card-header">
					<div class="card-title">
						<h3>
							Recherche 
						</h3>
					</div>
				</div>
				<div class="card-body">
					<!--begin::Form-->
					<form class="kt-form" action="/search" method="post">
						{{ csrf_field() }}
						<div class="form-group">
							<div class="form-group row">
								<label class="col-xl-3 col-lg-3 col-form-label">Mot-clé</label>
								<div class="col-lg-9 col-xl-9">
									<div class="input-group">
										<div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-search"></i></span></div>
										<input type="text" class="form-control" name="keywords" value="{{ $keywords }}" placeholder="Chantier, Intervenant, Visiteur, ..." aria-describedby="basic-addon1">
									</div>
								</div>
							</div>
						
							<div class="form-group row">
								<label class="col-xl-3 col-lg-3 col-form-label"></label>
								<div class="col-lg-9 col-xl-9">
									<button type="submit" class="btn btn-success">Lancer la recherche</button>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
			

			<!--end:: Widgets/New Users-->
	</div>
	
	<div class="row">
		<div class="kt-portlet kt-portlet--height-fluid" id="affichage">
			<!-- begin:: Content -->
			<div class="kt-portlet kt-portlet--mobile">
				<div class="kt-portlet__head kt-portlet__head--lg">
					<div class="card-title">
						<span class="kt-portlet__head-icon">
							<i class="kt-font-brand flaticon2-line-chart"></i>
						</span>
						<h3>
							Résultats
						</h3>
					</div>
					<div class="kt-portlet__head-toolbar">
						<div class="kt-portlet__head-wrapper">
							
						</div>
					</div>
				</div>
				<div class="card-body">

					<!--begin: Search Form -->
					<div class="kt-form kt-form--label-right kt-margin-t-20 kt-margin-b-10">
						<div class="row align-items-center">
							<div class="col-xl-8 order-2 order-xl-1">
								<div class="row align-items-center">
									<div class="col-md-4 kt-margin-b-20-tablet-and-mobile">
										<div class="kt-form__group kt-form__group--inline">
											<div class="kt-form__label">
												<label>Statut:</label>
											</div>
											<div class="kt-form__control">
												<select class="form-control bootstrap-select" id="kt_form_status">
													<option value="">Tous</option>
													<option value="1">A venir</option>
													<option value="1">En cours</option>
													<option value="2">Terminés</option>
												</select>
											</div>
										</div>
									</div>
									<div class="col-md-4 kt-margin-b-20-tablet-and-mobile">
										<div class="kt-form__group kt-form__group--inline">
											<div class="kt-form__label">
												<label>Type:</label>
											</div>
											<div class="kt-form__control">
												<select class="form-control bootstrap-select" id="kt_form_type">
													<option value="">Tous</option>
													<option value="1">Prestation</option>
												</select>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<!--end: Search Form -->
				</div>
				
				<div class="kt-portlet__body kt-portlet__body--fit">

					<!--begin: Datatable -->
					<div class="kt-datatable" id="scrolling_vertical"></div>
					<!--end: Datatable -->
				</div>
			</div>
		</div>
	</div>

	<!--End::Section-->
</div>
@endsection

@section('specifijs')
	<script src="{{ asset('assets/js/chantier.js') }}" type="text/javascript"></script>
	<script src="{{ asset('assets/js/datatables/inprogress.js') }}" type="text/javascript"></script>
@endsection