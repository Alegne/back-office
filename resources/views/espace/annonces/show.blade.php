@extends('espace.parent.layout')

@section('css')


    <link rel="stylesheet" href="/admin/plugins/OwlCarousel2/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="/admin/plugins/OwlCarousel2/assets/owl.theme.default.min.css">

    <style>

        .img-annonce {
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
        <a href="{{ route('espace.annonces.index') }}" class="btn btn-primary">Retour</a>
    </div>

    <div class="col-12">

        <div class="image-block">
            @if($annonce->image)
                <img src="{{ getImageSingle($annonce->image) }}"
                     class="img-fluid img-annonce" alt="Image principale">
            @else
                <img src="/bg-eni.jpg" class="img-fluid img-annonce" alt="Image principale">
            @endif
        </div>

        <h1 class="my-2"> {{ $annonce->titre }}</h1>

        <p class="lead my-2"> Publié le {{ formatDate($annonce->created_at) }}</p>

        <hr class="my-1">
        <h1 class="display-4">Description</h1>

        <div class="jumbotron-fluid my-5">
            {!! $annonce->description !!}
        </div>
    </div>


    <div class="col-12">
        @isset($annonce->galerie)

            @if(count($annonce->galerie) > 0)

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Galeries</h3>
                    </div>
                    <div class="card-body">
                        <div class="owl-carousel owl-theme">

                            @foreach($annonce->galerie as $galerie)
                                <div class="item">
                                    <div class="card  justify-content-center mx-1" >
                                        @if(in_array(Str::lower(explode('.', $galerie)[1]), ['jpeg','pjpeg','png','gif','jpg']))
                                            <img class="card-img-top m-auto image-carourel-nrh" src="{{ getImageSingle($galerie, true) }}"
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
