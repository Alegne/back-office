@extends('back.parent.layout')


@section('breadcrumb')

    @include('back.parent.partial.breadcrumb', [
        'parent' => 'Pedagogique',
        'parent_route' => '#',
        'child' => 'Espace Numerique',
    ])

@endsection

@section('css')
    <style>
        #holder img {
            height: 100%;
            width: 100%;
        }

        .custom-file-container__image-clear:hover {
            text-decoration: none;
        }

        .custom-file-container__image-multi-preview{
            width: 200px !important;
            height: 200px !important;
        }

        .lightbox{
            width: 200px !important;
            height: 200px !important;
        }
    </style>

    <link rel="stylesheet" href="/admin/plugins/file-upload-with-preview/file-upload-with-preview.min.css">


    <!-- Ekko Lightbox -->
    <link rel="stylesheet" href="/admin/plugins/ekko-lightbox/ekko-lightbox.css">
@endsection

@section('main')
    <form
            method="post"
            action="{{ Route::currentRouteName() === 'espace-numerique-travail.edit' ?
            route('espace-numerique-travail.update', $espaceNumerique->id) :
            route('espace-numerique-travail.store') }}"
            enctype="multipart/form-data">

        <input type="hidden" value="{{ route('espace-numerique-travail.create', ['etape' => 1]) }}">

        @if(Route::currentRouteName() === 'espace-numerique-travail.edit')
            @method('PUT')
        @endif

        @csrf

            <div class="row justify-content-center">
                <x-back.validation-errors :errors="$errors" />

                @if(session('ok'))
                    <x-back.alert
                            type='success'
                            title="{!! session('ok') !!}">
                    </x-back.alert>
                @endif



                @if(isset($ok))
                    <x-back.alert
                            type='success'
                            title="{!! $ok !!}">
                    </x-back.alert>
                @endif

            </div>

        <div class="row">
            <div class="col-md-8">

                <x-back.card
                        type='primary'
                        title='Espace Numerique'>

                    <x-back.input
                            name='libelle'
                            title='Libelle'
                            :value="isset($espaceNumerique) ? $espaceNumerique->libelle : ''"
                            input='text'
                            :required="true">
                    </x-back.input>

                    <x-back.input
                            name='description'
                            title='Description'
                            :value="isset($espaceNumerique) ? $espaceNumerique->description : ''"
                            input='textarea'
                            rows=10
                            :required="false">
                    </x-back.input>


                </x-back.card>
            </div>

            <div class="col-md-4">

                <x-back.card
                        type='primary'
                        :outline="false"
                        title='Specification'>

                    <x-back.input
                            name='parcours_id'
                            title='Parcours'
                            :values="isset($espaceNumerique) ? $espaceNumerique->parcours : collect()"
                            input='selectMultiple'
                            :options="$parcours">
                    </x-back.input>

                    <x-back.input
                            name='niveau_id'
                            title='Niveau'
                            :value="isset($espaceNumerique->niveau) ? $espaceNumerique->niveau->id  : ''"
                            input='select'
                            :options="$niveaux"
                            :required="true">
                    </x-back.input>

                    <x-back.input
                            name='enseignant_id'
                            title='Enseignant'
                            :value="isset($espaceNumerique->annee) ? $espaceNumerique->enseignant->id  : ''"
                            input='select'
                            :options="$enseignants"
                            :required="true">
                    </x-back.input>
                </x-back.card>
            </div>
        </div>

            {{--@if(isset($espaceNumerique))
                @if(count($espaceNumerique->pieces_jointes))
                    <div class="row">
                        <div class="col-12">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h4 class="card-title">Pieces Jointes</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">

                                        @foreach($espaceNumerique->pieces_jointes as $jointe)
                                            <div class="col-sm-2">
                                                @if(in_array(explode('.', $jointe)[1], [
                                                            'jpeg',
                                                            'pjpeg',
                                                            'png',
                                                            'gif',
                                                            'jpg'
                                                        ]))
                                                    <a href="{{ getImageSingle($jointe, true) }}" data-toggle="lightbox" data-title="sample 1 - white" data-gallery="gallery">

                                                        <img src="{{ getImageSingle($jointe, true) }}"
                                                             class="img-fluid lightbox mb-2" alt="Images"/>
                                                    </a>
                                                @else
                                                    <a href="{{ asset('storage/fichiers/fichier.png') }}" data-toggle="lightbox" data-title="sample 1 - white" data-gallery="gallery">

                                                        <img src="{{ asset('storage/fichiers/fichier.png') }}"
                                                             class="img-fluid lightbox mb-2" alt="Fichier"/>
                                                    </a>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endif


            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="custom-file-container" data-upload-id="myUniqueUploadId">
                        <label>Supprimer tous
                            <a
                                    href="javascript:void(0)"
                                    class="custom-file-container__image-clear"
                                    title="Supprimer les fichiers"
                                    style="">&times;</a>
                        </label>
                        <label class="custom-file-container__custom-file">
                            <input
                                    type="file"
                                    class="custom-file-container__custom-file__custom-file-input"
                                    accept="*"
                                    multiple
                                    aria-label="Choisir les fichiers"
                                    name="pieces_jointes[]"
                            />
                            <input type="hidden" name="MAX_FILE_SIZE" value="10485760" />
                            <span class="custom-file-container__custom-file__custom-file-control"></span>
                        </label>
                        <div class="custom-file-container__image-preview"></div>
                    </div>
                </div>
            </div>--}}

        <button type="submit" class="btn btn-primary mb-3">Valider</button>
    </form>
@endsection

@section('js')
    {{--@include('back.shared.editorScript')--}}
    @include('back.shared.slugScript')
    @include('back.shared.ckeditor')


    {{--<script type="text/javascript" src="/admin/plugins/file-upload-with-preview/file-upload-with-preview.min.js"></script>

    <script type="text/javascript">
        var upload = new FileUploadWithPreview("myUniqueUploadId");
    </script>


    <!-- Ekko Lightbox -->
    <script src="/admin/plugins/ekko-lightbox/ekko-lightbox.min.js"></script>

    <script type="text/javascript">
        $(function () {
            $(document).on('click', '[data-toggle="lightbox"]', function(event) {
                event.preventDefault();
                $(this).ekkoLightbox({
                    alwaysShowClose: true
                });
            });
        })
    </script>--}}
@endsection
