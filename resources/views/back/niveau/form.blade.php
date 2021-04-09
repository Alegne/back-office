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
            action="{{ Route::currentRouteName() === 'niveau.edit' ? route('niveau.update', $niveau->id) : route('niveau.store') }}">

        @if(Route::currentRouteName() === 'niveau.edit')
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
                        title='Niveau'>

                    <x-back.input
                            name='libelle'
                            title='Libelle'
                            :value="isset($niveau) ? $niveau->libelle : ''"
                            input='text'
                            :required="true">
                    </x-back.input>

                    <x-back.input
                            name='tag'
                            title='Tag'
                            :value="isset($niveau) ? $niveau->tag : ''"
                            input='text'
                            :required="true">
                    </x-back.input>

                    {{--{{ $niveau->formation->id  }}--}}

                    <x-back.input
                            name='formation_id'
                            title='Formation'
                            :value="isset($niveau) ? $niveau->formation->id  : ''"
                            input='select'
                            :options="$formations"
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
