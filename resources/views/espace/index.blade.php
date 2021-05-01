@extends('espace.parent.layout')

@section('css')@endsection

@section('content')

<div class="row justify-content-center">
    <div class="col-8">
        <div class="card text-center p-3 text-muted">

            <div class="card-img-top">
                @if($data->photo)
                    <img src="{{ getImageSingle($data->photo, 'card') }}"
                         class="img-circle img-fluid rounded-circle w-25 h-100" style="height: 200px !important;" alt="image">
                @else
                    <img src="/logo.png" class="img-circle w-25 h-25" alt="image">
                @endif
            </div>

            <p class="mt-2">Bienvenu {{ $data->nom }}, {{ $data->prenom }}</p>

            <p>
                Vous pouvez changer certaines de vos informations ainsi que votre photo de profile
                dans le <a href="{{ route('espace.profils.index') }}">parametre de l'utilisateur</a>
            </p>

            <p>
                Commencez par voir votre emploi du temps de cette semaine; ou pourquoi pas des annonces ou offre d'emploi
                qui pourraient attirés tes attentions.
            </p>

            <div class="row justify-content-center">
                <div class="col">
                    @if(isset($data))
                        @if(!isset($data->identifiant))
                            @if($data->status == 'actif')
                                <a href="{{ route('espace.emploi_temps.index') }} " class="btn btn-info mr-2">Emploi du temps</a>
                            @endif
                        @endif
                    @endif
                    <a href="{{ route('espace.annonces.index') }}" class="btn btn-info">Annonces ou offre d'emploi</a>
                </div>
            </div>

        </div>
    </div>
</div>


@endsection


@section('script')@endsection
