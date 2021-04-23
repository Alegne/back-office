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
            action="{{ Route::currentRouteName() === 'etudiant.edit' ? route('etudiant.update', $etudiant->id) :
                                                                       route('etudiant.store') }}"
            enctype="multipart/form-data">

        @if(Route::currentRouteName() === 'etudiant.edit')
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
                        title='Etudiant'>

                    <input type="hidden" name="password" value="password">

                    <div class="form-row">
                        <x-back.input
                                col="col-md-6"
                                name='numero'
                                title='Numero'
                                :value="isset($etudiant) ? $etudiant->numero : ''"
                                input='text'
                                :required="true">
                        </x-back.input>
                        <x-back.input
                                col="col-md-6"
                                name='cin'
                                title='CIN'
                                :value="isset($etudiant) ? $etudiant->cin : ''"
                                input='text'
                                :required="true">
                        </x-back.input>
                    </div>

                    <div class="form-row">
                        <x-back.input
                                col="col-md-6"
                                name='nom'
                                title='Nom'
                                :value="isset($etudiant) ? $etudiant->nom : ''"
                                input='text'
                                :required="true">
                        </x-back.input>

                        <x-back.input
                                col="col-md-6"
                                name='prenom'
                                title='Prenom'
                                :value="isset($etudiant) ? $etudiant->prenom : ''"
                                input='text'
                                :required="true">
                        </x-back.input>
                    </div>

                    <div class="form-row">
                        <x-back.input
                                col="col-md-6"
                                name='date_naissance'
                                title='Date de Naissance'  {{-- date("dd-mm-YYYY", strtotime($date_from_controller)); --}}
                                :value="isset($etudiant) ? formatDateChiffre($etudiant->date_naissance) : ''"
                                input='date'
                                :required="true">
                        </x-back.input>

                        <input type="hidden" id="date_naissance_clone"
                        value="{{ old('date_naissance', isset($etudiant) ? $etudiant->date_naissance : '') }}">
                        {{--value="{{ old('photo', isset($etudiant) ? getImage($etudiant->date_naissance) : '') }}"--}}

                        <x-back.input
                                col="col-md-6"
                                name='lieu_naissance'
                                title='Lieu de Naissance'
                                :value="isset($etudiant) ? $etudiant->lieu_naissance : ''"
                                input='text'
                                :required="true">
                        </x-back.input>
                    </div>


                    <div class="form-row">
                        <x-back.input
                                col="col-md-6"
                                name='email'
                                title='Adresse Mail'
                                :value="isset($etudiant) ? $etudiant->email : ''"
                                input='text'
                                :required="true">
                        </x-back.input>

                        <x-back.input
                                col="col-md-6"
                                name='adresse'
                                title='Adresse'
                                :value="isset($etudiant) ? $etudiant->adresse : ''"
                                input='text'
                                :required="true">
                        </x-back.input>
                    </div>


                    <x-back.input
                            name='status'
                            title='Status'
                            :value="isset($etudiant) ? $etudiant->status  : collect()"
                            input='select'
                            :options="$status"
                            :required="true">
                    </x-back.input>

                    {{--@php(dd(isset($etudiant)))--}}




                    <div class="form-row">
                        <x-back.input
                                col="col-md-4"
                                name='parcours_id'
                                title='Parcours'
                                :value="isset($etudiant) ? $etudiant->parcours->id  : ''"
                                input='select'
                                :options="$parcours"
                                :required="true">
                        </x-back.input>

                        @if(Route::currentRouteName() === 'etudiant.create')
                            <x-back.input
                                col="col-md-4"
                                name='niveau_id'
                                title='Niveau'
                                :value="isset($etudiant->niveau) ? $etudiant->niveau[0]->id  : ''"
                                input='select'
                                :options="$niveaux"
                                :required="true">
                            </x-back.input>

                            <x-back.input
                                col="col-md-4"
                                name='annee_id'
                                title='Annee Universitaire'
                                :value="isset($etudiant->annee) ? $etudiant->annee[0]->id  : ''"
                                input='select'
                                :options="$annees"
                                :required="true">
                            </x-back.input>

                        @endif
                    </div>

                    <button type="submit" class="btn btn-primary">Valider</button>
                </x-back.card>
            </div>


            <div class="col-md-4">

                @if(Route::currentRouteName() === 'etudiant.edit')
                <x-back.card
                        type='success'
                        :outline="false"
                        title='Niveau avec Anne Universitaire'>


                    <div class="form-row">
                        <x-back.input
                                col="col-md-4"
                                name='niveau_id'
                                :values="isset($etudiant) ? $etudiant->niveau : collect()"
                                input='selectMultiple'
                                :options="$niveaux">
                        </x-back.input>
                        <x-back.input
                                col="col-md-6"
                                name='annee_id'
                                :values="isset($etudiant) ? $etudiant->annee : collect()"
                                input='selectMultiple'
                                :options="$annees">
                        </x-back.input>
                    </div>
                </x-back.card>
                @endif

                {{-- Upload --}}
                <x-back.card
                        id="photo_upload"
                        type='primary'
                        :outline="false"
                        title='Photo Upload'>

                    <div class="form-group{{ $errors->has('photo') ? ' is-invalid' : '' }}">
                        <label for="changeImage">Image</label>

                        @if(isset($etudiant) && !$errors->has('photo'))
                            <div>
                                <p>
                                    @if($etudiant->photo)
                                        <img src="{{ getImageSingle($etudiant->photo, true) }}" style="width:100%;">
                                    @else
                                        <img src="{{ asset('/default.png') }}" style="width:100%;">
                                    @endif
                                </p>
                                <button type="button" id="changeImage" class="btn btn-warning"
                                        data-update="@if(isset($etudiant)) show @endif">
                                    Changer d'image</button>
                            </div>
                        @endif
                        <div id="wrapper" class="@if(isset($etudiant)) d-none @endif">
                            {{--@if(!isset($formation) || $errors->has('photo'))--}}
                            <div class="custom-file">
                                <input type="file" id="image_upload" name="photo"
                                       class="{{ $errors->has('photo') ? ' is-invalid ' : '' }} custom-file-input"
                                       value="{{ old('photo', isset($etudiant) ? $etudiant->photo : '') }}"
                                @if(Route::currentRouteName() === 'etudiant.store') required @endif>

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

    <script type="text/javascript" src="/admin/plugins/moment/moment.min.js"></script>

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

            // console.log('Update', $('#date_naissance_clone').val())

            if ($('#date_naissance_clone').val())
            {
                let data_input = $('#date_naissance_clone').val() // Oct 23

                let dateObject = new Date(data_input)

                let dateString = moment(dateObject).format('YYYY-MM-DD');
                console.log('Moment.js', dateString) // Output: 2020-07-21

                $('#date_naissance').val(dateString)
            }
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
