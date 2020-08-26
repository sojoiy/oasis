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
					<div class="alert alert-light alert-elevate fade show" id="zoneNotification" role="alert"></div>				
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
	<script type="text/javascript">

var KTCalendarBasic = function() {

    return {
        //main function to initiate the module
        init: function() {
            var todayDate = moment().startOf('day');
            var YM = todayDate.format('YYYY-MM');
            var YESTERDAY = todayDate.clone().subtract(1, 'day').format('YYYY-MM-DD');
            var TODAY = todayDate.format('YYYY-MM-DD');
            var TOMORROW = todayDate.clone().add(1, 'day').format('YYYY-MM-DD');

            var calendarEl = document.getElementById('kt_calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                plugins: [ 'bootstrap', 'interaction', 'dayGrid', 'timeGrid', 'list' ],
                themeSystem: 'bootstrap',

                isRTL: KTUtil.isRTL(),

                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
				eventClick: function(info) {
					var eventObj = info.event;
					console.log(eventObj);
		 			$.ajax({
		    	        type:'POST',
		    	        url:'/chantier/setcreneau',
						headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
						
		    			data: {
		    		        "equipierID": {{$equipier->id}},
							"creneau": eventObj.id,
							
		    		        },
		    	         success:function(data){
		    	            $("#zoneNotification").html(data);
		    	         }
		    	      });
			    },
                height: 800,
                contentHeight: 780,
                aspectRatio: 3,  // see: https://fullcalendar.io/docs/aspectRatio

                nowIndicator: true,
                now: TODAY + 'T09:25:00', // just for demo

                views: {
                    dayGridMonth: { buttonText: 'month' },
                    timeGridWeek: { buttonText: 'week' },
                    timeGridDay: { buttonText: 'day' }
                },

                defaultView: 'timeGridWeek',
                defaultDate: TODAY,

                editable: true,
                eventLimit: true, // allow "more" link when too many events
                navLinks: true,
				
                events: [
					@foreach($creneaux as $creneau)
                    {
                        title: " - {{$creneau->nombre_places}} places",
                        start: "{{str_ireplace(' ','T',$creneau->date_debut)}}",
						className: "fc-event-danger fc-event-solid-warning",
						id: "{{$creneau->id}}"
                    },
                    @endforeach
                ],

                eventRender: function(info) {
                    var element = $(info.el);

                    if (info.event.extendedProps && info.event.extendedProps.description) {
                        if (element.hasClass('fc-day-grid-event')) {
                            element.data('content', info.event.extendedProps.description);
                            element.data('placement', 'top');
                            KTApp.initPopover(element);
                        } else if (element.hasClass('fc-time-grid-event')) {
                            element.find('.fc-title').append('<div class="fc-description">' + info.event.extendedProps.description + '</div>');
                        } else if (element.find('.fc-list-item-title').lenght !== 0) {
                            element.find('.fc-list-item-title').append('<div class="fc-description">' + info.event.extendedProps.description + '</div>');
                        }
                    }
                }
            });

            calendar.render();
        }
    };
}();

jQuery(document).ready(function() {
    KTCalendarBasic.init();
});
</script>
@endsection