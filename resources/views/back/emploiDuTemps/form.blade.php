@extends('back.parent.layout')

@section('breadcrumb')

    @include('back.parent.partial.breadcrumb', [
        'parent' => 'Pedagogique',
        'parent_route' => '#',
        'child' => 'Emploi du temps',
    ])

@endsection

@section('css')
@endsection

@section('main')
    <form
            method="post"
            action="{{ Route::currentRouteName() === 'emploi-du-temps.edit' ? route('emploi-du-temps.update', $emploiDuTemps->id) :
                                                                       route('emploi-du-temps.store') }}"
            enctype="multipart/form-data">

        @if(Route::currentRouteName() === 'emploi-du-temps.edit')
            @method('PUT')
        @endif

        @csrf

        <div class="row justify-content-center">
            <div class="col-md-8">

                <x-back.validation-errors :errors="$errors" />

                @if(session('ok'))
                    <x-back.alert
                            type='success'
                            title="{!! session('ok') !!}">
                    </x-back.alert>
                @endif

                <x-back.card
                        type='primary'
                        title='Emploi du temps'>

                    <input type="hidden" name="password" value="password">

                    <div class="form-row">
                        <x-back.input
                                col="col-md-6"
                                name='date_debut'
                                title='Date de Debut'
                                :value="isset($emploiDuTemps) ? $emploiDuTemps->date_debut : ''"
                                input='date'
                                :required="true">
                        </x-back.input>
                        <x-back.input
                                col="col-md-6"
                                name='date_fin'
                                title='date_fin'
                                :value="isset($emploiDuTemps) ? $emploiDuTemps->date_debut : ''"
                                input='date'
                                :required="true">
                        </x-back.input>
                    </div>
                    <input type="hidden" id="date_debut_clone"
                           value="{{ old('date_debut', isset($emploiDuTemps) ? $emploiDuTemps->date_debut : '') }}">
                    <input type="hidden" id="date_fin_clone"
                           value="{{ old('date_fin', isset($emploiDuTemps) ? $emploiDuTemps->date_fin : '') }}">

                    <div class="form-row">
                        <x-back.input
                                col="col-md-4"
                                name='parcours_id'
                                title='Parcours'
                                :values="isset($emploiDuTemps) ? $emploiDuTemps->parcours  : collect()"
                                input='selectMultiple'
                                :options="$parcours"
                                :required="true">
                        </x-back.input>
                            <x-back.input
                                    col="col-md-4"
                                    name='niveau_id'
                                    title='Niveau'
                                    :value="isset($emploiDuTemps->niveau) ? $emploiDuTemps->niveau->id  : ''"
                                    input='select'
                                    :options="$niveaux"
                                    :required="true">
                            </x-back.input>

                            <x-back.input
                                    col="col-md-4"
                                    name='annee_id'
                                    title='Annee Universitaire'
                                    :value="isset($emploiDuTemps->annee) ? $emploiDuTemps->annee->id  : ''"
                                    input='select'
                                    :options="$annees"
                                    :required="true">
                            </x-back.input>
                    </div>

                    <button type="submit" class="btn btn-primary">Suivant</button>
                </x-back.card>
            </div>
        </div>


    </form>
@endsection

@section('js')


    <script type="text/javascript" src="/admin/plugins/moment/moment.min.js"></script>

    <script>
        $(document).ready(() => {
            if ($('#date_debut_clone').val())
            {
                let data_input = $('#date_debut_clone').val() // Oct 23

                let dateObject = new Date(data_input)

                let dateString = moment(dateObject).format('YYYY-MM-DD');
                console.log('Moment.js', dateString) // Output: 2020-07-21

                $('#date_debut').val(dateString)
            }

            if ($('#date_fin_clone').val())
            {
                let data_input = $('#date_fin_clone').val() // Oct 23

                let dateObject = new Date(data_input)

                let dateString = moment(dateObject).format('YYYY-MM-DD');
                console.log('Moment.js', dateString) // Output: 2020-07-21

                $('#date_fin').val(dateString)
            }
        })
    </script>
@endsection
