@extends('back.parent.layout')

@section('breadcrumb')

    @include('back.parent.partial.breadcrumb', [
        'parent' => 'Pedagogique',
        'parent_route' => route('parcours.index'),
        'child' => 'Parcours',
    ])

@endsection

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
            action="{{ Route::currentRouteName() === 'parcours.edit' ? route('parcours.update', $parcours->id) : route('parcours.store') }}">

        @if(Route::currentRouteName() === 'parcours.edit')
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
                        title='Parcours'>

                    <x-back.input
                            name='libelle'
                            title='Libelle'
                            :value="isset($parcours) ? $parcours->libelle : ''"
                            input='text'
                            :required="true">
                    </x-back.input>

                    <x-back.input
                            name='tag'
                            title='Tag'
                            :value="isset($parcours) ? $parcours->tag : ''"
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
