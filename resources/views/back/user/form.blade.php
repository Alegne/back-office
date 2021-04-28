@extends('back.parent.layout')

@section('breadcrumb')

    @include('back.parent.partial.breadcrumb', [
        'parent' => 'Parametres',
        'parent_route' => '#',
        'child' => 'Comptes',
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
            action="{{ Route::currentRouteName() === 'user.edit' ? route('user.update', $user->id) : route('user.store') }}"
            enctype="multipart/form-data">

        @if(Route::currentRouteName() === 'user.edit')
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
                        title='user'>

                    <div class="form-row">
                        <x-back.input
                                col="col-md-6"
                                name='identifiant'
                                title='Identifiant'
                                :value="isset($user) ? $user->identifiant : ''"
                                input='text'
                                :required="true">
                        </x-back.input>
                        <x-back.input
                                col="col-md-6"
                                name='email'
                                title='Email'
                                :value="isset($user) ? $user->email : ''"
                                input='text'
                                :required="true">
                        </x-back.input>
                    </div>

                    {{--<div class="form-row">
                        <x-back.input
                                col="col-md-6"
                                name='password'
                                title='Mot de Passe'
                                :value="isset($user) ? $user->password : ''"
                                input='text'
                                :required="true">
                        </x-back.input>

                        <x-back.input
                                col="col-md-6"
                                name='password_confirm'
                                title='Mot de Passe Confirmer'
                                :value="isset($user) ? $user->password : ''"
                                input='text'
                                :required="true">
                        </x-back.input>
                    </div>--}}

                    <div class="form-row justify-content-start">


                        <x-back.input
                                col="col-md-6"
                                name='role'
                                title='Role'
                                :value="isset($user) ? $user->role  : ''"
                                input='select'
                                :options="$roles"
                                :required="true">
                        </x-back.input>
                    </div>

                    <button type="submit" class="btn btn-primary">Valider</button>
                </x-back.card>
            </div>


            <div class="col-md-4">
                <x-back.card
                        id="photo_upload"
                        type='primary'
                        :outline="false"
                        title='Photo'>

                    <div class="form-group{{ $errors->has('photo') ? ' is-invalid' : '' }}">
                        <label for="changeImage">Image</label>
                        @if(isset($user) && !$errors->has('photo'))
                            <div>
                                <p>
                                    @if($user->photo)
                                        <img src="{{ getImageSingle($user->photo, true) }}" style="width:100%;">
                                    @else
                                        <img src="{{ asset('/default.png') }}" style="width:100%;">
                                    @endif
                                </p>
                                <button type="button" id="changeImage" class="btn btn-warning"
                                        data-update="@if(isset($user)) show @endif">
                                    Changer d'image</button>
                            </div>
                        @endif
                        <div id="wrapper" class="@if(isset($user)) d-none @endif">
                            {{--@if(!isset($user) || $errors->has('photo'))--}}
                            <div class="custom-file">
                                <input type="file" id="image_upload" name="photo"
                                       class="{{ $errors->has('photo') ? ' is-invalid ' : '' }} custom-file-input"
                                       @if(Route::currentRouteName() === 'user.store') required @endif>

                                <label class="custom-file-label" for="image_upload"></label>

                                <div class="text-center my-1 py-2" style="margin-bottom:15px;">
                                    <label class="label" for="image_upload">
                                        <img id="previewImg" class="m-2" style="width:100%; cursor: pointer;" src=""
                                             {{--src="{{ getImage($user, true) }}" --}}
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

