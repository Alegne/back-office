@extends('back.parent.layout')

@section('breadcrumb')

    @include('back.parent.partial.breadcrumb', [
        'parent' => 'Pedadogique',
        'parent_route' => route('etudiant.index'),
        'child' => 'Etudiants',
    ])

@endsection

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

@section('main')

    <div class="row">
        <div class="col-md-12">
            <x-back.card
                    type='primary'
                    title='Exporter en Excel'>

                <form action="{{ route('etudiant.excel.export') }}" method="get">

                    <div class="row justify-content-center">
                        {{-- Status --}}
                        <div class="card col-md-2 ml-1">
                            <div class="card-header">Status</div>
                            <div class="card-body">
                                @foreach($status as $key => $value)
                                    <div class="form-check" >
                                        <input class="form-check-input" name="status[]"
                                               type="checkbox" value="{{ $key }}"
                                        @isset($data['status'])
                                            @foreach($data['status'] as $data_item)
                                                {{ $data_item == $key ? 'checked' : '' }}
                                                    @endforeach
                                                @endisset
                                        >
                                        <label class="form-check-label">
                                            {{ $value }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- Niveaux --}}
                        <div class="card col-md-2 ml-1">
                            <div class="card-header">Niveaux</div>
                            <div class="card-body">
                                @foreach($niveaux as $niveau)
                                    <div class="form-check">
                                        <input class="form-check-input" name="niveaux[]" type="checkbox"
                                               value="L1"
                                        @isset($data['niveaux'])
                                            @foreach($data['niveaux'] as $niveaux)
                                                {{ $niveaux == $niveau ? 'checked' : '' }}
                                                    @endforeach
                                                @endisset
                                        >
                                        <label class="form-check-label">{{ $niveau }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- Parcours --}}
                        <div class="card col-md-2 ml-1">
                            <div class="card-header">Parcours</div>
                            <div class="card-body">
                                @foreach($parcours as $parcours_item)
                                    <div class="form-check">
                                        <input class="form-check-input" name="parcours[]" type="checkbox"
                                               value="GB"
                                        @isset($data['parcours'])
                                            @foreach($data['parcours'] as $niveaux)
                                                {{ $niveaux == $parcours_item ? 'checked' : '' }}
                                                    @endforeach
                                                @endisset
                                        >
                                        <label class="form-check-label">{{ $parcours_item }} </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- Annee Univesitaire --}}
                        <div class="card col-md-2 ml-1">
                            <div class="card-header">Annee Univesitaire</div>
                            <div class="card-body">
                                @foreach($annees as $annee)
                                    <div class="form-check">
                                        <input class="form-check-input" name="annees[]" type="checkbox"
                                               value="2020-2021"
                                        @isset($data['annees'])
                                            @foreach($data['annees'] as $niveaux)
                                                {{ $niveaux == $annee ? 'checked' : '' }}
                                                    @endforeach
                                                @endisset
                                        >
                                        <label class="form-check-label">{{ $annee }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary"> Exporter</button>
                </form>
            </x-back.card>
        </div>
        <div class="col-md-12">

            <x-back.card
                    type='primary'
                    title='Importer en Excel'>

                <form action="{{ route('etudiant.excel.import') }}"
                      method="post"
                      class="dropzone"
                      id="dropzone" enctype="multipart/form-data">
                    @csrf

                </form>

                {{--<button type="button" id="btn-sync" class="btn btn-primary mt-2">Synchronisation</button>--}}

            </x-back.card>
        </div>
    </div>

@endsection

@section('js')

    <script type="text/javascript" src="/admin/plugins/dropzone/min/dropzone.min.js"></script>
    <script type="text/javascript" src="/admin/plugins/toastr/toastr.min.js"></script>
    <script type="text/javascript" src="/admin/plugins/OwlCarousel2/owl.carousel.min.js"></script>

    <script type="text/javascript">
        Dropzone.options.dropzone = {
            acceptedFiles: 'application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
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
                if (response.ok)
                {
                    console.log(response.ok);
                    toastr.success("Success", 'Importation')
                } else{
                    toastr.error("Error", 'Importation Erreur, Veuillez verifier les donnees')
                }
            },
            error: function(file, response)
            {
                console.log(file, response)
                return false;
            },
            removedfile: function(file){
            },
        }
    </script>

@endsection
