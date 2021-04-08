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
            action="{{ Route::currentRouteName() === 'formation.edit' ? route('formation.update', $formation->id) : route('formation.store') }}">

        @if(Route::currentRouteName() === 'formation.edit')
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
                            title='Formation'>

                        <x-back.input
                                name='libelle'
                                title='Libelle'
                                :value="isset($formation) ? $formation->libelle : ''"
                                input='text'
                                :required="true">
                        </x-back.input>

                        <x-back.input
                                name='slug'
                                title='Slug'
                                :value="isset($formation) ? $formation->slug : ''"
                                input='text'
                                :required="true">
                        </x-back.input>

                        <x-back.input
                                name='description'
                                title='Description'
                                :value="isset($formation) ? $formation->description : ''"
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
                </div>
            </div>


    </form>
@endsection

@section('js')
    {{--@include('back.shared.editorScript')--}}
    @include('back.shared.slugScript')
@endsection
