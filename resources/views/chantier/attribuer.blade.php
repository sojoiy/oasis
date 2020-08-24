@extends('layout.default')

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
					<div id="calendar"></div>
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
	<script src="{{ asset('assets/js/demo1/pages/crud/forms/widgets/typeahead.js') }}" type="text/javascript"></script>
	<script src="{{ asset('assets/vendors/custom/fullcalendar/main.js') }}" type="text/javascript"></script>
	<script src="{{ asset('assets/vendors/custom/fullcalendar/daygrid/main.js') }}" type="text/javascript"></script>
	<script src="{{ asset('assets/vendors/custom/fullcalendar/locales/fr.js') }}" type="text/javascript"></script>
	
	<script type="text/javascript">
		document.addEventListener('DOMContentLoaded', function() {
		        var calendarEl = document.getElementById('calendar');

		        var calendar = new FullCalendar.Calendar(calendarEl, {
					locale: 'fr',
					plugins: [ 'dayGrid' ],
					eventClick: function(info) {
				    	var eventObj = info.event;
			 			$.ajax({
			    	        type:'POST',
			    	        url:'/chantier/setcreneau',
			    	        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			    			data: {
			    		        "equipierID": {{$equipier->id}},
			    				"creneau": eventObj.id
			    		        },
			    	         success:function(data){
			    	            $("#zoneNotification").html(data);
			    	         }
			    	      });
				    },
				    defaultDate: '{{ date("Y-m-d") }}',
					events: [
						@foreach($creneaux as $creneau)
						{
					        title: {{ $creneau->nombre_places }}+'pl.',
					        id: {{ $creneau->id }},
					        start: '{{ $creneau->date_debut }}',
					        end: '{{ date("Y-m-d H:i:s", strtotime($creneau->date_debut."+".$creneau->duree."minutes")) }}',
					    },
						@endforeach
						 
				    ]
				  });

		        calendar.render();
		      });
	</script>
@endsection