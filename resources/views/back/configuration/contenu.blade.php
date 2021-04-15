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

        <div class="row">
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
                            name='nom_directeur'
                            title='Nom de Directeur'
                            :value="getConfiguration('nom_directeur')"
                            input='text'
                            :required="true">
                    </x-back.input>

                    <x-back.input
                            name='mot_directeur'
                            title='Mot de Directeur'
                            :value="getConfiguration('mot_directeur')"
                            input='textarea'
                            rows=10
                            :required="true">
                    </x-back.input>

                    <button type="submit" class="btn btn-primary">Valider</button>
                </x-back.card>
            </div>

            <div class="col-md-4">
                <x-back.card
                        type='primary'
                        :outline="false"
                        title='Photo'>

                    <div id="holder" class="text-center" style="margin-bottom:15px;">
                        @if(getConfiguration('image_directeur') != null)
                            <img style="width:100%;"
                                 {{--src="{{ getImage($formation, true) }}" --}}
                                 alt="">
                        @endif
                    </div>

                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <a id="lfm" data-input="image" data-preview="holder"
                               class="btn btn-primary text-white btn-outline-secondary"
                               type="button">Bouton</a>
                        </div>

                        <input id="image" class="form-control {{ $errors->has('photo') ? 'is-invalid' : '' }}"
                               type="text" name="image_directeur"
                                {{--value="{{ old('photo', isset($formation) ? getImage($formation) : '') }}"--}}
                        >
                        @if ($errors->has('photo'))
                            <div class="invalid-feedback">
                                {{ $errors->first('photo') }}
                            </div>
                        @endif
                    </div>


                </x-back.card>
            </div>
        </div>


    </form>
@endsection
