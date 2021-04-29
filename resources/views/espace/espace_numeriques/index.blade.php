@extends('espace.parent.layout')

@section('css')@endsection

@section('content')

<div class="row">

    <div class="col-12">
        <div class="card">
            <h3 class="text-center text-primary">
                Votre espace Numerique de travail
            </h3>
            <p class="text-muted text-center">

            </p>
        </div>

    </div>

    <div class="col-12">
        <div class="col-md-12">
            <div class="card strpied-tabled-with-hover">
                <div class="card-header ">
                    <h4 class="card-title text-center">Votre espace Numerique de travail</h4>
                    <p class="card-category text-center">Vous pouvez voir dans ce tableau tous les lecons numeriques que les enseignants ont ajoutés
                        pour le niveau <strong>M1 GB</strong>
                    </p>
                </div>
                <div class="card-body table-full-width table-responsive">
                    <table class="table table-hover table-striped justify-content-center ml-2">
                        <thead>
                            <tr>
                                <th>Libelle</th>
                                <th>Description</th>
                                <th>Enseignant</th>
                                <th>Voir</th>
                            </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>Libelle</td>
                            <td>Description</td>
                            <td>enseignant</td>
                            <td>
                                <a href="#" type="button"
                                   style=""
                                   class="px-3 btn btn-xs mx-1 btn-primary">
                                    <i class="fa fa-eye text-primary"></i>
                                </a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')@endsection
