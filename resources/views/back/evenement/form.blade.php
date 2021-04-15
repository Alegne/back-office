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
            action="{{ Route::currentRouteName() === 'evenement.edit' ? route('evenement.update', $evenement->id) : route('evenement.store') }}">

        @if(Route::currentRouteName() === 'evenement.edit')
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
                        title='Evenement'>

                    <x-back.input
                            name='titre'
                            title='Titre'
                            :value="isset($evenement) ? $evenement->titre : ''"
                            input='text'
                            :required="true">
                    </x-back.input>

                    <x-back.input
                            name='slug'
                            title='Slug'
                            :value="isset($evenement) ? $evenement->slug : ''"
                            input='text'
                            :required="true">
                    </x-back.input>

                    <x-back.input
                            name='posteur'
                            title='Posteur'
                            :value="isset($evenement) ? $evenement->posteur : ''"
                            input='text'
                            :required="true">
                    </x-back.input>

                    <x-back.input
                            name='type'
                            title='Type'
                            :value="isset($evenement) ? $evenement->type  : ''"
                            input='select'
                            :options="$types"
                            :required="true">
                    </x-back.input>

                    <x-back.input
                            name='description'
                            title='Description'
                            :value="isset($evenement) ? $evenement->description : ''"
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
                        title='image'>

                    <div id="holder" class="text-center" style="margin-bottom:15px;">
                        @isset($evenement)
                            <img style="width:100%;"
                                 {{--src="{{ getImage($evenement, true) }}" --}}
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
                                {{--value="{{ old('image', isset($evenement) ? getImage($evenement) : '') }}"--}}
                        >
                        @if ($errors->has('image'))
                            <div class="invalid-feedback">
                                {{ $errors->first('image') }}
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
