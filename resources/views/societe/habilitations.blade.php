@extends('layout.default')

@section('content')
<!-- begin:: Content Head -->
<div class="kt-subheader   kt-grid__item" id="kt_subheader">
	<div class="kt-subheader__main">
		<h3 class="kt-subheader__title">Habilitations</h3>
	</div>
	<div class="kt-subheader__toolbar">
		
	</div>
</div>

<!-- end:: Content Head -->

<!-- begin:: Content -->
<div class="card card-custom">
								
	<!--Begin::Section-->
	<div class="row">
		<div class="col-xl-6 col-sm-6">
			<!--begin:: Widgets/New Users-->
			<div class="card card-custom">
				<div class="card-body">
					<!--begin::Form-->
					<form class="kt-form" method="POST" action="#">
						<div class="card-body">
							<div class="kt-section kt-section--first">
								@foreach($habilitations as $habilitation)
									<div class="form-group row">
										<label class="col-8 col-form-label">{{ $habilitation->libelle }} :</label>
										<div class="col-3">
											<span class="kt-switch">
												<label>
													<input type="checkbox" {{ (in_array($habilitation->id, $oblig)) ? 'checked' : '' }} onchange="saveHabilitation({{ $habilitation->id }})" />
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
	<!--End::Dashboard 1-->
</div>
<!--End::Section-->
@endsection

@section('specifijs')
	<script src="{{ asset('assets/js/habilitations.js') }}" type="text/javascript"></script>
@endsection