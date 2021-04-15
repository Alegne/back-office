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
            action="{{ Route::currentRouteName() === 'espace-numerique-travail.edit' ? route('espace-numerique-travail.update', $formation->id) : route('espace-numerique-travail.store') }}">

        @if(Route::currentRouteName() === 'espace-numerique-travail.edit')
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
                        title='Espace Numerique'>

                    <x-back.input
                            name='libelle'
                            title='Libelle'
                            :value="isset($espaceNumerique) ? $espaceNumerique->libelle : ''"
                            input='text'
                            :required="true">
                    </x-back.input>

                    <x-back.input
                            name='description'
                            title='Description'
                            :value="isset($espaceNumerique) ? $espaceNumerique->description : ''"
                            input='textarea'
                            rows=10
                            :required="true">
                    </x-back.input>


                </x-back.card>

                <x-back.card
                        type='danger'
                        :outline="false"
                        title='Specification'>

                    <x-back.input
                            name='parcours_id'
                            title='Parcours'
                            :values="isset($espaceNumerique) ? $espaceNumerique->parcours : collect()"
                            input='selectMultiple'
                            :options="$parcours">
                    </x-back.input>

                    <x-back.input
                            name='niveau_id'
                            title='Niveau'
                            :value="isset($espaceNumerique->niveau) ? $espaceNumerique->niveau->id  : ''"
                            input='select'
                            :options="$niveaux"
                            :required="true">
                    </x-back.input>

                    <x-back.input
                            name='enseignant_id'
                            title='Annee Universitaire'
                            :value="isset($espaceNumerique->annee) ? $espaceNumerique->enseignant->id  : ''"
                            input='select'
                            :options="$enseignants"
                            :required="true">
                    </x-back.input>
                </x-back.card>

                <button type="submit" class="btn btn-primary mb-3">Valider</button>
            </div>

            <div class="col-md-4">
                <x-back.card
                        type='primary'
                        :outline="false"
                        title='Photo'>

                    <div id="holder" class="text-center" style="margin-bottom:15px;">
                        @isset($formation)
                            <img style="width:100%;"
                                 {{--src="{{ getImage($formation, true) }}" --}}
                                 alt="">
                        @endisset
                    </div>

                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <a id="lfm" data-input="image" data-preview="holder"
                               class="btn btn-primary text-white btn-outline-secondary"
                               type="button">Bouton</a>
                        </div>

                        <input id="image" class="form-control {{ $errors->has('photo') ? 'is-invalid' : '' }}"
                               type="text" name="image"
                                {{--value="{{ old('photo', isset($formation) ? getImage($formation) : '') }}"--}}
                        >
                        @if ($errors->has('photo'))
                            <div class="invalid-feedback">
                                {{ $errors->first('photo') }}
                            </div>
                        @endif
                    </div>


                </x-back.card>

                <x-back.card
                        type='primary'
                        :outline="false"
                        title='Fichier'>
                </x-back.card>
            </div>
        </div>


    </form>
@endsection

@section('js')
    {{--@include('back.shared.editorScript')--}}
    @include('back.shared.slugScript')
@endsection
