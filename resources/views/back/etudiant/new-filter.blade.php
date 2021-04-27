@extends('back.parent.layout')

@section('css')
    <link rel="stylesheet" href="/admin/dist/css/loading.css">

    <style>

    </style>
@endsection

@section('main')


    <div class="row">

        <div class="col-12">
            <div class="row mx-1" id="section-filter">

                {{--@dd($data)--}}
                @include('back.etudiant.filter._filter', ['data' => $data])

            </div>

            <div class="row mx-1">
                <div class="col-12">
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">Etudiants | Total : {{ $etudiants->total() }}</h3>
                            <div class="card-tools pull-right">
                                <button
                                        type="button"
                                        class="btn btn-tool"
                                        data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row justify-content-center" id="section-etudiants">

                               @include('back.etudiant.filter._etudiants', ['etudiants' => $etudiants])
                            </div>
                        </div>

                        <div class="card-footer">
                            {{ $etudiants->appends($data)->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection

@section('js')

@endsection
