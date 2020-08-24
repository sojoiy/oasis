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
							<small>Vertically Scrolling Datatable</small>
						</h3>
					</div>
					<div class="kt-portlet__head-toolbar">
						<div class="kt-portlet__head-wrapper">
							<a href="#" class="btn btn-clean btn-icon-sm">
								<i class="fa fa-arrow-left"></i>
								Back
							</a>
							&nbsp;
							<div class="dropdown dropdown-inline">
								<button type="button" class="btn btn-brand btn-icon-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									<i class="flaticon2-plus"></i> Add New
								</button>
								<div class="dropdown-menu dropdown-menu-right">
									<ul class="kt-nav">
										<li class="kt-nav__section kt-nav__section--first">
											<span class="kt-nav__section-text">Choose an action:</span>
										</li>
										<li class="kt-nav__item">
											<a href="#" class="kt-nav__link">
												<i class="kt-nav__link-icon flaticon2-open-text-book"></i>
												<span class="kt-nav__link-text">Reservations</span>
											</a>
										</li>
										<li class="kt-nav__item">
											<a href="#" class="kt-nav__link">
												<i class="kt-nav__link-icon flaticon2-calendar-4"></i>
												<span class="kt-nav__link-text">Appointments</span>
											</a>
										</li>
										<li class="kt-nav__item">
											<a href="#" class="kt-nav__link">
												<i class="kt-nav__link-icon flaticon2-bell-alarm-symbol"></i>
												<span class="kt-nav__link-text">Reminders</span>
											</a>
										</li>
										<li class="kt-nav__item">
											<a href="#" class="kt-nav__link">
												<i class="kt-nav__link-icon flaticon2-contract"></i>
												<span class="kt-nav__link-text">Announcements</span>
											</a>
										</li>
										<li class="kt-nav__item">
											<a href="#" class="kt-nav__link">
												<i class="kt-nav__link-icon flaticon2-shopping-cart-1"></i>
												<span class="kt-nav__link-text">Orders</span>
											</a>
										</li>
										<li class="kt-nav__separator kt-nav__separator--fit">
										</li>
										<li class="kt-nav__item">
											<a href="#" class="kt-nav__link">
												<i class="kt-nav__link-icon flaticon2-rocket-1"></i>
												<span class="kt-nav__link-text">Projects</span>
											</a>
										</li>
										<li class="kt-nav__item">
											<a href="#" class="kt-nav__link">
												<i class="kt-nav__link-icon flaticon2-chat-1"></i>
												<span class="kt-nav__link-text">User Feedbacks</span>
											</a>
										</li>
									</ul>
								</div>
							</div>
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
												<label>Status:</label>
											</div>
											<div class="kt-form__control">
												<select class="form-control bootstrap-select" id="kt_form_status">
													<option value="">All</option>
													<option value="1">Pending</option>
													<option value="2">Delivered</option>
													<option value="3">Canceled</option>
													<option value="4">Success</option>
													<option value="5">Info</option>
													<option value="6">Danger</option>
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
													<option value="">All</option>
													<option value="1">Online</option>
													<option value="2">Retail</option>
													<option value="3">Direct</option>
												</select>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-xl-4 order-1 order-xl-2 kt-align-right">
								<a href="#" class="btn btn-default kt-hidden">
									<i class="la la-cart-plus"></i> New Order
								</a>
								<div class="kt-separator kt-separator--border-dashed kt-separator--space-lg d-xl-none"></div>
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
	<script src="{{ asset('assets/js/datatables/old.js') }}" type="text/javascript"></script>
@endsection