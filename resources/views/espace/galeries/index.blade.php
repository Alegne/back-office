@extends('espace.parent.layout')

@section('css')

    <style>
        .img-galerie{
            width: 324px !important;
            height: 324px !important;
        }
    </style>

@endsection

@section('content')

    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <h3 class="text-center text-primary">
                    Listes des galeries
                </h3>
                <p class="text-muted text-center">
                    Vous pouvez voir dessous les galeries prises
                </p>
            </div>

        </div>

        <div class="col-12">
            <div class="row">

                @foreach($albums as $album)
                    <div class="col-3">
                        <a href="{{ route('espace.galeries.show', ['album' => $album->id]) }}">
                            <div class="card card-emploi-temps">
                                <div class="card-img-top">
                                    @if($album->photos)
                                        <img src="{{ getImageSingle($album->photos[0], 'card') }}" alt="image"
                                             class="img-fluid img-galerie">
                                    @else
                                        <img src="/bg-eni.jpg" alt="image" class="img-fluid img-galerie">
                                    @endif
                                </div>
                                <div class="card-body">
                                    <p class="card-text text-secondary">{{ $album->titre }}</p>
                                    <p class="card-text text-secondary">{{ formatDateAnnonce($album->created_at) }}</p>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>

            <div class="row justify-content-center">
                {{ $albums->links() }}
            </div>
        </div>
    </div>

@endsection

@section('script')@endsection
