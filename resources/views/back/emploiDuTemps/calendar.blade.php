@extends('back.parent.layout')


@section('breadcrumb')

    @include('back.parent.partial.breadcrumb', [
        'parent' => 'Pedagogique',
        'parent_route' => '#',
        'child' => 'Emploi du temps',
    ])

@endsection

@section('css')
    <link rel="stylesheet" href="/admin/plugins/fullcalendar/main.min.css">
    <link rel="stylesheet" href="/admin/plugins/toastr/toastr.min.css">
@endsection

@section('main')

    <input type="hidden" id="parent" value="{{ $id }}">
    <input type="hidden" id="niveau" value="{{ $niveau }}">
    <input type="hidden" id="start" value="{{ $start }}">
    <input type="hidden" id="end" value="{{ $end }}">

    <input type="hidden" id="calendar-route" value="{{ route('emploi-du-temps.calendar') }}">
    <input type="hidden" id="calendar-route-redirect" value="{{ route('emploi-du-temps.create') }}">

    <div class="row justify-content-start mb-2 mx-1">
        <a href="#" id="btn-validation-calendar" class="btn btn-outline-primary text-dark font-weight-bolder">Valider</a>
    </div>

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
                                <div class="external-event external-event-{{ $matiere->id }}"
                                     id="external-event-{{ $matiere->id }}"
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
        <div class="col-md-9" style="height: 1200px !important;">
            <div class="card card-primary" style="height: 1200px !important;">
                <div class="card-body p-0" style="height: 1200px !important;">
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

                        <input type="hidden" id="modal-matiere-id">

                        <div class="form-row">
                            <div class="form-group col-6">
                                <label for="modal-matiere">Matiere</label>
                                <select class="form-control" id="modal-matiere">
                                    @foreach($matieres as $matiere)
                                        <option value="{{ $matiere->id }}"  @if ($loop->first) selected @endif
                                                data-enseignant="{{ $matiere->enseignant->nom }} {{ $matiere->enseignant->prenom }}">
                                            {{ $matiere->libelle }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-6">
                                <label for="modal-specification">Parcours</label>
                                <select class="form-control" id="modal-specification" multiple>
                                    @foreach($emploiDuTemps->parcours as $parcours)
                                        <option value="{{ $parcours->tag }}"  @if ($loop->first) selected @endif>{{ $parcours->tag }}</option>
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

    <!-- Modal Confirmation -->
    <div class="modal fade" id="modal-confirmation" tabindex="-1" aria-labelledby="label" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" style="width: 600px !important;">
                <div class="modal-header">
                    <h5 class="modal-title" id="label">Confirmation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row justify-content-center">
                        <h3> Emploi du temps du {{ formatDateItem($emploiDuTemps->date_debut) }} - {{ formatDateItem($emploiDuTemps->date_fin) }}</h3>
                        <dl class="row">
                            <dt class="col-sm-6">Niveau</dt>
                            <dd class="col-sm-6">{{ $emploiDuTemps->niveau->tag }}</dd>
                            <dt class="col-sm-6">Parcours</dt>
                            <dd class="col-sm-6">
                                @foreach($emploiDuTemps->parcours as $parcours)
                                    <strong>{{ $parcours->tag }} </strong>
                                @endforeach</dd>
                            <dt class="col-sm-6">Annee Universitaire</dt>
                            <dd class="col-sm-6">{{ $emploiDuTemps->annee->libelle }}</dd>
                        </dl>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                    <button type="button" id="btn-calendar-validation" class="btn btn-primary">Valider</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <!-- jQuery UI -->
    <script src="/admin/plugins/jquery-ui/jquery-ui.min.js"></script>
    <script type="text/javascript" src="/admin/plugins/fullcalendar/main.min.js"></script>
    <script type="text/javascript" src="/admin/plugins/moment/moment.min.js"></script>
    <script type="text/javascript" src="/admin/plugins/toastr/toastr.min.js"></script>

    <script type="text/javascript">
        $(function () {

            $.ajaxSetup({
                headers:{
                    'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
                }
            });

            let route                = $('#calendar-route').val()
            const formatDateCalendar = "YYYY-MM-DD HH:mm:ss"
            const formatDateCalendar_2 = "YYYY-MM-DD"

            let limit_date_start = moment($('#start').val()).format(formatDateCalendar_2)
            let limit_date_end   = moment($('#end').val()).format(formatDateCalendar_2)

            /*console.log('Range date ', limit_date_start, limit_date_end)
            console.log('Range Date ', (new Date(limit_date_start)).toISOString(), new Date(limit_date_end))
            console.log('Range Date ', moment(limit_date_start).format(formatDateCalendar_2),
                moment(limit_date_end).format(formatDateCalendar_2))*/


            // let end_temp = new Date(limit_date_end)
            // end_temp.setDate(end_temp.getDate() + 1)
            // limit_date_end = end_temp.toISOString()

            limit_date_start = (new Date(limit_date_start)).toISOString()
            limit_date_end = (new Date(limit_date_end)).toISOString()

            // console.log('END', end_temp, limit_date_end)


            // Variable Global
            let request = {}

            console.log('URL', window.location.pathname,  window.location.href, route)

            /* initialize the external events
             -----------------------------------------------------------------*/
            function ini_events(ele) {
                ele.each(function () {

                    // create an Event Object (https://fullcalendar.io/docs/event-object)
                    // it doesn't need to have a start or end
                    let eventObject = {
                        title           : $.trim($(this).text()), // use the element's text as the event title
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
                    // console.log('Draggable', eventEl, eventEl.className)
                    let element = document.querySelector('.' + eventEl.className.split(" ")[0])

                    // console.log(element.dataset.niveau, element.dataset.specification, element.dataset.enseignant)
                    // console.log('eventObject', element.dataset.eventObject)
                    return {
                        id              : 0,
                        title           : eventEl.innerText,
                        backgroundColor : window.getComputedStyle( eventEl ,null).getPropertyValue('background-color'),
                        borderColor     : window.getComputedStyle( eventEl ,null).getPropertyValue('background-color'),
                        textColor       : window.getComputedStyle( eventEl ,null).getPropertyValue('color'),
                        enseignant      : element.dataset.enseignant,
                        specification   : element.dataset.specification,
                        matiere         : element.dataset.matiere,
                        temp_id         : 0
                    };
                }
            });

            let calendar = new Calendar(calendarEl, {
                /*visibleRange: {
                    start : limit_date_start,
                    end   : limit_date_end
                },*/
                validRange: {
                    start : limit_date_start,
                    end   : limit_date_end
                },
                nowIndicator: false,
                height: '100%',
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
                // unselectAuto: true,

                events: window.location.pathname + '?ajax=1',
                /*events:[
                    {
                        "id": 51,
                        "title": "corrupti : Hangson ricca",
                        "start": "2021-04-20 11:27:38",
                        "end": "2021-04-20 13:27:38",
                        "backgroundColor": "#79b6c0",
                        "borderColor": "#79b6c0",
                        "enseignant": "Dibbert Vivianne",
                        "specification": "[\"GB\"]"
                    },
                    {
                        "id": 52,
                        "title": "totam",
                        "start": "2021-04-22 11:27:38",
                        "end": "2021-04-22 11:27:38",
                        "backgroundColor": "#3c5ed0",
                        "borderColor": "#3c5ed0",
                        "enseignant": "Dibbert Vivianne",
                        "specification": "[\"GB\"]"
                    },
                    {
                        "id": 53,
                        "title": "quibusdam",
                        "start": "2021-04-23 09:27:38",
                        "end": "2021-04-23 11:27:38",
                        "backgroundColor": "#db736a",
                        "borderColor": "#db736a",
                        "enseignant": "Dibbert Vivianne",
                        "specification": "[\"GB\"]"
                    }
                ],*/
                /*events: [
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
                ],*/
                editable  : true,
                droppable : true, // this allows things to be dropped onto the calendar !!!

                selectable: true,

                // Add Event
                drop      : function(info) {
                    // console.log('drop', info, info.draggedEl)
                    // console.log('drop', info.dateStr, info.draggedEl.className.split(" ")[1])
                    let element = document.querySelector('#' + info.draggedEl.className.split(" ")[1])

                    console.log(element.dataset.specification)

                    let request = {}
                    request.emploi_du_temps_id = $('#parent').val()
                    request.matiere_id         = element.dataset.matiere
                    request.specification      = element.dataset.specification
                    request.heure_debut        = moment(info.dateStr).format(formatDateCalendar) //start
                    request.heure_fin          = moment(info.dateStr).format(formatDateCalendar) // end
                    request.type               = 'add-drop'

                    console.log('drop', JSON.stringify(request))

                    // console.log('getEventSources', calendar.getEventSources())

                    $.ajax({
                        url     : route,
                        type    : "POST",
                        data    : request,
                        success : function(data)
                        {
                            console.log('Calendar ', calendar)
                            console.log("Event Created Successfully", data)

                            calendar.removeAllEvents()
                            calendar.refetchEvents()
                            displayMessage("Event created Successfully")
                        }
                    })

                },
                select: function(info) {
                    // console.log('selected', info.startStr, ' to ', info.endStr)

                    console.log('select first')

                    let start = moment(info.startStr).format(formatDateCalendar)
                    let end   = moment(info.endStr).format(formatDateCalendar)

                    request.emploi_du_temps_id  = $('#parent').val()
                    request.matiere_id          = $('#modal-matiere').val()
                    request.specification       = $('#modal-specification').val()
                    request.heure_debut         = start
                    request.heure_fin           = end
                    request.type                = 'add'

                    $('#heure_debut').val(start)
                    $('#heure_fin').val(end)

                    console.log('select', JSON.stringify(request))

                    $.ajax({
                        url     : route,
                        type    : "POST",
                        data    : request,
                        success : function(data)
                        {
                            console.log("Event Created Successfully", data)

                            $('#modal-add-evenement').modal('show')

                            $('#modal-matiere-id').val(data.id)

                            calendar.unselect()

                            request = {}
                        }
                    })

                },

                eventReceive: function (event) {
                    console.log('EventReceive')
                },

                // Update Event
                eventResize: function(info) {

                    console.log('eventResize', info.event.id, info.event.title, " end is now ", info.event.end.toISOString())
                    console.log('eventResize', info.event.id, info.event.title, " start is now ", info.event.start.toISOString())
                    console.log('extra', info.event.extendedProps)

                    // matiere | specification

                    if (!confirm("Etes-vous sure?")) {
                        info.revert();
                        console.log('eventResize reset')
                    }

                    let requete = {
                        id                  : info.event.id,
                        emploi_du_temps_id  : $('#parent').val(),
                        matiere_id          : info.event.extendedProps.matiere,
                        specification       : info.event.extendedProps.specification,
                        heure_debut         : moment(info.event.start.toISOString()).format(formatDateCalendar),
                        heure_fin           : moment(info.event.end.toISOString()).format(formatDateCalendar),
                        type                : 'update-resize'
                    }

                    console.log('eventResize', JSON.stringify(requete))

                    $.ajax({
                        url    : route,
                        type   : "POST",
                        data   : requete,
                        success :function(response)
                        {
                            calendar.removeAllEvents()
                            calendar.refetchEvents()
                            displayMessage("Event updated Successfully")
                        }
                    })
                },
                eventDrop: function(info) {
                    // alert(info.event.title + " was dropped on " + info.event.start.toISOString())
                    console.log('eventDrop', info.event.title + " was dropped on ", info.event.start.toISOString())

                    let end = info.event.start.toISOString()

                    if (info.event.end) {
                        console.log('eventDrop', info.event.title + " was dropped on ", info.event.end.toISOString())

                        end = info.event.end.toISOString()
                    } else {
                        console.log('eventDrop', info.event.title + " was dropped NOT END")
                    }

                    if (!confirm("Etes-vous sure de le changer?")) {
                        info.revert();
                    }

                    let requete = {
                        id                  : info.event.id,
                        emploi_du_temps_id  : $('#parent').val(),
                        matiere_id          : info.event.extendedProps.matiere,
                        specification       : info.event.extendedProps.specification,
                        heure_debut         : moment(info.event.start.toISOString()).format(formatDateCalendar),
                        heure_fin           : moment(end).format(formatDateCalendar),
                        type                : 'update-resize'
                    }

                    console.log('eventDrop', JSON.stringify(requete))

                    $.ajax({
                        url    : route,
                        type   : "POST",
                        data   : requete,
                        success :function(response)
                        {
                            calendar.removeAllEvents()
                            calendar.refetchEvents()
                            displayMessage("Event updated Successfully")
                        }
                    })
                },

                // Delete Event
                eventClick: function (info) {
                    // alert(info.event.title + " was eventClick on " )
                    console.log('eventClick', info.event.title, " was eventClick on ", info.event.id)

                    if(confirm("Etes vous sure de le supprimer \n " +  info.event.title))
                    {
                        $.ajax({
                            url      : route,
                            type     : "POST",
                            data     : { id   : info.event.id, type : "delete" },
                            success  : function(response) {
                                console.log('Supprimer ' + response)

                                calendar.removeAllEvents()
                                calendar.refetchEvents()
                                displayMessage("Event removed Successfully")
                            }
                        })
                    }

                }
            });

            calendar.render();
            // $('#calendar').fullCalendar()

            $('#btn-validation').click(function () {
                console.log('btn modal click')

                updateMatiere($('#modal-matiere-id').val())

                $('#modal-add-evenement').modal('hide')
            })

            $('#btn-validation-calendar').click(function (e) {
                e.preventDefault()
                $('#modal-confirmation').modal('show')
            })

            $('#btn-calendar-validation').click(function () {
                console.log('btn modal click confirmation')

                toastr.success("Validation success", 'Emploi du Temps')

                $('#modal-confirmation').modal('hide')

                window.location.href = $('#calendar-route-redirect').val()
            })

            function updateMatiere(id) {

                let start = $('#heure_debut').val()
                let end   = $('#heure_fin').val()

                console.log('update', id, start, end)

                let requete = {
                    id                  : id,
                    emploi_du_temps_id  : $('#parent').val(),
                    matiere_id          : $('#modal-matiere').val(),
                    specification       : $('#modal-specification').val(),
                    heure_debut         : start,
                    heure_fin           : end,
                    type                : 'update'
                }

                console.log('updateMatier', JSON.stringify(requete))

                $.ajax({
                    url    : route,
                    type   : "POST",
                    data   : requete,
                    success :function(response)
                    {
                        calendar.removeAllEvents()
                        calendar.refetchEvents()
                        displayMessage("Event created Successfully")
                    }
                })
            }




            function displayMessage(message) {
                toastr.success(message, 'Matiere')
            }

        })
    </script>
@endsection
