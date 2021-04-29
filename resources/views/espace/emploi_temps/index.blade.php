@extends('espace.parent.layout')

@section('css')@endsection

@section('content')

<div class="row justify-content-center">
    <div class="col-12">
        <div class="card">
            <h3 class="text-center text-primary">
                Listes de votre Emploi du temps
            </h3>
            <p class="text-muted text-center">
                Vous pouvez voir dessous vos anciens, le present ainsi que votre emploi du temps
                dans les semaines à venir.
            </p>
        </div>

    </div>

    <div class="col-12">
        <div class="row">
            <div class="col-3">

                <a href="#">
                    <div class="card card-emploi-temps">
                    <div class="card-img-top">
                        <img src="/bg-eni.jpg" alt="image" class="img-fluid">
                    </div>
                    <div class="card-body">
                        <p class="card-text text-secondary">
                            Semaine du <div class="text-primary">10/04/21-15/04/21</div>
                        </p>
                    </div>
                </div>
                </a>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')@endsection
