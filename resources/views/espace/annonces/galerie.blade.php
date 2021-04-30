@extends('espace.parent.layout')

@section('css')


    <link rel="stylesheet" href="/admin/plugins/dropzone/min/dropzone.min.css">
    <link rel="stylesheet" href="/admin/plugins/toastr/toastr.min.css">


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

@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Annonce</h2>
                </div>

                <div class="card-body">
                    <ul class="list-group">
                        <li class="list-group-item">Titre    : <strong>{{ $annonce->titre }}</strong> </li>
                        <li class="list-group-item">Type    : <strong>{{ $annonce->type }}</strong> </li>
                        <li class="list-group-item">Parcours   :
                            @foreach($annonce->parcours as $parcours)
                                <strong>{{ $parcours->tag }}</strong>
                            @endforeach
                        </li>
                        <li class="list-group-item">Niveaux   :
                            @foreach($annonce->niveau as $niveau)
                                <strong>{{ $niveau->tag }}</strong>
                            @endforeach
                        </li>
                    </ul>
                </div>

            </div>

            <div class="row justify-content-start m-2">
                <a href="{{ route('espace.annonces.create.form', ['ok' => 1]) }}"
                   class="btn btn-primary">Valider</a>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">

                <div class="card-header">
                    <h2 class="card-title">Galeries | Glisser ici vos fichiers</h2>
                </div>

                <div class="card-body">
                    <form action="{{ route('espace.annonces.galeries.upload', ['annonce' => $annonce->id]) }}"
                          method="post"
                          class="dropzone"
                          data-delete="{{ route('espace.annonces.galeries.delete', ['annonce' => $annonce->id]) }}"
                          id="dropzone" enctype="multipart/form-data">
                        @csrf
                    </form>
                </div>


            </div>
        </div>
    </div>

@endsection


@section('script')

    <script type="text/javascript" src="/admin/plugins/dropzone/min/dropzone.min.js"></script>
    <script type="text/javascript" src="/admin/plugins/toastr/toastr.min.js"></script>

    <script type="text/javascript">


        Dropzone.options.dropzone = {
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


    </script>
@endsection
