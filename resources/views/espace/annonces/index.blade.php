@extends('espace.parent.layout')

@section('css')@endsection

@section('content')

    <div class="row justify-content-center">

        <div class="col-12 justify-content-start mx-1 mb-2">
            <a href="{{ route('espace.annonces.create.form') }}" class="btn btn-primary">Publier</a>
        </div>

        <div class="col-12">
            <div class="card">
                <h3 class="text-center text-primary">
                    Listes des Annonces
                </h3>
                <p class="text-muted text-center">
                    Vous pouvez voir dessous vos anciens, le present ainsi que les annonces publient
                </p>
            </div>

        </div>

        <div class="col-12">
            <div class="row">

                @foreach($annonces as $annonce)
                <div class="col-3">
                    <a href="{{ route('espace.annonces.show', ['annonce' => $annonce->id]) }}"
                       class="card-annonces-show" data-id="{{ $annonce->id }}">
                        <div class="card card-annonces">
                            <div class="card-img-top">
                                @if($annonce->image)
                                    <img src="{{ getImageSingle($annonce->image, true) }}" alt="image" class="img-fluid">
                                @else
                                    <img src="/bg-eni.jpg" alt="image" class="img-fluid">
                                @endif
                            </div>
                            <div class="card-body">
                                <p class="card-text text-secondary">
                                    {{ $annonce->titre }}
                                </p>
                                <p class="text-muted">publier le
                                    <strong>{{ formatDate($annonce->created_at) }}</strong></p>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>

            <div class="row justify-content-center">
                {{ $annonces->links() }}
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="annonce-modal" tabindex="-1" aria-labelledby="annonce-titre" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="annonce-titre">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    ...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')


    <script type="text/javascript">

        $(function () {
            /*$('.card-annonces-show').click(function (e) {
                e.preventDefault();

                console.log('Annonce ', $(this).data('id'), $(this).attr('data-id'))
            })*/
        })


    </script>

@endsection
