@extends('espace.parent.layout')

@section('css')

    <link rel="stylesheet" href="/admin/plugins/OwlCarousel2/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="/admin/plugins/OwlCarousel2/assets/owl.theme.default.min.css">

    <style>

        .img-nrh-card{
            width: 200px !important;
            height: 100px !important;
        }

    </style>

@endsection

@section('content')


<div class="row">

    <div class="col-12 justify-content-start mx-1 mb-2">
        <a href="{{ route('espace.espace_numerique.index') }}" class="btn btn-primary">Retour</a>
    </div>


    <div class="col-4">
        <div class="card">
            <div class="card-header">
                <p class="card-title">Espace Numerique</p>
            </div>
            <div class="card-body">
                <ul class="list-group">
                    <li class="list-group-item">Libelle    : <strong>{{ $numerique->libelle }}</strong> </li>
                    <li class="list-group-item">Niveau     : <strong>{{ $numerique->niveau->tag }}</strong></li>
                    <li class="list-group-item">Enseignant : <strong>{{ $numerique->enseignant->nom }}</strong></li>
                    <li class="list-group-item">Parcours   :
                        @foreach($numerique->parcours as $parcours)
                            <strong>{{ $parcours->tag }}</strong>
                        @endforeach
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Pieces Jointes</h5>
            </div>


            {{--<div class="card-body">
                <div class="row">--}}
                @isset($numerique->pieces_jointes)
                    @if(count($numerique->pieces_jointes) > 0)

                            {{--@foreach($numerique->pieces_jointes as $piece)
                                <div class="col-3 card mx-1">
                                    <div class="card-body" >
                                        @if(in_array(Str::lower(explode('.', $piece)[1]), ['jpeg','pjpeg','png','gif','jpg']))
                                            <img class="card-img-top m-auto img-nrh-card" src="{{ getImageSingle($piece, 'card') }}" alt="Card image cap">
                                        @else
                                            <img class="card-img-top m-auto img-nrh-card" src="/default.png" alt="Card image cap">
                                        @endif
                                    </div>
                                    <div class="card-footer">

                                        @if(in_array(Str::lower(explode('.', $piece)[1]), ['jpeg','pjpeg','png','gif','jpg']))
                                            <a href="{{ asset('storage/images/' . $piece) }}" class="btn btn-primary">Telecharger</a>
                                        @else
                                            <a href="{{ asset('storage/fichiers/' . $piece) }}" class="btn btn-primary">Telecharger</a>
                                        @endif
                                    </div>
                                </div>
                            @endforeach--}}


                                <div class="card-body">
                                    <div class="owl-carousel owl-theme">

                                        @foreach($numerique->pieces_jointes as $piece)
                                            <div class="item">
                                                <div class="card  justify-content-center mx-1" >

                                                    @if(in_array(Str::lower(explode('.', $piece)[1]), ['jpeg','pjpeg','png','gif','jpg']))
                                                        <img class="card-img-top m-auto img-nrh-card image-carourel-nrh" src="{{ getImageSingle($piece, 'card') }}"
                                                             alt="Card image cap">
                                                    @else
                                                        <img class="card-img-top m-auto img-nrh-card image-carourel-nrh" src="/fichier.png" alt="Card image cap">
                                                    @endif

                                                    <div class="card-footer mt-2">

                                                        <div class="row justify-content-center mx-auto">
                                                            <div class="col-4">
                                                                @if(in_array(Str::lower(explode('.', $piece)[1]), ['jpeg','pjpeg','png','gif','jpg']))
                                                                    <a href="{{ asset('storage/images/' . $piece) }}" class="btn btn-primary">Telecharger</a>
                                                                @else
                                                                    <a href="{{ asset('storage/fichiers/' . $piece) }}" class="btn btn-primary">Telecharger</a>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach

                                    </div>
                                </div>
                    @endif
                @else
                {{--</div>--}}
                <p class="text-secondary">AUCUN Pieces Jointes</p>
                @endisset
            {{--</div>--}}
        </div>
    </div>
</div>



@endsection


@section('script')

    <script type="text/javascript" src="/admin/plugins/OwlCarousel2/owl.carousel.min.js"></script>
    <script type="text/javascript">

        $(function () {
            $(".owl-carousel").owlCarousel();
        })

    </script>

@endsection
