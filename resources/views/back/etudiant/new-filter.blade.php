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
                @include('back.etudiant.filter._filter', [
                    'data'       => $data,
                    'niveaux'    => $niveaux,
                    'parcours'   => $parcours,
                    'annees'     => $annees,
                    'formations' => $formations,
                    'status'     => $status,
                ])

            </div>

            <div class="row mx-1">
                <div class="col-12">
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">Etudiants  | Total : {{ $etudiants->total() }} </h3>
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

                                {{--@dd($etudiants)--}}
                               {{--@include('back.etudiant.filter._etudiants', ['etudiants' => $etudiants])--}}

                                @isset($etudiants)
                                    @if(count($etudiants))
                                        @foreach($etudiants as $etudiant)
                                            @include('back.etudiant.filter._card', ['etudiant' => $etudiant])
                                        @endforeach
                                    @else
                                        <p class="text-center text-danger"> AUCUN ETUDIANT</p>
                                    @endif

                                @else
                                    <p class="text-center text-danger"> NO CRITERE</p>
                                @endisset

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

    {{-- Modal --}}
    <div class="modal" id="modal-info" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">ETUDIANT</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card mx-1">
                        <img class="card-img-top" id="modal-image" src="/default.png" alt="Card image cap">

                        <div class="card-body">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <td scope="col">Numero Etudiant</td>
                                    <td scope="col" id="modal-numero"></td>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>Nom</td>
                                    <td id="modal-nom"></td>
                                </tr>
                                <tr>
                                    <td>Status</td>
                                    <td id="modal-status"></td>
                                </tr>
                                <tr>
                                    <td>Niveau</td>
                                    <td id="modal-niveau"></td>
                                </tr>
                                <tr>
                                    <td>Parcours</td>
                                    <td id="modal-parcours"></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')

    <script type="text/javascript">
        $(function () {
            console.log('JS')

            $('.etudiant').click(function () {
                let id = $(this).attr('id')

                let route = $(this).data('route')

                console.log(id, route)

                $('#modal-numero').text('')
                $('#modal-nom').text('')
                $('#modal-status').text('')
                $('#modal-niveau').text('')
                $('#modal-parcours').text('')
                // $('#modal-image').attr('src', ' ')

                $.ajax({
                    url     : route,
                    type    : "GET",
                    success : function(data)
                    {
                        $('#modal-numero').text(data.data.numero)
                        $('#modal-nom').text(data.data.nom + ' ' + data.data.prenom)
                        $('#modal-status').text(data.data.status)
                        $('#modal-niveau').text(data.data.niveau[0])
                        $('#modal-parcours').text(data.data.parcours)

                        if (data.data.photo){
                            $('#modal-image').attr('src', data.data.photo)
                        }


                        $('#modal-info').modal('toggle')

                        console.log(data)
                    }
                })
            })

            /*$('.etudiant').each(function( index ) {

                console.log(index, this)
                this.click(function () {
                    let id = $(this).attr('id')

                    let route = $(this).data('route')

                    console.log(id, route)

                    $('#modal-numero').text('')
                    $('#modal-nom').text('')
                    $('#modal-status').text('')
                    $('#modal-niveau').text('')
                    $('#modal-parcours').text('')
                    $('#modal-image').attr('src', ' ')

                    $.ajax({
                        url     : route,
                        type    : "GET",
                        success : function(data)
                        {
                            $('#modal-numero').text(data.data.numero)
                            $('#modal-nom').text(data.data.nom + ' ' + data.data.prenom)
                            $('#modal-status').text(data.data.status)
                            $('#modal-niveau').text(data.data.niveau[0])
                            $('#modal-parcours').text(data.data.parcours)
                            $('#modal-image').attr('src', data.data.photo)

                            $('#modal-info').modal('toggle')

                            console.log(data)
                        }
                    })
                })
            });*/


        })
    </script>
@endsection
