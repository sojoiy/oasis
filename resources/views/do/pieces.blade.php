@extends('layout.default')

@section('content')
<!-- begin:: Content Head -->
<div class="kt-subheader   kt-grid__item" id="kt_subheader">
	<div class="kt-subheader__main">
		<h3 class="kt-subheader__title">Pièces obligatoires</h3>
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
	<div class="row">
	<!--Begin::Section-->
		<div class="col-xl-4">

			<!--begin:: Widgets/New Users-->
			<div class="card card-custom">
				<div class="card-header">
					<div class="card-title">
						<h3>
							Intervenants
						</h3>
					</div>
				</div>
				<div class="card-body">
					<!--begin::Form-->
					<form class="kt-form" method="POST" action="/parametres/savetypepiece">
						{{ csrf_field() }}
						<div class="card-body">
							<div class="kt-section kt-section--first">
								@foreach($typePieces as $typePiece)
									<div class="form-group row">
										<label class="col-8 col-form-label">{{ $typePiece->libelle }} :</label>
										<div class="col-3">
											<span class="kt-switch">
												<label>
													<input type="checkbox" {{ (in_array($typePiece->id, $oblig)) ? 'checked' : '' }} onchange="savePiece({{ $typePiece->id }}, 'intervenants')" name="intervenant" />
													<span></span>
												</label>
											</span>
										</div>
									</div>
								@endforeach
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
		
		<div class="col-xl-4">	
			<!--begin:: Widgets/New Users-->
			<div class="card card-custom">
				<div class="card-header">
					<div class="card-title">
						<h3>
							Intérim
						</h3>
					</div>
				</div>
				<div class="card-body">
					<!--begin::Form-->
					<form class="kt-form" method="POST" action="/parametres/savetypepiece">
						{{ csrf_field() }}
						<div class="card-body">
							<div class="kt-section kt-section--first">
								@foreach($typePieces2 as $typePiece)
									<div class="form-group row">
										<label class="col-8 col-form-label">{{ $typePiece->libelle }} :</label>
										<div class="col-3">
											<span class="kt-switch">
												<label>
													<input type="checkbox" {{ (in_array($typePiece->id, $oblig2)) ? 'checked' : '' }} onchange="savePiece({{ $typePiece->id }}, 'interims')" name="intervenant" />
													<span></span>
												</label>
											</span>
										</div>
									</div>
								@endforeach
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
		
		<div class="col-xl-4">	
			<!--begin:: Widgets/New Users-->
			<div class="card card-custom">
				<div class="card-header">
					<div class="card-title">
						<h3>
							Travailleurs détachés
						</h3>
					</div>
				</div>
				<div class="card-body">
					<!--begin::Form-->
					<form class="kt-form" method="POST" action="/parametres/savetypepiece">
						{{ csrf_field() }}
						<div class="card-body">
							<div class="kt-section kt-section--first">
								@foreach($typePieces3 as $typePiece)
									<div class="form-group row">
										<label class="col-8 col-form-label">{{ $typePiece->libelle }} :</label>
										<div class="col-3">
											<span class="kt-switch">
												<label>
													<input type="checkbox" {{ (in_array($typePiece->id, $oblig3)) ? 'checked' : '' }} onchange="savePiece({{ $typePiece->id }}, 'etrangers')" name="intervenant" />
													<span></span>
												</label>
											</span>
										</div>
									</div>
								@endforeach
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	
	<div class="row">
		<div class="col-xl-4">	
			<!--begin:: Widgets/New Users-->
			<div class="card card-custom">
				<div class="card-header">
					<div class="card-title">
						<h3>
							Véhicules
						</h3>
					</div>
				</div>
				<div class="card-body">
					<!--begin::Form-->
					<form class="kt-form" method="POST" action="/parametres/savetypepiece">
						{{ csrf_field() }}
						<div class="card-body">
							<div class="kt-section kt-section--first">
								@foreach($typePieces4 as $typePiece)
									<div class="form-group row">
										<label class="col-8 col-form-label">{{ $typePiece->libelle }} :</label>
										<div class="col-3">
											<span class="kt-switch">
												<label>
													<input type="checkbox" {{ (in_array($typePiece->id, $oblig4)) ? 'checked' : '' }} onchange="savePiece({{ $typePiece->id }}, 'vehicules')" name="intervenant" />
													<span></span>
												</label>
											</span>
										</div>
									</div>
								@endforeach
							</div>
						</div>
					</form>
				</div>
			</div>

			<!--end:: Widgets/New Users-->
		</div>
	</div>
	
	<div class="row">
		<div class="col-xl-4">	
			<!--begin:: Widgets/New Users-->
			<div class="card card-custom">
				<div class="card-header">
					<div class="card-title">
						<h3>
							Livraison
						</h3>
					</div>
				</div>
				<div class="card-body">
					<!--begin::Form-->
					<form class="kt-form" method="POST" action="/parametres/savetypepiece">
						{{ csrf_field() }}
						<div class="card-body">
							<div class="kt-section kt-section--first">
								@foreach($typePieces6 as $typePiece)
									<div class="form-group row">
										<label class="col-8 col-form-label">{{ $typePiece->libelle }} :</label>
										<div class="col-3">
											<span class="kt-switch">
												<label>
													<input type="checkbox" {{ (in_array($typePiece->id, $oblig6)) ? 'checked' : '' }} onchange="savePiece({{ $typePiece->id }}, 'livraisons')" name="intervenant" />
													<span></span>
												</label>
											</span>
										</div>
									</div>
								@endforeach
							</div>
						</div>
					</form>
				</div>
			</div>

			<!--end:: Widgets/New Users-->
		</div>
	</div>
	
	<div class="row">
		<div class="col-xl-4">	
			<!--begin:: Widgets/New Users-->
			<div class="card card-custom">
				<div class="card-header">
					<div class="card-title">
						<h3>
							Livreurs
						</h3>
					</div>
				</div>
				<div class="card-body">
					<!--begin::Form-->
					<form class="kt-form" method="POST" action="/parametres/savetypepiece">
						{{ csrf_field() }}
						<div class="card-body">
							<div class="kt-section kt-section--first">
								@foreach($typePieces7 as $typePiece)
									<div class="form-group row">
										<label class="col-8 col-form-label">{{ $typePiece->libelle }} :</label>
										<div class="col-3">
											<span class="kt-switch">
												<label>
													<input type="checkbox" {{ (in_array($typePiece->id, $oblig7)) ? 'checked' : '' }} onchange="savePiece({{ $typePiece->id }}, 'livreurs')" name="intervenant" />
													<span></span>
												</label>
											</span>
										</div>
									</div>
								@endforeach
							</div>
						</div>
					</form>
				</div>
			</div>

			<!--end:: Widgets/New Users-->
		</div>
	</div>
	
	<div class="row">
		<div class="col-xl-4">	
			<!--begin:: Widgets/New Users-->
			<div class="card card-custom">
				<div class="card-header">
					<div class="card-title">
						<h3>
							Validation globale
						</h3>
					</div>
				</div>
				<div class="card-body">
					<!--begin::Form-->
					<form class="kt-form" method="POST" action="/parametres/savetypepiece">
						{{ csrf_field() }}
						<div class="card-body">
							<div class="kt-section kt-section--first">
								<div class="form-group row">
									<label class="col-8 col-form-label">Enquête administrative :</label>
									<div class="col-3">
										<span class="kt-switch">
											<label>
												<input type="checkbox" {{ (in_array('enquete_administrative', $oblig5)) ? 'checked' : '' }} onchange="savePiece('enquete_administrative', 'global')" name="enquete_administrative" />
												<span></span>
											</label>
										</span>
									</div>
								</div>
								<div class="form-group row">
									<label class="col-8 col-form-label">Enquête interne :</label>
									<div class="col-3">
										<span class="kt-switch">
											<label>
												<input type="checkbox" {{ (in_array('enquete_interne', $oblig5)) ? 'checked' : '' }} onchange="savePiece('enquete_interne', 'global')" name="enquete_interne" />
												<span></span>
											</label>
										</span>
									</div>
								</div>
								<div class="form-group row">
									<label class="col-8 col-form-label">Avis interne :</label>
									<div class="col-3">
										<span class="kt-switch">
											<label>
												<input type="checkbox" {{ (in_array('avis_interne', $oblig5)) ? 'checked' : '' }} onchange="savePiece('avis_interne', 'global')" name="avis_interne" />
												<span></span>
											</label>
										</span>
									</div>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>

			<!--end:: Widgets/New Users-->
		</div>
	</div>
	<!--End::Dashboard 1-->
</div>
<!--End::Section-->
@endsection

@section('specifijs')
	<script src="{{ asset('assets/js/pieces.js') }}" type="text/javascript"></script>
@endsection