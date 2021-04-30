@extends('back.parent.layout')

@section('breadcrumb')

    @include('back.parent.partial.breadcrumb', [
        'parent' => 'Actualites',
        'parent_route' => route('album.index'),
        'child' => 'Album',
    ])

@endsection

@section('css')@endsection

@section('main')
    <form
            method="post"

            action="{{ Route::currentRouteName() === 'album.edit' ?
            route('album.update', $album->id) : route('album.store') }}"
            enctype="multipart/form-data">

        @if(Route::currentRouteName() === 'album.edit')
            @method('PUT')
        @endif

        @csrf

        <div class="row  justify-content-center">
            <div class="col-md-8">

                <x-back.validation-errors :errors="$errors" />

                @if(session('ok'))
                    <x-back.alert
                            type='success'
                            title="{!! session('ok') !!}">
                    </x-back.alert>
                @endif

                @if(isset($ok))
                    <x-back.alert
                            type='success'
                            title="{!! $ok !!}">
                    </x-back.alert>
                @endif

                <x-back.card
                        type='primary'
                        title='Album'>

                    <x-back.input
                            name='titre'
                            title='Titre'
                            :value="isset($album) ? $album->titre : ''"
                            input='text'
                            :required="true">
                    </x-back.input>

                    <x-back.input
                            name='description'
                            title='Description'
                            :value="isset($album) ? $album->description : ''"
                            input='textarea'
                            rows=10
                            :required="false">
                    </x-back.input>

                    <button type="submit" class="btn btn-primary">Valider</button>
                </x-back.card>
            </div>
        </div>
    </form>
@endsection

@section('js')
    {{--@include('back.shared.editorScript')--}}
    @include('back.shared.slugScript')
    @include('back.shared.ckeditor')
@endsection
