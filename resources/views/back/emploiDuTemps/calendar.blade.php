@extends('back.parent.layout')

@section('css')
    <link rel="stylesheet" href="/admin/plugins/fullcalendar/main.min.css">
@endsection

@section('main')

    <input type="hidden" id="parent" value="{{ $id }}">
    <input type="hidden" id="niveau" value="{{ $niveau }}">

    <div class="row">
        <div class="col-md-3">
            <div class="sticky-top mb-3">

                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">
                            Matieres {{ $emploiDuTemps->niveau->tag }}
                            @foreach($emploiDuTemps->parcours as $parcours)
                                <strong>{{ $parcours->tag }} </strong>
                            @endforeach
                        </h4>
                    </div>
                    <div class="card-body">
                        <!-- the events -->
                        <div id="external-events">
                            @foreach($matieres as $matiere)
                                <div class="external-event"
                                     data-matiere="{{ $matiere->id }}"
                                     data-niveau="{{ $matiere->niveau->tag }}"
                                     data-specification="{{ json_encode($matiere->parcours->pluck('tag'))}}"
                                     data-enseignant="{{ $matiere->enseignant->nom }} {{ $matiere->enseignant->prenom }}"
                                     style="background-color: {{ $matiere->couleur }}">
                                    {{ $matiere->libelle }}
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>
        <!-- /.col -->
        <div class="col-md-9">
            <div class="card card-primary">
                <div class="card-body p-0">
                    <!-- THE CALENDAR -->
                    <div id="calendar"></div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modal-add-evenement" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ajouter un Item</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="">
                    <div class="modal-body">

                        <input type="hidden" id="heure_debut">
                        <input type="hidden" id="heure_fin">

                        <div class="form-row">
                            <div class="form-group col-6">
                                <label for="modal-matiere">Matiere</label>
                                <select class="form-control" id="modal-matiere">
                                    @foreach($matieres as $matiere)
                                        <option value="{{ $matiere->id }}"
                                                data-enseignant="{{ $matiere->enseignant->nom }} {{ $matiere->enseignant->prenom }}">
                                            {{ $matiere->libelle }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-6">
                                <label for="modal-specification">Specification</label>
                                <select class="form-control" id="modal-specification">

                                    @foreach($emploiDuTemps->parcours as $parcours)
                                        <option value="{{ $parcours->id }}">{{ $parcours->tag }}</option>
                                    @endforeach

                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                        <button type="button" id="btn-validation" class="btn btn-primary">Valider</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <!-- jQuery UI -->
    <script src="/admin/plugins/jquery-ui/jquery-ui.min.js"></script>
    <script type="text/javascript" src="/admin/plugins/fullcalendar/main.min.js"></script>

    <script type="text/javascript">
        $(function () {

            console.log('URL', window.location.pathname,  window.location.href)

            /* initialize the external events
             -----------------------------------------------------------------*/
            function ini_events(ele) {
                ele.each(function () {

                    // create an Event Object (https://fullcalendar.io/docs/event-object)
                    // it doesn't need to have a start or end
                    let eventObject = {
                        title: $.trim($(this).text()) // use the element's text as the event title
                    }

                    // store the Event Object in the DOM element so we can get to it later
                    $(this).data('eventObject', eventObject)

                    // console.log('eventObject', eventObject)

                    // make the event draggable using jQuery UI
                    $(this).draggable({
                        zIndex        : 1070,
                        revert        : true, // will cause the event to go back to its
                        revertDuration: 0  //  original position after the drag
                    })

                })
            }

            ini_events($('#external-events div.external-event'))

            /* initialize the calendar
             -----------------------------------------------------------------*/
            //Date for the calendar events (dummy data)
            let date = new Date()
            let d    = date.getDate(),
                m    = date.getMonth(),
                y    = date.getFullYear()

            let Calendar = FullCalendar.Calendar;
            let Draggable = FullCalendar.Draggable;

            let containerEl = document.getElementById('external-events');
            let calendarEl = document.getElementById('calendar');

            // initialize the external events
            // -----------------------------------------------------------------

            new Draggable(containerEl, {
                itemSelector: '.external-event',
                eventData: function(eventEl) {
                    console.log('Draggable', eventEl, eventEl.className)
                    let element = document.querySelector('.' + eventEl.className.split(" ")[0])

                    console.log(element.dataset.niveau, element.dataset.specification, element.dataset.enseignant)
                    return {
                        id              : element.dataset.matiere,
                        title           : eventEl.innerText,
                        backgroundColor : window.getComputedStyle( eventEl ,null).getPropertyValue('background-color'),
                        borderColor     : window.getComputedStyle( eventEl ,null).getPropertyValue('background-color'),
                        textColor       : window.getComputedStyle( eventEl ,null).getPropertyValue('color'),
                        enseignant      : element.dataset.enseignant,
                        specification   : element.dataset.specification,
                    };
                }
            });

            let calendar = new Calendar(calendarEl, {
                allDaySlot: false,
                firstDay: 1,
                locale: 'fr',
                initialView: 'timeGridWeek',
                headerToolbar: {
                    left  : '',
                    center: 'title',
                    right : ''
                },
                themeSystem: 'bootstrap',
                //Random default events
                events: [
                    {
                        title          : 'All Day Event',
                        start          : new Date(y, m, 1),
                        backgroundColor: '#f56954', //red
                        borderColor    : '#f56954', //red
                        allDay         : true
                    },
                    {
                        title          : 'Long Event',
                        start          : new Date(y, m, d - 5),
                        end            : new Date(y, m, d - 2),
                        backgroundColor: '#f39c12', //yellow
                        borderColor    : '#f39c12' //yellow
                    },
                    {
                        title          : 'Meeting',
                        start          : new Date(y, m, d, 10, 30),
                        allDay         : false,
                        backgroundColor: '#0073b7', //Blue
                        borderColor    : '#0073b7' //Blue
                    },
                    {
                        id             : 1,
                        title          : 'Lunch',
                        start          : new Date(y, m, d, 12, 0),
                        end            : new Date(y, m, d, 14, 0),
                        allDay         : false,
                        backgroundColor: '#00c0ef', //Info (aqua)
                        borderColor    : '#00c0ef' //Info (aqua)
                    },
                    {
                        title          : 'Birthday Party',
                        start          : new Date(y, m, d + 1, 19, 0),
                        end            : new Date(y, m, d + 1, 22, 30),
                        allDay         : false,
                        backgroundColor: '#00a65a', //Success (green)
                        borderColor    : '#00a65a' //Success (green)
                    },
                    {
                        title          : 'Click for Google',
                        start          : new Date(y, m, 28),
                        end            : new Date(y, m, 29),
                        url            : 'https://www.google.com/',
                        backgroundColor: '#3c8dbc', //Primary (light-blue)
                        borderColor    : '#3c8dbc' //Primary (light-blue)
                    }
                ],
                editable  : true,
                droppable : true, // this allows things to be dropped onto the calendar !!!

                selectable: true,

                // Add Event
                drop      : function(info) {
                    console.log('drop', info, info.draggedEl)
                    let element = document.querySelector('.' + info.draggedEl.className.split(" ")[0])

                    console.log(element.dataset.niveau, element.dataset.specification, element.dataset.enseignant)

                    console.log(info.dateStr)

                    let request = {}
                    request.emploi_du_temps_id = $('#parent').val()
                    request.matiere_id         = element.dataset.matiere
                    // request.heure_debut        = info.event.start.toISOString() // dateStr
                    // request.heure_fin          = info.event.end.toISOString()
                    request.specification      = element.dataset.specification
                    request.heure_debut        = info.dateStr
                    request.heure_fin          = info.dateStr

                    console.log(JSON.stringify(request))
                },
                /*dateClick: function(info) {
                    // alert('clicked ' + info.dateStr)
                    console.log('dateClick', info.dateStr)
                },*/
                select: function(info) {
                    // alert('selected ' + info.startStr + ' to ' + info.endStr)
                    console.log('selected', info.startStr, ' to ', info.endStr)

                    $('#modal-add-evenement').modal('show')

                    $('#heure_debut').val(info.startStr)
                    $('#heure_fin').val(info.endStr)

                    $('#btn-validation').click(function () {
                        let request = {}

                        request.emploi_du_temps_id = $('#parent').val()
                        request.matiere_id         = $('#modal-matiere').val()
                        request.specification      = $('#modal-specification').val()
                        request.heure_debut        = info.startStr
                        request.heure_fin          = info.endStr

                        console.log(JSON.stringify(request))
                    })
                },

                // Update Event
                eventResize: function(info) {
                    // alert(info.event.title + " end is now " + info.event.end.toISOString())
                    console.log('eventResize', info.event.id)
                    console.log('eventResize', info.event.title, " end is now ", info.event.end.toISOString())
                    console.log('eventResize', info.event.title, " start is now ", info.event.start.toISOString())

                    if (!confirm("is this okay?")) {
                        info.revert();
                        console.log('eventResize reset')
                    }
                },
                eventDrop: function(info) {
                    // alert(info.event.title + " was dropped on " + info.event.start.toISOString())
                    console.log('eventDrop', info.event.title + " was dropped on ", info.event.start.toISOString())

                    if (!confirm("Are you sure about this change?")) {
                        info.revert();
                    }
                },

                // Delete Event
                eventClick: function (info) {
                    // alert(info.event.title + " was eventClick on " )
                    console.log('eventClick', info.event.title, " was eventClick on " )

                }
            });

            calendar.render();
            // $('#calendar').fullCalendar()

        })
    </script>
@endsection
