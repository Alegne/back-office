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
                            name='telephone'
                            title='Telephone'
                            :value="getConfiguration('telephone')"
                            input='text'
                            :required="true">
                    </x-back.input>

                    <x-back.input
                            name='email'
                            title='Email'
                            :value="getConfiguration('email')"
                            input='text'
                            :required="true">
                    </x-back.input>

                    <x-back.input
                            name='adresse'
                            title='Adresse'
                            :value="getConfiguration('adresse')"
                            input='text'
                            :required="true">
                    </x-back.input>

                    <button type="submit" class="btn btn-primary">Valider</button>
                </x-back.card>
            </div>
        </div>


    </form>
@endsection
