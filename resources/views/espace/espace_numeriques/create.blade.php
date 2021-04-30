@extends('espace.parent.layout')

@section('css')


    <!-- Select 2 -->
    <link rel="stylesheet" href="/admin/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="/admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">


@endsection

@section('content')


    <form action="{{ route('espace.espace_numerique.store') }}"
          method="post"
          enctype="multipart/form-data">

        @csrf

        <x-back.validation-errors :errors="$errors" />

        <input type="hidden" name="enseignant_id" value="{{ isset($enseignant) ?  $enseignant : 1}}">

        @if(session('ok'))

            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {!! session('ok') !!}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if(isset($ok))

            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {!! $ok !!}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <div class="row">

            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">

                        <div class="form-group">
                            <label>Libelle</label>
                            <input type="text" class="form-control {{ $errors->has('libelle') ? ' is-invalid' : '' }}"
                                   name="libelle"
                                   value="{{ old('titre') }}"
                                   required>

                            @if ($errors->has('libelle'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('libelle') }}
                                </div>
                            @endif

                        </div>

                        <div class="form-row">

                            {{--<div id="vue-specification" class="row d-none">--}}
                            <div id="option-niveau" class="col-6">
                                <div class="form-group">
                                    <label>Niveau</label>
                                    <select class="form-control" name="niveau_id">

                                        @foreach($niveaux as $key => $valeur)
                                            <option value="{{ $key }}">{{ $valeur }}</option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>
                            <div id="option-parcours" class="col-6 ">
                                <div class="form-group">
                                    <label>Parcous</label>
                                    <select class="form-control" name="parcours_id" multiple>

                                        @foreach($parcours as $key => $valeur)
                                            <option value="{{ $key }}">{{ $valeur }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            {{--</div>--}}

                        </div>

                        <div class="form-group">
                            <label>Description</label>
                            <textarea name="description" class="form-control {{ $errors->has('description') ? ' is-invalid' : '' }}"
                                      id="" cols="30" rows="10"></textarea>


                            @if ($errors->has('description'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('description') }}
                                </div>
                            @endif
                        </div>

                    </div>
                </div>
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
        })
    </script>

@endsection
