@extends('back.parent.layout')

@section('breadcrumb')

    @include('back.parent.partial.breadcrumb', [
        'parent' => 'Pedagogique',
        'parent_route' => route('matiere.index'),
        'child' => 'Matiers',
    ])

@endsection

@section('css')
@endsection

@section('main')
    <form
            method="post"
            action="{{ Route::currentRouteName() === 'matiere.edit' ? route('matiere.update', $matiere->id) :
                                                                       route('matiere.store') }}"
            enctype="multipart/form-data">

        @if(Route::currentRouteName() === 'matiere.edit')
            @method('PUT')
        @endif

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
                        title='Emploi du temps'>

                    <input type="hidden" name="password" value="password">

                    <div class="form-row">
                        <x-back.input
                                col="col-md-6"
                                name='libelle'
                                title='Libelle'
                                :value="isset($matiere) ? $matiere->libelle : ''"
                                input='text'
                                :required="true">
                        </x-back.input>

                        <div class="form-group col-md-6">
                            <label for="">Couleur</label>
                            <input
                                    type="color"
                                    class="form-control {{ $errors->has('couleur') ? ' is-invalid' : '' }}"
                                    id="couleur"
                                    name="couleur"
                                    value="{{ old('couleur', isset($matiere) ? $matiere->couleur : '') }}"
                                    required>
                            @if ($errors->has('couleur'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('couleur') }}
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="form-row">
                        <x-back.input
                                col="col-md-4"
                                name='enseignant_id'
                                title='Enseignant'
                                :value="isset($matiere) ? $matiere->enseignant->id  : ''"
                                input='select'
                                :options="$enseignants"
                                :required="true">
                        </x-back.input>
                        <x-back.input
                                col="col-md-4"
                                name='parcours_id'
                                title='Parcours'
                                :values="isset($matiere) ? $matiere->parcours  : collect()"
                                input='selectMultiple'
                                :options="$parcours"
                                :required="true">
                        </x-back.input>
                        <x-back.input
                                col="col-md-4"
                                name='niveau_id'
                                title='Niveau'
                                :value="isset($matiere->niveau) ? $matiere->niveau->id  : ''"
                                input='select'
                                :options="$niveaux"
                                :required="true">
                        </x-back.input>
                    </div>

                    <button type="submit" class="btn btn-primary">Valider</button>
                </x-back.card>
            </div>
        </div>


    </form>
@endsection

@section('js')
@endsection
