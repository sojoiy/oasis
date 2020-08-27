
<div id="kt_calendar"></div>

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
