@extends('back.parent.layout')

@section('breadcrumb')

    @include('back.parent.partial.breadcrumb', [
        'parent' => 'Activites',
        'parent_route' => '#',
        'child' => 'Club',
    ])

@endsection

@section('css')
    <link rel="stylesheet" href="/admin/plugins/OwlCarousel2/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="/admin/plugins/OwlCarousel2/assets/owl.theme.default.min.css">

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
            action="{{ route('club.staff.add') }}">

        @csrf

        <div class="row">

            <div class="col-md-4">
                <x-back.card
                        type='info'
                        :outline="false"
                        title='Club'>

                    <div id="holder" class="text-center" style="margin-bottom:15px;">
                        @if($club->image)
                            <img style="width:100%;"
                                 src="{{ getImageSingle($club->image, true) }}"
                                 alt="">
                        @else
                            <img class="card-img-top" src="/default.png" alt="Card image cap">
                        @endif
                    </div>

                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">Club : {{ $club->libelle }}</li>
                    </ul>
                </x-back.card>
            </div>

            <div class="col-md-8">

                <x-back.card
                        type='info'
                        title='Staff'>

                    <p>Membre</p>
                    @if(count($club->staffs) > 0)

                       <div class="owl-carousel owl-theme">
                       @foreach($club->staffs as $staff)
                           <div class="item">
                               <div class="card mx-1">
                                   @if($staff->etudiant->photo)
                                       <img class="card-img-top" src="{{ getImageSingle($staff->etudiant->photo, true) }}"
                                            alt="Card image cap" style="width: 215px !important; height: 150px !important;">
                                   @else
                                       <img class="card-img-top" src="/default.png"
                                            alt="Card image cap" style="width: 215px !important; height: 150px !important;">
                                   @endif
                                   <div class="card-body">
                                       <h5 class="card-title">{{ $staff->etudiant->numero }}</h5>
                                       <p class="card-text">{{ $staff->etudiant->nom }}</p>

                                       @if($staff->type == 'leader')
                                           <a href="#" class="btn btn-info text-light">{{ $staff->type }}</a>
                                       @else
                                           <a href="#" class="btn btn-primary text-light">{{ $staff->type }}</a>
                                       @endif

                                   </div>

                                   <div class="card-footer">
                                       <button type="button" class="btn btn-danger delete-staff"
                                               id="btn-delete-staff{{ $staff->id }}"
                                               data-route="{{ route('club.staff.add.pull', ['staff' => $staff->id]) }}">
                                           Retirer</button>
                                   </div>
                               </div>
                           </div>
                       @endforeach
                       </div>
                    @else
                        <p class="text-danger text-center">Aucun Membre</p>
                    @endif
                </x-back.card>

                <x-back.card
                        type='primary'
                        title='Ajouter Staff'>

                    <x-back.validation-errors :errors="$errors" />

                    @if(session('ok'))
                        <x-back.alert
                                type='success'
                                title="{!! session('ok') !!}">
                        </x-back.alert>
                    @endif

                    <input type="hidden" name="club_id" value="{{ $club->id }}">

                    <x-back.input
                            name='type'
                            title='Type'
                            :value="isset($club) ? ''  : ''"
                            input='select'
                            :options="$types"
                            :required="true">
                    </x-back.input>

                    <x-back.input
                            name='etudiant_id'
                            title='Etudiant'
                            :value="isset($club) ? ''  : ''"
                            input='select'
                            :options="$etudiants"
                            :required="true">
                    </x-back.input>

                    <button type="submit" id="btn-submit" class="btn btn-primary">Valider</button>
                </x-back.card>
            </div>
        </div>


    </form>
@endsection

@section('js')
    {{--@include('back.shared.editorScript')--}}
    @include('back.shared.slugScript')

    <script type="text/javascript" src="/admin/plugins/OwlCarousel2/owl.carousel.min.js"></script>

    <script>
        $(function () {

            $(".owl-carousel").owlCarousel();

            $('.delete-staff').click(function () {
                let id = $(this).attr('id')

                let route = $(this).data('route')

                console.log('delete', id, route)

                $.ajax({
                    url: route,
                    type: "GET",
                    success: function (data) {
                        console.log('AJAX', data)

                        window.location.reload()

                    }
                })
            })
        })

    </script>
@endsection
