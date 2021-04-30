@extends('espace.parent.layout')

@section('css')

    <link rel="stylesheet" href="/admin/plugins/fullcalendar/main.min.css">
    <link rel="stylesheet" href="/admin/plugins/toastr/toastr.min.css">

@endsection

@section('content')


    <input type="hidden" id="parent" value="{{ $emploiTemps->id }}">
    <input type="hidden" id="route" value="{{ route('espace.emploi_temps.show', ['emploiTemps' => $emploiTemps->id])  }}">

    <input type="hidden" id="start" value="{{ $emploiTemps->date_debut }}">
    <input type="hidden" id="end" value="{{ $emploiTemps->date_fin }}">

    <div class="row justify-content-center">

        <div class="col-12 justify-content-start mx-1 mb-2">
            <a href="{{ route('espace.emploi_temps.index') }}" class="btn btn-primary">Retour</a>
        </div>

        <div class="col-12">
                <div class="card card-primary" style="height: 1200px !important;">
                    <div class="card-body p-0" style="height: 1200px !important;">
                        <!-- THE CALENDAR -->
                        <div id="calendar"></div>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>
    </div>

@endsection

@section('script')

    <!-- jQuery UI -->
    <script type="text/javascript" src="/admin/plugins/jquery-ui/jquery-ui.min.js"></script>
    <script type="text/javascript" src="/admin/plugins/fullcalendar/main.min.js"></script>
    <script type="text/javascript" src="/admin/plugins/moment/moment.min.js"></script>
    <script type="text/javascript" src="/admin/plugins/toastr/toastr.min.js"></script>

    <script type="text/javascript">
        $(function () {

            let route = $('#route').val()

            const formatDateCalendar = "YYYY-MM-DD HH:mm:ss"
            const formatDateCalendar_2 = "YYYY-MM-DD"

            let limit_date_start = moment($('#start').val()).format(formatDateCalendar_2)
            let limit_date_end   = moment($('#end').val()).format(formatDateCalendar_2)
            limit_date_start = (new Date(limit_date_start)).toISOString()
            limit_date_end = (new Date(limit_date_end)).toISOString()

            console.log('URL', window.location.pathname,  window.location.href, route)

            let Calendar = FullCalendar.Calendar;

            let calendarEl = document.getElementById('calendar');


            let calendar = new Calendar(calendarEl, {
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

                events: route + '?ajax=1',
            });

            calendar.render();

        })
    </script>
@endsection
