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
            action="{{ Route::currentRouteName() === 'etudiant.edit' ? route('etudiant.update', $etudiant->id) : route('etudiant.store') }}">

        @if(Route::currentRouteName() === 'etudiant.edit')
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
                        title='Etudiant'>

                    <input type="hidden" name="password" value="password">

                    <div class="form-row">
                        <x-back.input
                                col="col-md-6"
                                name='numero'
                                title='Numero'
                                :value="isset($etudiant) ? $etudiant->numero : ''"
                                input='text'
                                :required="true">
                        </x-back.input>
                        <x-back.input
                                col="col-md-6"
                                name='cin'
                                title='CIN'
                                :value="isset($etudiant) ? $etudiant->cin : ''"
                                input='text'
                                :required="true">
                        </x-back.input>
                    </div>

                    <div class="form-row">
                        <x-back.input
                                col="col-md-6"
                                name='nom'
                                title='Nom'
                                :value="isset($etudiant) ? $etudiant->nom : ''"
                                input='text'
                                :required="true">
                        </x-back.input>

                        <x-back.input
                                col="col-md-6"
                                name='prenom'
                                title='Prenom'
                                :value="isset($etudiant) ? $etudiant->prenom : ''"
                                input='text'
                                :required="true">
                        </x-back.input>
                    </div>

                    <div class="form-row">
                        <x-back.input
                                col="col-md-6"
                                name='date_naissance'
                                title='Date de Naissance'  {{-- date("dd-mm-YYYY", strtotime($date_from_controller)); --}}
                                :value="isset($etudiant) ? formatDateChiffre($etudiant->date_naissance) : ''"
                                input='date'
                                :required="true">
                        </x-back.input>
                        <x-back.input
                                col="col-md-6"
                                name='lieu_naissance'
                                title='Lieu de Naissance'
                                :value="isset($etudiant) ? $etudiant->lieu_naissance : ''"
                                input='text'
                                :required="true">
                        </x-back.input>
                    </div>


                    <div class="form-row">
                        <x-back.input
                                col="col-md-6"
                                name='email'
                                title='Adresse Mail'
                                :value="isset($etudiant) ? $etudiant->email : ''"
                                input='text'
                                :required="true">
                        </x-back.input>

                        <x-back.input
                                col="col-md-6"
                                name='adresse'
                                title='Adresse'
                                :value="isset($etudiant) ? $etudiant->adresse : ''"
                                input='text'
                                :required="true">
                        </x-back.input>
                    </div>


                    <x-back.input
                            name='status'
                            title='Status'
                            :value="isset($etudiant) ? $etudiant->status  : collect()"
                            input='select'
                            :options="$status"
                            :required="true">
                    </x-back.input>

                    {{--@php(dd(isset($etudiant)))--}}



                    @if(Route::currentRouteName() === 'etudiant.create')
                    <div class="form-row">
                        <x-back.input
                                col="col-md-4"
                                name='parcours_id'
                                title='Parcours'
                                :value="isset($etudiant) ? $etudiant->parcours->id  : ''"
                                input='select'
                                :options="$parcours"
                                :required="true">
                        </x-back.input>



                        <x-back.input
                                col="col-md-4"
                                name='niveau_id'
                                title='Niveau'
                                :value="isset($etudiant->niveau) ? $etudiant->niveau[0]->id  : ''"
                                input='select'
                                :options="$niveaux"
                                :required="true">
                        </x-back.input>

                        <x-back.input
                                col="col-md-4"
                                name='annee_id'
                                title='Annee Universitaire'
                                :value="isset($etudiant->annee) ? $etudiant->annee[0]->id  : ''"
                                input='select'
                                :options="$annees"
                                :required="true">
                        </x-back.input>
                    </div>
                    @endif

                    <button type="submit" class="btn btn-primary">Valider</button>
                </x-back.card>
            </div>


            <div class="col-md-4">
                <x-back.card
                        type='primary'
                        :outline="false"
                        title='Photo'>

                    <div id="holder" class="text-center" style="margin-bottom:15px;">
                        @isset($etudiant)
                            <img style="width:100%;"
                                 {{--src="{{ getImage($etudiant, true) }}" --}}
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
                                {{--value="{{ old('photo', isset($etudiant) ? getImage($etudiant) : '') }}"--}}
                        >
                        @if ($errors->has('photo'))
                            <div class="invalid-feedback">
                                {{ $errors->first('photo') }}
                            </div>
                        @endif
                    </div>


                </x-back.card>

                @if(Route::currentRouteName() === 'etudiant.edit')
                <x-back.card
                        type='success'
                        :outline="false"
                        title='Niveau avec Anne Universitaire'>


                    <div class="form-row">
                        <x-back.input
                                col="col-md-4"
                                name='niveau_id'
                                :values="isset($etudiant) ? $etudiant->niveau : collect()"
                                input='selectMultiple'
                                :options="$niveaux">
                        </x-back.input>
                        <x-back.input
                                col="col-md-6"
                                name='annee_id'
                                :values="isset($etudiant) ? $etudiant->annee : collect()"
                                input='selectMultiple'
                                :options="$annees">
                        </x-back.input>
                    </div>
                </x-back.card>
                @endif
            </div>
        </div>


    </form>
@endsection

@section('js')
    {{--@include('back.shared.editorScript')--}}
    @include('back.shared.slugScript')
@endsection
