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
            action="{{ Route::currentRouteName() === 'enseignant.edit' ? route('enseignant.update', $enseignant->id) : route('enseignant.store') }}">

        @if(Route::currentRouteName() === 'enseignant.edit')
            @method('PUT')
        @endif

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
                        title='Enseignant'>

                    <input type="hidden" name="mot_de_passe" value="password">

                    <div class="form-row">
                        <x-back.input
                                col="col-md-6"
                                name='nom'
                                title='Nom'
                                :value="isset($enseignant) ? $enseignant->nom : ''"
                                input='text'
                                :required="true">
                        </x-back.input>
                        <x-back.input
                                col="col-md-6"
                                name='prenom'
                                title='Prenom'
                                :value="isset($enseignant) ? $enseignant->prenom : ''"
                                input='text'
                                :required="true">
                        </x-back.input>
                    </div>

                    <div class="form-row">
                        <x-back.input
                                col="col-md-6"
                                name='titre'
                                title='Titre'
                                :value="isset($enseignant) ? $enseignant->titre : ''"
                                input='text'
                                :required="true">
                        </x-back.input>

                        <x-back.input
                                col="col-md-6"
                                name='grade'
                                title='Grade'
                                :value="isset($enseignant) ? $enseignant->grade : ''"
                                input='text'
                                :required="true">
                        </x-back.input>
                    </div>

                    <div class="form-row">
                        <x-back.input
                                col="col-md-6"
                                name='identifiant'
                                title='identifiant'
                                :value="isset($enseignant) ? $enseignant->identifiant : ''"
                                input='text'
                                :required="true">
                        </x-back.input>
                        <x-back.input
                                col="col-md-6"
                                name='email'
                                title='Email'
                                :value="isset($enseignant) ? $enseignant->email : ''"
                                input='text'
                                :required="true">
                        </x-back.input>
                    </div>


                    <div class="form-row">
                        <x-back.input
                                col="col-md-6"
                                name='telephone'
                                title='Telephone'
                                :value="isset($enseignant) ? $enseignant->telephone : ''"
                                input='text'
                                :required="true">
                        </x-back.input>

                        <x-back.input
                                col="col-md-6"
                                name='adresse'
                                title='Adresse'
                                :value="isset($enseignant) ? $enseignant->adresse : ''"
                                input='text'
                                :required="true">
                        </x-back.input>
                    </div>

                    <button type="submit" class="btn btn-primary">Valider</button>
                </x-back.card>
            </div>


            <div class="col-md-4">
                <x-back.card
                        type='primary'
                        :outline="false"
                        title='Photo'>

                    <div id="holder" class="text-center" style="margin-bottom:15px;">
                        @isset($enseignant)
                            <img style="width:100%;"
                                 {{--src="{{ getImage($enseignant, true) }}" --}}
                                 alt="">
                        @endisset
                    </div>

                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <a id="lfm" data-input="photo" data-preview="holder"
                               class="btn btn-primary text-white btn-outline-secondary"
                               type="button">Bouton</a>
                        </div>

                        <input id="photo" class="form-control {{ $errors->has('photo') ? 'is-invalid' : '' }}"
                               type="text" name="photo"
                                {{--value="{{ old('photo', isset(enseignant) ? getImage(enseignant) : '') }}"--}}
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

