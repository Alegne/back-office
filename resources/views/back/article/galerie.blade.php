@extends('back.parent.layout')

@section('breadcrumb')

    @include('back.parent.partial.breadcrumb', [
        'parent' => 'Activites',
        'parent_route' => route('article.index'),
        'child' => 'Articles',
    ])

@endsection

@section('css')

    <link rel="stylesheet" href="/admin/plugins/dropzone/min/dropzone.min.css">
    <link rel="stylesheet" href="/admin/plugins/toastr/toastr.min.css">
    <link rel="stylesheet" href="/admin/plugins/OwlCarousel2/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="/admin/plugins/OwlCarousel2/assets/owl.theme.default.min.css">

    <style>

        .dropzone.dz-clickable {
            cursor: pointer;
        }

        .dropzone {
            border: 2px dashed #0087F7;
            border-radius: 5px;
            background: white;
        }

        .card-img-top{
            width: 150px !important;
            height: 150px !important;
        }

    </style>
@endsection

@section('main')

    <div class="row">
        <div class="col-md-4">
            <x-back.card
                    type='primary'
                    :outline="false"
                    title='Article'>
                <ul class="list-group">
                    <li class="list-group-item">Titre    : <strong>{{ $article->titre }}</strong> </li>
                    <li class="list-group-item">Club : <strong>{{ $article->club->libelle }}</strong> </li>

                </ul>
            </x-back.card>

            <div class="row justify-content-start m-2">
                <a href="{{ route('article.create', ['ok' => 1]) }}"
                   class="btn btn-primary">Valider</a>
            </div>
        </div>
        <div class="col-md-8">
            <x-back.card
                    type='primary'
                    title='Galeries | Glisser ici vos images'>

                <form action="{{ route('article.galeries.upload', ['article' => $article->id]) }}"
                      method="post"
                      class="dropzone"
                      data-delete="{{ route('article.galeries.delete', ['article' => $article->id]) }}"
                      id="dropzone" enctype="multipart/form-data">
                    @csrf
                </form>

            </x-back.card>


            @isset($article->galerie)

                @if(count($article->galerie) > 0)
                    <x-back.card
                            type='primary'
                            title='Vos fichiers'>


                        <div class="owl-carousel owl-theme">
                            @foreach($article->galerie as $galerie)
                                <div class="item">
                                    <div class="card  justify-content-center mx-1" >
                                        @if(in_array(Str::lower(explode('.', $galerie)[1]), ['jpeg','pjpeg','png','gif','jpg']))
                                            <img class="card-img-top m-auto" src="{{ getImageSingle($galerie, 'card') }}" alt="Card image cap">
                                        @else
                                            <img class="card-img-top m-auto" src="/default.png" alt="Card image cap">
                                        @endif
                                        <div class="card-body m-auto">
                                            <button type="button" data-name="{{ $galerie }}" class="btn btn-danger btn-supprimer-image">Supprimer</button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                    </x-back.card>
                @endif
            @else
                <p class="text-secondary">AUCUN Galeries</p>
            @endisset
        </div>
    </div>

@endsection

@section('js')

    <script type="text/javascript" src="/admin/plugins/dropzone/min/dropzone.min.js"></script>
    <script type="text/javascript" src="/admin/plugins/toastr/toastr.min.js"></script>
    <script type="text/javascript" src="/admin/plugins/OwlCarousel2/owl.carousel.min.js"></script>

    <script type="text/javascript">
        Dropzone.options.dropzone = {
            acceptedFiles: ".jpeg,.jpg,.png,.PNG,.gif",
            maxFilesize: 12,
            renameFile: function(file) {
                let dt   = new Date();
                let time = dt.getTime();

                let name = file.name.split(' ').join('')
                // let name = file.name.replace(/\s+/g, '')

                console.log('Origin : ', file.name, time + file.name, name)
                // return time + file.name;
                return time + name;

                //return file.name;
            },
            // acceptedFiles: ".jpeg,.jpg,.png,.gif",
            addRemoveLinks: true,
            timeout: 5000,
            success: function(file, response)
            {
                console.log(response);
            },
            error: function(file, response)
            {
                console.log(file, response)
                return false;
            },
            removedfile: function(file)
            {
                let name = file.upload.filename;

                let route = document.querySelector('#dropzone').dataset.delete

                let token = $('meta[name="csrf-token"]').attr('content')

                /*$.ajaxSetup({
                    headers:{
                        'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
                    }
                });*/

                console.log('remove', name, route, token)

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': token
                    },
                    type: 'POST',
                    url: route,
                    data: {filename: name},
                    success: function (data){
                        console.log("File has been successfully removed!!");
                    },
                    error: function(e) {
                        console.log(e);
                    }});

                let fileRef;
                return (fileRef = file.previewElement) != null ?
                    fileRef.parentNode.removeChild(file.previewElement) : void 0;
            },
        }

        $(function () {
            $(".owl-carousel").owlCarousel();

            $('.btn-supprimer-image').click(function () {

                let name = $(this).data('name')

                let route = document.querySelector('#dropzone').dataset.delete

                let token = $('meta[name="csrf-token"]').attr('content')

                console.log('Supprimer', name, route, $(this).parent('div').parent('div') ,
                    $(this).closest('div'))

                let element = $(this).parent('div').parent('div')
                let element_2 = $(this).closest('div')

                console.log('element 1', element)
                //console.log('element 2', element_2)

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': token
                    },
                    type: 'POST',
                    url: route,
                    data: {filename: name},
                    success: function (data){

                        element.remove()
                        console.log("File has been successfully removed!!");
                        toastr.success("Success", 'Suppresion')
                    },
                    error: function(e) {
                        console.log(e);
                    }})
            })
        })
    </script>

@endsection
