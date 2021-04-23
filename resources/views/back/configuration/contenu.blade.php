@extends('back.parent.layout')

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
            action="{{ route('configuration.update') }}" enctype="multipart/form-data">
        @method('PUT')

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
                        title='Configuration'>

                    <x-back.input
                            name='nom_directeur'
                            title='Nom de Directeur'
                            :value="getConfiguration('nom_directeur')"
                            input='text'
                            :required="true">
                    </x-back.input>

                    <x-back.input
                            name='mot_directeur'
                            title='Mot de Directeur'
                            :value="getConfiguration('mot_directeur')"
                            input='textarea'
                            rows=10
                            :required="true">
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
                        title='Photo Upload'>

                    <div class="form-group{{ $errors->has('image_directeur') ? ' is-invalid' : '' }}">
                        <label for="changeImage">Image</label>

                        @if(getConfiguration('image_directeur') && !$errors->has('image_directeur'))
                            <div>
                                <p>
                                    @if(getConfiguration('image_directeur'))
                                        <img src="{{ getImageSingle(getConfiguration('image_directeur'), true) }}" style="width:100%;">
                                    @else
                                        <img src="{{ asset('/default.png') }}" style="width:100%;">
                                    @endif
                                </p>
                                <button type="button" id="changeImage" class="btn btn-warning"
                                        data-update="@if(getConfiguration('image_directeur')) show @endif">
                                    Changer d'image</button>
                            </div>
                        @endif
                        <div id="wrapper" class="@if(getConfiguration('image_directeur')) d-none @endif">
                            {{--@if(!isset($formation) || $errors->has('photo'))--}}
                            <div class="custom-file">
                                <input type="file" id="image_upload" name="image_directeur"
                                       class="{{ $errors->has('image_directeur') ? ' is-invalid ' : '' }} custom-file-input"
                                       value="{{ old('image_directeur', getConfiguration('image_directeur') != null ? getConfiguration('image_directeur') : '') }}">

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


                                @if ($errors->has('image_directeur'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('image_directeur') }}
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
    <script>
        $(document).ready(() => {

            console.log($('#image_upload').attr('value'))

            if ($('#image_upload').attr('value') != '') {
                $('#image_upload').next('.custom-file-label').text($('#image_upload').attr('value'))

                console.log('COndition FIle', $('#image_upload').attr('value'))
            }

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
