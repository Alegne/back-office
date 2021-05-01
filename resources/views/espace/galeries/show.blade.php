@extends('espace.parent.layout')

@section('css')


    <link rel="stylesheet" href="/admin/plugins/OwlCarousel2/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="/admin/plugins/OwlCarousel2/assets/owl.theme.default.min.css">

    <style>

        .img-album {
            max-width: 100% !important;
            height: auto !important;
        }

        .image-block{
            /*float:left; */
            width:100%;
            margin-bottom:10px;
        }

        .image-carourel-nrh{
            width: 324px !important;
            height: 324px !important;
        }
    </style>

@endsection

@section('content')


    <div class="row justify-content-center">

        <div class="col-12 justify-content-start mx-1 mb-2">
            <a href="{{ route('espace.galeries.index') }}" class="btn btn-primary">Retour</a>
        </div>

        <div class="col-12">

            <h3 class="my-2"> {{ $album->titre }}</h3>

            <p class=" text-muted my-2"> Publié le {{ formatDate($album->created_at) }}</p>

            <hr class="my-1">
            <h2 class="">Description</h2>

            <div class="jumbotron-fluid my-5">
                {!! $album->description !!}
            </div>
        </div>


        <div class="col-12">
            @isset($album->photos)

                @if(count($album->photos) > 0)

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Galeries</h3>
                        </div>
                        <div class="card-body">
                            <div class="owl-carousel owl-theme">

                                @foreach($album->photos as $photo)
                                    <div class="item">
                                        <div class="card  justify-content-center mx-1" >
                                            @if(in_array(Str::lower(explode('.', $photo)[1]), ['jpeg','pjpeg','png','gif','jpg']))
                                                <img class="card-img-top m-auto image-carourel-nrh" src="{{ getImageSingle($photo, true) }}"
                                                     alt="Card image cap">
                                            @else
                                                <img class="card-img-top m-auto image-carourel-nrh" src="/default.png" alt="Card image cap">
                                            @endif
                                        </div>
                                    </div>
                                @endforeach

                            </div>
                        </div>
                    </div>
                @endif
            @else
                <p class="text-secondary">AUCUN Galeries</p>
            @endisset
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
