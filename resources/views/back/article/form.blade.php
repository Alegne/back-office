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
            action="{{ Route::currentRouteName() === 'article.edit' ?
            route('article.update', $article->id) : route('article.store') }}"
            enctype="multipart/form-data"
    >

        @if(Route::currentRouteName() === 'article.edit')
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
                        title='Article'>

                    <x-back.input
                            name='titre'
                            title='Titre'
                            :value="isset($article) ? $article->titre : ''"
                            input='text'
                            :required="true">
                    </x-back.input>

                    <x-back.input
                            name='slug'
                            title='Slug'
                            :value="isset($article) ? $article->slug : ''"
                            input='text'
                            :required="true">
                    </x-back.input>

                    <x-back.input
                            name='posteur'
                            title='Posteur'
                            :value="isset($article) ? $article->posteur : ''"
                            input='text'
                            :required="true">
                    </x-back.input>

                    <x-back.input
                            name='club_id'
                            title='Club'
                            :value="isset($article) ? $article->club->id  : ''"
                            input='select'
                            :options="$clubs"
                            :required="true">
                    </x-back.input>

                    <x-back.input
                            name='description'
                            title='Description'
                            :value="isset($article) ? $article->description : ''"
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

                    <div class="form-group{{ $errors->has('image') ? ' is-invalid' : '' }}">
                        <label for="changeImage">Image</label>
                        @if(isset($article) && !$errors->has('image'))
                            <div>
                                <p>
                                    @if($article->image)
                                        <img src="{{ getImageSingle($article->image, true) }}" style="width:100%;">
                                    @else
                                        <img src="{{ asset('/default.png') }}" style="width:100%;">
                                    @endif
                                </p>
                                <button type="button" id="changeImage" class="btn btn-warning"
                                        data-update="@if(isset($article)) show @endif">
                                    Changer d'image</button>
                            </div>
                        @endif
                        <div id="wrapper" class="@if(isset($article)) d-none @endif">
                            {{--@if(!isset($article) || $errors->has('image'))--}}
                            <div class="custom-file">
                                <input type="file" id="image_upload" name="image"
                                       class="{{ $errors->has('image') ? ' is-invalid ' : '' }} custom-file-input"
                                       @if(Route::currentRouteName() === 'article.store') required @endif>

                                <label class="custom-file-label" for="image_upload"></label>

                                <div class="text-center my-1 py-2" style="margin-bottom:15px;">
                                    <label class="label" for="image_upload">
                                        <img id="previewImg" class="m-2" style="width:100%; cursor: pointer;" src=""
                                             {{--src="{{ getImage($article, true) }}" --}}
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
