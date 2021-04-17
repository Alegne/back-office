@extends('back.parent.layout')

@section('css')
    <style>
        #holder img {
            height: 100%;
            width: 100%;
        }
    </style>
    <link rel="stylesheet" href="/admin/plugins/year-picker-text-input/yearpicker.css">
@endsection

@section('main')
    <form
            method="post"
            action="{{ Route::currentRouteName() === 'annee-universitaire.edit' ? route('annee-universitaire.update', $annee->id) : route('annee-universitaire.store') }}">

        @if(Route::currentRouteName() === 'annee-universitaire.edit')
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
                        title='Annee Universitaire'>



                    <div class="form-row">
                        <div class="form-group col">
                            <label for="debut">Debut</label>
                            <input type="text" id="debut" class="yearpicker form-control"
                                   maxlength="4" size="4" value="" pattern="[0-9]{4}" autofocus />
                        </div>
                        <div class="form-group col">
                            <label for="fin">Fin</label>
                            <input type="text" id="fin" class="yearpicker form-control"
                                   maxlength="4" size="4" value="" pattern="[0-9]{4}" />
                        </div>
                    </div>

                    <x-back.input
                            name='libelle'
                            title='Libelle'
                            :value="isset($annee) ? $annee->libelle : ''"
                            input='text'
                            :required="true">
                    </x-back.input>




                    <button type="submit" class="btn btn-primary">Valider</button>
                </x-back.card>
            </div>
        </div>


    </form>
@endsection

@section('js')
    {{--@include('back.shared.editorScript')--}}
    {{--    @include('back.shared.slugScript')--}}

    <script type="text/javascript" src="/admin/plugins/year-picker-text-input/yearpicker.js"></script>

    <script>
        $('.yearpicker').yearpicker()

        $(document).ready(() => {
            $('#libelle').attr('readonly', 'readonly')

            $('#debut').change(function (e) {
                $('#fin').val(parseInt($(this).val()) + 1)

                $('#libelle').val($(this).val() + '-' + $('#fin').val())

                console.log($(this).val(), $('#fin').val(), $('#libelle').val())
            })


            $('#fin').change(function (e) {
                $('#debut').val(parseInt($(this).val()) - 1)

                $('#libelle').val($('#debut').val() + '-' + $(this).val())

                console.log($(this).val(), $('#fin').val(), $('#libelle').val())
            })
        })
    </script>
@endsection
