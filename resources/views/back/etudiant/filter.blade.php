@extends('back.parent.layout')

@section('breadcrumb')

    @include('back.parent.partial.breadcrumb', [
        'parent' => 'Pedadogique',
        'parent_route' => route('etudiant.index'),
        'child' => 'Etudiants',
    ])

@endsection

@section('css')
    <link rel="stylesheet" href="/admin/dist/css/loading.css">

    <style>

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
