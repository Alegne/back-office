@extends('back.parent.layout')

@section('breadcrumb')

    @include('back.parent.partial.breadcrumb', [
        'parent' => 'Parametres',
        'parent_route' => '#',
        'child' => 'Configurations',
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
            action="{{ route('configuration.update') }}">
        @method('PUT')

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
                        title='Configuration'>

                    <x-back.input
                            name='lien_facebook'
                            title='Lien Facebook'
                            :value="getConfiguration('lien_facebook')"
                            input='text'
                            :required="true">
                    </x-back.input>

                    <x-back.input
                            name='lien_twitter'
                            title='Lien Twitter'
                            :value="getConfiguration('lien_twitter')"
                            input='text'
                            :required="true">
                    </x-back.input>

                    <x-back.input
                            name='lien_youtube'
                            title='Lien Youtube'
                            :value="getConfiguration('lien_youtube')"
                            input='text'
                            :required="true">
                    </x-back.input>

                    <x-back.input
                            name='lien_map'
                            title='Lien Map'
                            :value="getConfiguration('lien_map')"
                            input='text'
                            :required="true">
                    </x-back.input>

                    <button type="submit" class="btn btn-primary">Valider</button>
                </x-back.card>
            </div>
        </div>


    </form>
@endsection
