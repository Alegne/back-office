@extends('back.parent.layout')


@section('breadcrumb')

    @include('back.parent.partial.breadcrumb', [
        'parent' => 'Actualites',
        'parent_route' => route('annonce.index'),
        'child' => 'Annonces',
    ])

@endsection

@section('css')
    <style>
        #holder img {
            height: 100%;
            width: 100%;
        }
    </style>
@endsection

@section('main')
    <form
            method="post"

            action="{{ Route::currentRouteName() === 'annonce.edit' ?
            route('annonce.update', $annonce->id) : route('annonce.store') }}"
            enctype="multipart/form-data">

        @if(Route::currentRouteName() === 'annonce.edit')
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

                @if(isset($ok))
                    <x-back.alert
                            type='success'
                            title="{!! $ok !!}">
                    </x-back.alert>
                @endif

                <x-back.card
                        type='primary'
                        title='Annonce'>

                    <x-back.input
                            name='titre'
                            title='Titre'
                            :value="isset($annonce) ? $annonce->titre : ''"
                            input='text'
                            :required="true">
                    </x-back.input>

                    <x-back.input
                            name='description'
                            title='Description'
                            :value="isset($annonce) ? $annonce->description : ''"
                            input='textarea'
                            rows=10
                            :required="false">
                    </x-back.input>

                    <button type="submit" class="btn btn-primary">Valider</button>
                </x-back.card>
            </div>

            <div class="col-md-4">

                <x-back.card
                        id="autre"
                        type='primary'
                        :outline="false"
                        title='Specification'>
                    <div class="row justify-content-center">
                        <x-back.input
                                col="col"
                                name='niveau_id'
                                title='Niveau'
                                :values="isset($annonce) ? $annonce->niveau : collect()"
                                input='selectMultiple'
                                :options="$niveaux">
                        </x-back.input>

                        <x-back.input
                                col="col"
                                name='parcours_id'
                                title='Parcours'
                                :values="isset($annonce) ? $annonce->parcours : collect()"
                                input='selectMultiple'
                                :options="$parcours">
                        </x-back.input>
                    </div>

                    <div class="row justify-content-center">

                        <x-back.input
                                col="col"
                                name='type'
                                title='Visibilite'
                                :value="isset($annonce) ? $annonce->type : ''"
                                input='select'
                                :options="$types">
                        </x-back.input>

                        @if(Route::currentRouteName() === 'annonce.edit')
                            <x-back.input
                                    col="col"
                                    name='approuve'
                                    label='Approuve'
                                    :value="isset($annonce) ? $annonce->approuve : ''"
                                    input='checkbox'>
                            </x-back.input>
                        @endif
                    </div>
                </x-back.card>

                {{-- Upload --}}
                <x-back.card
                        id="photo_upload"
                        type='primary'
                        :outline="false"
                        title='Image Principale'>

                    <div class="form-group{{ $errors->has('image') ? ' is-invalid' : '' }}">
                        <label for="changeImage">Image</label>
                        @if(isset($annonce) && !$errors->has('image'))
                            <div>
                                <p>
                                    @if($annonce->image)
                                        <img src="{{ getImageSingle($annonce->image, true) }}" style="width:100%;">
                                    @else
                                        <img src="{{ asset('/default.png') }}" style="width:100%;">
                                    @endif
                                </p>
                                <button type="button" id="changeImage" class="btn btn-warning"
                                        data-update="@if(isset($annonce)) show @endif">
                                    Changer d'image</button>
                            </div>
                        @endif
                        <div id="wrapper" class="@if(isset($annonce)) d-none @endif">
                            {{--@if(!isset($annonce) || $errors->has('image'))--}}
                            <div class="custom-file">
                                <input type="file" id="image_upload" name="image"
                                       class="{{ $errors->has('image') ? ' is-invalid ' : '' }} custom-file-input"
                                       @if(Route::currentRouteName() === 'annonce.store') required @endif>

                                <label class="custom-file-label" for="image_upload"></label>

                                <div class="text-center my-1 py-2" style="margin-bottom:15px;">
                                    <label class="label" for="image_upload">
                                        <img id="previewImg" class="m-2" style="width:100%; cursor: pointer;" src=""
                                             {{--src="{{ getImage($formation, true) }}" --}}
                                             alt="">
                                    </label>
                                </div>

                                <div class="row justify-content-center">
                                    <button type="button" id="btn-delete-image" class="btn btn-outline-danger d-none">Supprimer</button>
                                </div>


                                @if ($errors->has('image'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('image') }}
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

                /*console.log($(e.currentTarget), 'changeImage data-update',
                    $(e.currentTarget).data("update"))*/

                let show = $.trim($(e.currentTarget).data("update"))

                if ( show === 'show')
                {
                    $('#wrapper').removeClass('d-none')

                    // $("label[for='image_upload']").click()
                    $('.label').click()

                    console.log('changeImage open')
                }
            });

            $('#btn-delete-image').click(e => {
                $('#previewImg').attr("src", '#')

                $('#photo_upload').css("height", "223px")
                $('#previewImg').css("height", "0px")
                $(e.currentTarget).addClass('d-none')
                $('.custom-file-label').text('')
            })

            // console.log('Update', $('#date_naissance_clone').val())
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
