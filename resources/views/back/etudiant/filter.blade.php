@extends('back.parent.layout')

@section('css')
    <link rel="stylesheet" href="/admin/dist/css/loading.css">

    <style>
        .card-img-top {
            width: 100px !important;
            height: 100px !important;
        }
    </style>
@endsection

@section('main')

    <div class="row" id="etudiant-filter">
        <etudiant-filter-page></etudiant-filter-page>
    </div>

@endsection

@section('js')

    <script src="{{ mix('js/app.js') }}"></script>
@endsection
