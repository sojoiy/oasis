@extends('layout.default')

<link href="{{ asset('/assets/plugins/custom/fullcalendar/fullcalendar.bundle.css?v=7.0.5') }}" rel="stylesheet" type="text/css" />
		
@section('content')
<!-- begin:: Content Head -->
<div class="kt-subheader   kt-grid__item" id="kt_subheader">
	<div class="kt-subheader__main">
		<h3 class="kt-subheader__title">{{ $chantier->numero }}</h3>
		<span class="kt-subheader__separator kt-subheader__separator--v"></span>
		
		<a href="#" class="btn btn-label-brand btn-bold btn-sm btn-icon-h kt-margin-l-5">
			<i class="fa fa-wrench"></i> Titulaire : {{ $chantier->nomTitulaire() }}</a>
			
		<a href="#" class="btn btn-label-brand btn-bold btn-sm btn-icon-h kt-margin-l-5">
			<i class="fa fa-user-tie"></i> DO : {{ $chantier->do() }}</a>
			
		<a href="/chantier/intervenants/{{$chantier->id}}" class="btn btn-label-info btn-bold btn-sm btn-icon-h kt-margin-l-5">
			<i class="fa fa-user-friends"></i> Intervenants</a>
	</div>
	<div class="kt-subheader__toolbar">
		
	</div>
</div>

<!-- end:: Content Head -->

<!-- begin:: Content -->
<div class="card card-custom">
	
	<div class="alert alert-light alert-elevate fade show" id="zoneNotification" role="alert">
	</div>
	
	<!--Begin::Section-->
	<div class="row">
		<div class="col-md-12">

			<!--begin:: Widgets/New Users-->
			<div class="kt-portlet" id="kt_portlet">
				<div class="card-header">
					<div class="card-title">
						<span class="kt-portlet__head-icon">
							<i class="flaticon-map-location"></i>
						</span>
						<h3>
							Choix d'un créneau pour {{ $equipier->name() }}
						</h3>
					</div>
					<div class="kt-portlet__head-toolbar">
						<form method="post" action="/chantier/attribuer" id="changerEquipier">
							{{ csrf_field() }}
							<select name="id" onchange="$('#changerEquipier').submit()">
								<option value="0">Changer d'intervenant</option>
								@foreach($equipe as $myEquipier)
									<option value="{{ $myEquipier->id }}">{{ $myEquipier->name() }}</option>
								@endforeach
							</select>
						</select>
					</div>
				</div>
				<div class="card-body">
					<div id="kt_calendar"></div>
				</div>
			</div>

			<!--end:: Widgets/New Users-->
		</div>
	</div>

	<!--End::Section-->
</div>
@endsection

@section('specifijs')
	<script src="{{ asset('assets/js/chantier.js') }}" type="text/javascript"></script>
	<script src="{{ asset('assets/plugins/custom/fullcalendar/fullcalendar.bundle.js?v=7.0.5') }}" type="text/javascript"></script>
	<script src="{{ asset('assets/js/pages/features/calendar/basic.js?v=7.0.5') }}" type="text/javascript"></script>
@endsection