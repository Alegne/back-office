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
            action="{{ Route::currentRouteName() === 'club.edit' ? route('club.update', $club->id) : route('club.store') }}">

        @if(Route::currentRouteName() === 'club.edit')
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
                        title='club'>

                    <x-back.input
                            name='libelle'
                            title='Nom du club'
                            :value="isset($club) ? $club->libelle : ''"
                            input='text'
                            :required="true">
                    </x-back.input>

                    <x-back.input
                            name='description'
                            title='Description'
                            :value="isset($club) ? $club->description : ''"
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
                        @isset($club)
                            <img style="width:100%;"
                                 {{--src="{{ getImage($club, true) }}" --}}
                                 alt="">
                        @endisset
                    </div>

                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <a id="lfm" data-input="image" data-preview="holder"
                               class="btn btn-primary text-white btn-outline-secondary"
                               type="button">Bouton</a>
                        </div>

                        <input id="image" class="form-control {{ $errors->has('image') ? 'is-invalid' : '' }}"
                               type="text" name="image"
                                {{--value="{{ old('photo', isset($club) ? getImage($club) : '') }}"--}}
                        >
                        @if ($errors->has('image'))
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
