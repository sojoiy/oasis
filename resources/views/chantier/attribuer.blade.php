@extends('layout.default')

<link href="{{ asset('/assets/plugins/custom/fullcalendar/fullcalendar.bundle.css?v=7.0.5') }}" rel="stylesheet" type="text/css" />
		
@section('content')
	<!--Begin::Section-->
	<div class="row">
		<div class="col-md-12">

			<!--begin:: Widgets/New Users-->
		    <div class="card card-custom">	
			    <div class="card-header">
			    	<h3 class="card-title ">
			    	Choix d'un créneau pour {{ $equipier->name() }}
			    	</h3>	
                    <div class="card-toolbar ">
                        <button class="btn btn-light-info font-weight-bolder btn-sm mr-2" onclick="annulerrdv({{$equipier->id}})">
                         Annuler le rendez-vous</button>
				    </div>	
			    </div> 
				<div class="alert alert-light alert-elevate fade show" id="zoneNotification" role="alert"></div>				
				<div class="card-body" id="calendar">
					<div id="kt_calendar"></div>
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
    <script src="{{ asset('assets/vendors/custom/fullcalendar/locales/fr.js')}}"></script>
	<script type="text/javascript">

var KTCalendarBasic = function() {

    return {

        //main function to initiate the module
        init: function() {
            var todayDate = moment().startOf('day');
            var YM = todayDate.format('MM-YYYY');
            var YESTERDAY = todayDate.clone().subtract(1, 'day').format('YYYY-MM-DD');
            var TODAY = todayDate.format('YYYY-MM-DD');
            var TOMORROW = todayDate.clone().add(1, 'day').format('YYYY-MM-DD');
          
            

            var calendarEl = document.getElementById('kt_calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                plugins: [ 'bootstrap', 'interaction', 'dayGrid', 'timeGrid', 'list' ],
                themeSystem: 'bootstrap',
                
                isRTL: KTUtil.isRTL(),
                locale: 'fr',
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
                            rafraichircalendar({{$equipier->id}});
		    	         }
		    	      });
			    },
                height: 800,
                contentHeight: 780,
                aspectRatio: 3,  // see: https://fullcalendar.io/docs/aspectRatio

                nowIndicator: true,
                now: TODAY + 'T09:25:00', // just for demo

                views: {
                    dayGridMonth: { buttonText: 'mois' },
                    timeGridWeek: { buttonText: 'semaine' },
                    timeGridDay: { buttonText: 'jour' }
                },

                defaultView: 'timeGridWeek',
                defaultDate: TODAY,

                editable: true,
                eventLimit: true, // allow "more" link when too many events
                navLinks: true,
                
                //event affiche l'heure, le nombre de place dispo et change de couleur selon si il en reste ou pas(vert/rouge)
                events: [
					@foreach($creneaux as $creneau)
                    {
                        title: " -  {{$creneau->nombre_places_dispo()}} / {{$creneau->nombre_places}} places",
                        start: "{{str_ireplace(' ','T',$creneau->date_debut)}}",
                        id: "{{$creneau->id}}",
                        
                        @if($creneau->nombre_places_dispo() == $creneau->nombre_places)
                           className: 'fc-day-grid-event fc-h-event fc-event fc-start fc-end fc-event-solid-danger fc-event-danger'
                        
                       
                        @else
                            className:'fc-day-grid-event fc-h-event fc-event fc-start fc-end fc-event-solid-success fc-event-success'
                           
                          
                         @endif
                        
						
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