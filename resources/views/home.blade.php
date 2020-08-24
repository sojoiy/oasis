@extends('layout.default')

@section('content')

<!-- end:: Content Head -->

<!-- begin:: Content -->
	<!-- @if($message != "EMPTY" && $message != "PROROGATION_OK")
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
	
	@if($message == "PROROGATION_OK")
		<div class="alert alert-success fade show" role="alert">
			<div class="alert-icon"><i class="fa fa-exclamation-triangle"></i></div>
			<div class="alert-text">Le chantier été prorogé</div>
			<div class="alert-close">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true"><i class="fa fa-times"></i></span>
				</button>
			</div>
		</div>
	@endif -->
		
	<!--Begin::Section-->
	<!--
	<div class="row">
		<div class="col-md-6">
			<div class="card card-custom">
				<div class="card-header">
					<div class="card-title">
						<h3>
							Notifications
						</h3>
					</div>
				</div>
				<div class="card-body">
					<div class="kt-notification">
						@foreach($notifications as $notification)
							<a href="/notifications/show/{{ $notification->id }}" class="kt-notification__item">
								<div class="kt-notification__item-icon">
									<i class="fa fa-chevron-right"></i>
								</div>
								<div class="kt-notification__item-details">
									<div class="kt-notification__item-title">
										{{ $notification->message }}
									</div>
									<div class="kt-notification__item-time">
										{{ date('d/m/Y', strtotime($notification->created_at)) }}
									</div>
								</div>
							</a>
						@endforeach
					</div>
						<div class="kt-widget6__foot">
							<div class="kt-widget6__action kt-align-right">
								<a href="/notifications" class="btn btn-label-brand btn-sm btn-bold">Voir toutes les notifications</a>
							</div>
						</div>
				</div>
			</div>
		</div> -->
	<div class="row">
		<div class="col-lg-6 col-xxl-6 order-1 order-xxl-2">
			<!--begin::List Widget 4-->
			<div class="card card-custom card-stretch gutter-b">
				<!--begin::Header-->
				<div class="card-header border-0">
					<h3 class="card-title font-weight-bolder text-dark">Notifications</h3>
				
				</div>
				<!--end::Header-->
				<!--begin::Body-->
				<div class="card-body pt-2">
				<!--begin::Item-->
			
				
					@foreach($notifications as $notification)
						<div class="d-flex align-items-center">
							<!--begin::Bullet-->
							<span class="bullet bullet-bar bg-success align-self-stretch"></span>
							<!--end::Bullet-->
							<!--begin::Checkbox-->
							<label class="checkbox checkbox-lg checkbox-light-success checkbox-inline flex-shrink-0 m-0 mx-4">
								<input type="checkbox" name="select" value="1" />
								<span></span>
							</label>
							<!--end::Checkbox-->
							<!--begin::Text-->
							<div class="d-flex flex-column flex-grow-1">
								<a href="#" class="text-dark-75 text-hover-primary font-weight-bold font-size-lg mb-1">{{ $notification->message }}</a>
								<span class="text-muted font-weight-bold">{{ date('d/m/Y', strtotime($notification->created_at)) }}</span>
							</div>
						</div>
						<br>
					@endforeach
				</div>
			</div>
		</div>
			
		<div class="col-lg-6 col-xxl-4 order-1 order-xxl-2">
			<!--begin::List Widget 4-->
			<div class="card card-custom card-stretch gutter-b">
				<!--begin::Header-->
				<div class="card-header border-0">
					<h3 class="card-title font-weight-bolder text-dark">Chantiers</h3>
					<div class="card-toolbar">
						<div class="dropdown dropdown-inline">
							<a href="#" class="btn btn-light btn-sm font-size-sm font-weight-bolder dropdown-toggle text-dark-75" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Nouveau</a>
							<div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
								<!--begin::Navigation-->
								<ul class="navi navi-hover">
									<li class="navi-item">
										<a href="#" class="navi-link">
											<span class="navi-icon">
												<i class="flaticon2-shopping-cart-1"></i>
											</span>
											<span class="navi-text">Chantier</span>
										</a>
									</li>
									<li class="navi-item">
										<a href="/rdv/creer" class="navi-link">
											<span class="navi-icon">
												<i class="flaticon2-calendar-8"></i>
											</span>
											<span class="navi-text">RDV</span>
										</a>
									</li>
									<li class="navi-item">
										<a href="/livraisons/createlivraison" class="navi-link">
											<span class="navi-icon">
												<i class="flaticon2-graph-1"></i>
											</span>
											<span class="navi-text">Livraison</span>
										</a>
									</li>
								</ul>
								<!--end::Navigation-->
							</div>
						</div>
					</div>
				</div>
				<!--end::Header-->
				<!--begin::Body-->
			<div class="card-body pt-2">
				<!--begin::Item-->
				@foreach($chantiers as $chantier)
					<div class="kt-widget6__item">
						<span>[{{ date('d/m/Y', strtotime($chantier->date_fin)) }}]</span>
						<a href="/chantier/show/{{ $chantier->id }}">{{ $chantier->numero }}</a>
						- <span>{{ $chantier->nomTitulaire() }}</span>
					</div>
				@endforeach
			</div>
		</div>
	</div>
	</div>
			
			<!--
		<div class="col-md-6">
			<div class="kt-portlet kt-portlet--height-fluid" id="affichage">
				<div class="card-header">
					<div class="card-title">
						<h3>
							Derniers chantiers
						</h3>
					</div>
				</div>
				<div class="card-body">
					<div class="kt-widget6">
						<div class="kt-widget6__head">
							<div class="kt-widget6__item">
								<span>Numéro</span>
								<span>Titulaire</span>
								<span>Date création</span>
							</div>
						</div>
						<div class="kt-widget6__body">
							@foreach($chantiers as $chantier)
								<div class="kt-widget6__item">
									<span><a href="/chantier/show/{{ $chantier->id }}">{{ $chantier->numero }}</a></span>
									<span>{{ $chantier->nomTitulaire() }}</span>
									<span>{{ date('d/m/Y', strtotime($chantier->date_fin)) }}</span>
								</div>
							@endforeach
						</div>
						<div class="kt-widget6__foot">
							<div class="kt-widget6__action kt-align-right">
								<a href="/chantier/sent" class="btn btn-label-brand btn-sm btn-bold">Voir tous les dossiers</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		@if($user->validation_pieces)
		<div class="col-md-6">
			<div class="card card-custom">
				<div class="card-header">
					<div class="card-title">
						<h3>
							Pièces en attente
						</h3>
					</div>
					<div class="kt-portlet__head-toolbar">
						
					</div>
				</div>
				<div class="card-body">
					<div class="kt-widget6">
						<div class="kt-widget6__head">
							<div class="kt-widget6__item">
								<span>Type</span>
								<span>Chantier</span>
								<span>Entité</span>
								<span>Date expiration</span>
							</div>
						</div>
						<div class="kt-widget6__body">
							@foreach($pieces as $piece)
								<div class="kt-widget6__item">
									<span>{{ $piece->type_piece() }}</span>
									<span>{{ $piece->numeroChantier() }}</span>
									<span>{{ $piece->nomEntite() }}</span>
									<span>{{ $piece->date_expiration }}</span>
								</div>
							@endforeach
						</div>
						<div class="kt-widget6__foot">
							<div class="kt-widget6__action kt-align-right">
								<a href="/chantier/pieces" class="btn btn-label-brand btn-sm btn-bold">Voir toutes les pièces...</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		@endif
	</div> -->

	<!--End::Section-->
@endsection

@section('specifijs')
	<script src="{{ asset('assets/js/chantier.js') }}" type="text/javascript"></script>
@endsection