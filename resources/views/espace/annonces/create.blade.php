@extends('espace.parent.layout')

@section('css')


    <!-- Select 2 -->
    <link rel="stylesheet" href="/admin/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="/admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">

    <style>
        .width-100 {
            width: 100% !important;
        }
    </style>

@endsection

@section('content')

    <form action="{{ route('espace.annonces.store') }}"
          method="post"
          enctype="multipart/form-data">

        <div class="row">

            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">

                        <div class="form-group">
                            <label>Titre</label>
                            <input type="text" class="form-control {{ $errors->has('titre') ? ' is-invalid' : '' }}"
                                   name="titre"
                                   value="{{ old('titre') }}"
                                   required>

                            @if ($errors->has('titre'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('titre') }}
                                </div>
                            @endif

                        </div>


                        <div class="form-row">
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Type</label>
                                    <select class="form-control" name="type" id="select-type">
                                        <option value="public">Public</option>
                                        <option value="private">Private</option>
                                    </select>
                                </div>

                            </div>

                            {{--<div id="vue-specification" class="row d-none">--}}
                                <div id="option-niveau" class="col-4 d-none">
                                    <div class="form-group">
                                        <label>Niveau</label>
                                        <select class="form-control" name="niveau_id" multiple>
                                            <option value="1">L1</option>
                                            <option value="2">L2</option>
                                            <option value="3">L3</option>
                                            <option value="4">M1</option>
                                        </select>
                                    </div>

                                </div>
                                <div id="option-parcours" class="col-4 d-none ">
                                    <div class="form-group">
                                        <label>Parcous</label>
                                        <select class="form-control" name="parcours_id" multiple>
                                            <option value="1">GB</option>
                                            <option value="1">SR</option>
                                        </select>
                                    </div>
                                </div>
                            {{--</div>--}}

                        </div>

                        <div class="form-group">
                            <label>Description</label>
                            <textarea name="descrption" class="form-control" id="" cols="30" rows="10"></textarea>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <label for="input-image" style="cursor:pointer;">
                        <div class="card-img-top">
                            <img src="/logo.png" id="img-preview" alt="Image" style="width:100%;">
                        </div>

                        <div class="card-body">
                            <div class="row justify-content-center">
                                <div class="col-4">
                                    <label  class="btn btn-secondary" for="input-image" style="cursor:pointer;">
                                        Image
                                    </label>
                                </div>
                            </div>

                        </div>
                    </label>
                </div>

                <input type="file" class="d-none" name="image" id="input-image">
            </div>

            <div class="row justify-content-start mx-3">

                <button type="submit" class="btn-primary btn">Valider</button>
            </div>
        </div>
    </form>

@endsection


@section('script')


    <!-- Select 2 -->
    <script src="/admin/plugins/select2/js/select2.min.js"></script>

    @include('back.shared.ckeditor')

    <script>
        $(function() {
            $('select').select2();

            $('#select-type').change(function (e) {
                console.log('Value', $(this).val())

                if ($(this).val() == 'private')
                {
                    $('#option-niveau').removeClass('d-none')
                    $('#option-parcours').removeClass('d-none')
                    $('#option-niveau').addClass('width-100')
                    $('#option-parcours').addClass('width-100')


                } else {
                    $('#option-niveau').addClass('d-none')
                    $('#option-parcours').addClass('d-none')
                }
            })
        });
    </script>

@endsection
