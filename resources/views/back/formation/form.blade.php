@extends('back.parent.layout')

@section('breadcrumb')

    @include('back.parent.partial.breadcrumb', [
        'parent' => 'Pedagogique',
        'parent_route' => '#',
        'child' => 'Formations',
    ])

@endsection

@section('css')
    <style>
        #holder img {
            height: 100%;
            width: 100%;
        }

        #photo_upload {
            min-height: 220px;
            height: auto;
        }
    </style>
@endsection

@section('main')
    <form
            method="post"
            action="{{ Route::currentRouteName() === 'formation.edit' ? route('formation.update', $formation->id) : route('formation.store') }}"
            enctype="multipart/form-data">

        @if(Route::currentRouteName() === 'formation.edit')
            @method('PUT')
        @endif

        @csrf

            <div class="row">
                <div class="col-md-8">

                    <x-back.validation-errors :errors="$errors" />

                    @if(session('ok'))
                        <x-back.alert
                                type='success'
                                title="{!! session('ok') !!}">
                        </x-back.alert>
                    @endif

                    <x-back.card
                            type='primary'
                            title='Formation'>

                        <x-back.input
                                name='libelle'
                                title='Libelle'
                                :value="isset($formation) ? $formation->libelle : ''"
                                input='text'
                                :required="true">
                        </x-back.input>

                        <div class="d-none">
                            <x-back.input
                                    name='slug'
                                    title='Slug'
                                    :value="isset($formation) ? $formation->slug : ''"
                                    input='text'
                                    :required="false">
                            </x-back.input>
                        </div>

                        <x-back.input
                                name='description'
                                title='Description'
                                :value="isset($formation) ? $formation->description : ''"
                                input='textarea'
                                rows=10
                                :required="false">
                        </x-back.input>

                        <button type="submit" class="btn btn-primary">Valider</button>
                    </x-back.card>
                </div>

                <div class="col-md-4">

                    {{-- Upload --}}
                    <x-back.card
                            id="photo_upload"
                            type='primary'
                            :outline="false"
                            title='Image'>

                        <div class="form-group{{ $errors->has('photo') ? ' is-invalid' : '' }}">
                            <label for="changeImage">Image</label>

                            @if(isset($formation) && !$errors->has('photo'))
                                <div>
                                    <p>
                                        @if($formation->photo)
                                            <img src="{{ getImageSingle($formation->photo, true) }}" style="width:100%;">
                                        @else
                                            <img src="{{ asset('/default.png') }}" style="width:100%;">
                                        @endif

                                    </p>
                                    <button type="button" id="changeImage" class="btn btn-warning"
                                            data-update="@if(isset($formation)) show @endif">
                                        Changer d'image</button>
                                </div>
                            @endif
                            <div id="wrapper" class="@if(isset($formation)) d-none @endif">
                                {{--@if(!isset($formation) || $errors->has('photo'))--}}
                                    <div class="custom-file">
                                        <input type="file" id="image_upload" name="photo"
                                               class="{{ $errors->has('photo') ? ' is-invalid ' : '' }} custom-file-input"
                                               @if(Route::currentRouteName() === 'formation.store') required @endif>

                                        <label class="custom-file-label" for="image_upload"></label>

                                        <div class="text-center my-1 py-2" style="margin-bottom:15px;">
                                            <label for="image_upload">
                                                <img id="previewImg" class="m-2" style="width:100%; cursor: pointer;" src=""
                                                     {{--src="{{ getImage($formation, true) }}" --}}
                                                     alt="">
                                            </label>
                                        </div>

                                        <div class="row justify-content-center">
                                            <button type="button" id="btn-delete-image" class="btn btn-outline-danger d-none">Supprimer</button>
                                        </div>


                                        @if ($errors->has('photo'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('photo') }}
                                            </div>
                                        @endif
                                    </div>
                                {{--@endif--}}
                            </div>
                        </div>

                    </x-back.card>
                </div>
            </div>


    </form>
@endsection

@section('js')
    {{--@include('back.shared.editorScript')--}}
    @include('back.shared.slugScript')
    @include('back.shared.ckeditor')


    <script>
        $(document).ready(() => {
            $('form').on('change', '#image_upload', e => {
                $(e.currentTarget).next('.custom-file-label').text(e.target.files[0].name);

                previewFile(e.currentTarget)
            });

            $('#changeImage').click(e => {
                $(e.currentTarget).parent().hide();

                console.log($(e.currentTarget), 'changeImage data-update',
                    $(e.currentTarget).data("update"))

                let show = $.trim($(e.currentTarget).data("update"))

                if ( show === 'show')
                {
                    $('#wrapper').removeClass('d-none')
                }
            });

            $('#btn-delete-image').click(e => {
                $('#previewImg').attr("src", '#')

                $('#photo_upload').css("height", "223px")
                $('#previewImg').css("height", "0px")
                $(e.currentTarget).addClass('d-none')
                $('.custom-file-label').text('')
            })
        });

        function previewFile(input){
            let file = $(input).get(0).files[0]

            if(file){
                let reader = new FileReader()

                reader.onload = function(){
                    $('#previewImg').attr("src", reader.result)

                    $('#previewImg').css("height", "300px")

                    $('#photo_upload').css("height", "600px")

                    $('#btn-delete-image').removeClass('d-none')

                    // console.log($("#previewImg").attr("src"))
                }

                reader.readAsDataURL(file)
            }
        }
    </script>
@endsection
