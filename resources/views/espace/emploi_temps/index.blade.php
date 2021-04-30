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

            @foreach($emploiTemps as $item)
            <div class="col-3">
                <a href="{{ route('espace.emploi_temps.show', ['emploiTemps' => $item->id]) }}">
                    <div class="card card-emploi-temps">
                    <div class="card-img-top">
                        <img src="/calendar.jpg" alt="image" class="img-fluid">
                    </div>
                    <div class="card-body">
                        <p class="card-text text-secondary">
                            Semaine du
                        <div class="text-primary">
                            {{ formatDateItem($item->date_debut) }}
                            -
                            {{ formatDateItem($item->date_fin) }}
                        </div>
                        </p>
                    </div>
                </div>
                </a>
            </div>
            @endforeach
        </div>

        <div class="row justify-content-center">
            {{ $emploiTemps->links() }}
        </div>
    </div>
</div>

@endsection

@section('script')@endsection
