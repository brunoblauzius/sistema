var Script = function () {
	
	//var web_root = 'http://codewave.com.br/sistema/';
	
	
    /* initialize the external events
     -----------------------------------------------------------------*/

    $('#external-events div.external-event').each(function() {

        // create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
        // it doesn't need to have a start or end
        var eventObject = {
            title: $.trim($(this).text()) // use the element's text as the event title
        };

        // store the Event Object in the DOM element so we can get to it later
        $(this).data('eventObject', eventObject);

        // make the event draggable using jQuery UI
        $(this).draggable({
            zIndex: 999,
            revert: true,      // will cause the event to go back to its
            revertDuration: 0  //  original position after the drag
        });

    });


    /* initialize the calendar
     -----------------------------------------------------------------*/

    var date = new Date();
    var d = date.getDate();
    var m = date.getMonth();
    var y = date.getFullYear();

    $('#calendar').fullCalendar({
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
            //right: 'month,basicWeek,basicDay'
        },
		dayNamesShort: ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado'],
		//weekNumbers: true,
		today:         'Hoje',
		month:         'Mes',
                defaultView:   'month',
		week:          'Semana',
		day:           'Dia',
		lang:          'pt-br',
		//defaultDate:   dataInicio, //renderiza o calendario na data que estiver selecionada
		editable:      true,
		startEditable: true,
		eventLimit:    true, // allow "more" link when too many events
		droppable:     true, // this allows things to be dropped onto the calendar !!!
		
		//CAMEÇO FUNCAO BRUNO
		
		/**
		 * DAY CLICK FUNCAO QUE FAZ O EVENTO DO CLIK NO DIA E REALIZA O CADASTRO DA AGENDA
		 */
		dayClick: function(date, jsEvent, view) {
			//limpaForm();
//                        $('#loading').fadeIn(500);
//			$('#ModalFormulario').modal('show');
//                        
//                        $('#dados-cliente').empty();
//                        $('#dados-reserva').empty();
//                        $('#cliente').val(null);
//                        
//                        var dataInit = null;
//                        var dataEnd = null;
//
//                        if( date.format().length < 19 ){
//                           dataInit = date.format().split("-");
//                           //dataEnd      = '20:00';
//                           dataInit     = dataInit[2] +"/"+ dataInit[1] +"/"+ dataInit[0];
//                        } else {
//                            dataInit = date.format().split("T");
//                            var hora = dataInit[1];
//                            var data = dataInit[0];
//                            dataInit = data.split("-");
//                            dataEnd      = hora;
//                            dataInit     = dataInit[2] +"/"+ dataInit[1] +"/"+ dataInit[0];
//                        }
//			
//
//			$('#start').val( dataInit );
//			$('#hora').val( dataEnd );
//			$('#dados-cliente').empty();
//			$('#dados-reserva').empty();
//			$('#loading').fadeOut(500);

                        novoEvento( date.format(), 'Reservas/cadastro' );
		},

		/**
		 * EVENT CLICK FUNCAO QUE FAZ O EVENTO DO CLIK NO EVENTO E REALIZA A SUA VISUALIZAÇÃO
		 */
		eventClick: function(event) {
			if( event.start != null ) {
                            viewEnventoAjax( event.id ); 
			}
		},
        
		//FIM FUNCAO BRUNO
		
        drop: function(date, allDay) { // this function is called when something is dropped
            $('#loading').fadeIn(500);
            // retrieve the dropped element's stored Event Object
            var originalEventObject = $(this).data('eventObject');

            // we need to copy it, so that multiple events don't have a reference to the same object
            var copiedEventObject = $.extend({}, originalEventObject);

            // assign it the date that was reported
            copiedEventObject.start = date;
            copiedEventObject.allDay = allDay;

            // render the event on the calendar
            // the last `true` argument determines if the event "sticks" (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)
            $('#calendar').fullCalendar('renderEvent', copiedEventObject, true);

            // is the "remove after drop" checkbox checked?
            if ($('#drop-remove').is(':checked')) {
                // if so, remove the element from the "Draggable Events" list
                $(this).remove();
            }
            $('#loading').fadeOut(500);
        },
        events: web_root + 'Reservas/listAllEmpresas', 
		
    });


}();