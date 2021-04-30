@extends('espace.parent.layout')

@section('css')@endsection

@section('content')

<div class="row">

    @if($show)
    <div class="col-12 justify-content-start mx-3 mb-2">
        <a href="{{ route('espace.espace_numerique.create.form') }}" class="btn btn-primary">Publier</a>
    </div>
    @endif

    <div class="col-12">
        <div class="col-md-12">
            <div class="card strpied-tabled-with-hover">
                <div class="card-header ">
                    <h4 class="card-title text-center">Votre espace Numerique de travail</h4>
                    <p class="card-category text-center">Vous pouvez voir dans ce tableau tous les lecons numeriques que les enseignants ont ajoutés
                        pour le niveau <strong>{{ $niveaux }} {{ $parcours }}</strong>
                    </p>
                </div>
                <div class="card-body table-full-width table-responsive">
                    <table class="table table-hover table-striped justify-content-center ml-2">
                        <thead>
                            <tr>
                                <th>Libelle</th>
                                <th>Enseignant</th>
                                <th>Date de publication</th>
                                <th>Voir</th>
                            </tr>
                        </thead>
                        <tbody>

                        @foreach($numeriques as $numerique)
                        <tr>
                            <td>{{ $numerique->libelle }}</td>
                            <td>{{ $numerique->enseignant->nom }}</td>
                            <td>{{ formatDate($numerique->created_at) }}</td>
                            <td>
                                <a href="{{ route('espace.espace_numerique.show', ['numerique' => $numerique->id]) }}"
                                   style=""
                                   class="px-3 btn btn-xs mx-1 btn-primary">
                                    <i class="fa fa-eye text-primary"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    <div class="row justify-content-center">
                        {{ $numeriques->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')@endsection
