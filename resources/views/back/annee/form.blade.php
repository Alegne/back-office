@extends('back.parent.layout')

@section('css')
    <style>
        #holder img {
            height: 100%;
            width: 100%;
        }
    </style>
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
                        title='annee'>

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
@endsection
