@extends('espace.parent.layout')

@section('css')@endsection

@section('content')

    <div class="row justify-content-center">

        <div class="col-12 justify-content-start mx-1 mb-2">
            <a href="#" class="btn btn-primary">Publier</a>
        </div>

        <div class="col-12">
            <div class="card">
                <h3 class="text-center text-primary">
                    Listes des Annonces
                </h3>
                <p class="text-muted text-center">
                    Vous pouvez voir dessous vos anciens, le present ainsi que les annonces publient
                </p>
            </div>

        </div>

        <div class="col-12">
            <div class="row">
                <div class="col-3">

                    <a href="#">
                        <div class="card card-annonces">
                            <div class="card-img-top">
                                <img src="/bg-eni.jpg" alt="image" class="img-fluid">
                            </div>
                            <div class="card-body">
                                <p class="card-text text-secondary">
                                    titre
                                </p>
                                <p class="text-muted">publier le 12/03/08</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')@endsection
