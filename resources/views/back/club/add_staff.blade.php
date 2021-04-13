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
            action="{{ route('club.staff.add') }}">

        @csrf

        <div class="row">

            <div class="col-md-4">
                <x-back.card
                        type='danger'
                        :outline="false"
                        title='Club'>

                    <div id="holder" class="text-center" style="margin-bottom:15px;">
                        @isset($club)
                            <img style="width:100%;"
                                 {{--src="{{ getImage($club, true) }}" --}}
                                 alt="">
                        @endisset
                    </div>

                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">Club : {{ $club->libelle }}</li>
                    </ul>
                </x-back.card>
            </div>

            <div class="col-md-8">

                <x-back.card
                        type='info'
                        title='Staff'>

                    <p>Membre</p>
                    @if(count($club->staffs) > 0)
                        @foreach($club->staffs as $staff)
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">{{ $staff->etudiant->numero }} | {{ $staff->etudiant->nom }} | {{ $staff->type }}</li>
                            </ul>
                        @endforeach
                    @else
                        <p class="text-danger text-center">Aucun Membre</p>
                    @endif
                </x-back.card>

                <x-back.card
                        type='primary'
                        title='Ajouter Staff'>

                    <x-back.validation-errors :errors="$errors" />

                    @if(session('ok'))
                        <x-back.alert
                                type='success'
                                title="{!! session('ok') !!}">
                        </x-back.alert>
                    @endif

                    <input type="hidden" name="club_id" value="{{ $club->id }}">

                    <x-back.input
                            name='type'
                            title='Type'
                            :value="isset($club) ? ''  : ''"
                            input='select'
                            :options="$types"
                            :required="true">
                    </x-back.input>

                    <x-back.input
                            name='etudiant_id'
                            title='Etudiant'
                            :value="isset($club) ? ''  : ''"
                            input='select'
                            :options="$etudiants"
                            :required="true">
                    </x-back.input>

                    <button type="submit" id="btn-submit" class="btn btn-primary">Valider</button>
                </x-back.card>
            </div>
        </div>


    </form>
@endsection

@section('js')
    {{--@include('back.shared.editorScript')--}}
    @include('back.shared.slugScript')
@endsection
