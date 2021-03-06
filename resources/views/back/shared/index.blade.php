@extends('back.parent.layout')

@section('breadcrumb')

    @include('back.parent.partial.breadcrumb', [
        'parent' => ucfirst(str_replace('-', ' ', explode('.', Route::currentRouteName())[0])),
        'parent_route' => '#',
        'child' => str_replace('-', ' ', explode('.', Route::currentRouteName())[0]),
    ])

@endsection

@section('css')
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.23/css/dataTables.bootstrap4.min.css">

  {{--<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.0.3/css/buttons.dataTables.min.css">--}}
  <style>
    a > * { pointer-events: none; }

.table-perso{
    width: 800px !important;
}
  </style>
@endsection

@section('main')


    <div id="alert" class="alert alert-danger alert-dismissible fade show d-none" role="alert">
        <p class="text-light " id="message">Message</p>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row justify-content-start mx-1">
                        <a href="{{ route(parseRouteActive()) }}" class="btn btn-primary  mr-1">Ajouter</a>

                        @if(Route::currentRouteName() === 'etudiant.indexactif' || Route::currentRouteName() === 'etudiant.indexold')
                            <a href="{{ route('etudiant.index') }}" class="btn btn-primary">Retour</a>
                        @endif

                        @if(Route::currentRouteName() === 'etudiant.index')
                            <a href="{{ route('etudiant.indexactif') }}" class="btn btn-primary mr-1 ">Actif</a>
                            <a href="{{ route('etudiant.indexold') }}" class="btn btn-primary mr-1">Ancien</a>
                            <a href="{{ route('etudiant.filter.new.request') }}" class="btn btn-primary mr-1">Filtre</a>
{{--                            <a href="{{ route('etudiant.download.actif') }}" class="btn btn-primary mr-1">Excel</a>--}}
                            <a href="{{ route('etudiant.excel.view') }}" class="btn btn-primary mr-1">Excel</a>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-12">
                            {{ $dataTable->table(['class' => 'table table-sm table-bordered table-hover '], true) }}
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>




@endsection

@section('js')
  <script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.23/js/dataTables.bootstrap4.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

  {{--<script src="https://cdn.datatables.net/buttons/1.0.3/js/dataTables.buttons.min.js"></script>
  <script src="{{ asset('vendor/datatables/buttons.server-side.js') }}"></script>--}}

  @if(config('app.locale') == 'fr')
    <script>
      (($, DataTable) => {
        $.extend(true, DataTable.defaults, {
          language: {
            "sEmptyTable":     "Aucune donn??e disponible dans le tableau",
            "sInfo":           "Affichage des ??l??ments _START_ ?? _END_ sur _TOTAL_ ??l??ments",
            "sInfoEmpty":      "Affichage de l'??l??ment 0 ?? 0 sur 0 ??l??ment",
            "sInfoFiltered":   "(filtr?? ?? partir de _MAX_ ??l??ments au total)",
            "sInfoPostFix":    "",
            "sInfoThousands":  ",",
            "sLengthMenu":     "Afficher _MENU_ ??l??ments",
            "sLoadingRecords": "Chargement...",
            "sProcessing":     "Traitement...",
            "sSearch":         "Rechercher :",
            "sZeroRecords":    "Aucun ??l??ment correspondant trouv??",
            "oPaginate": {
              "sFirst":    "Premier",
              "sLast":     "Dernier",
              "sNext":     "Suivant",
              "sPrevious": "Pr??c??dent"
            },
            "oAria": {
              "sSortAscending":  ": activer pour trier la colonne par ordre croissant",
              "sSortDescending": ": activer pour trier la colonne par ordre d??croissant"
            },
            "select": {
              "rows": {
                "_": "%d lignes s??lectionn??es",
                "0": "Aucune ligne s??lectionn??e",
                "1": "1 ligne s??lectionn??e"
              }
            }
          }
        });
      })(jQuery, jQuery.fn.dataTable);
    </script>
  @endif

  {{ $dataTable->scripts() }}

  <script>
    (() => {

        /*$(".alert").delay(4000).slideUp(200, function() {
            $(this).alert('close');
        });*/

        // Token
        /*$.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });*/

        console.log('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'))

        // Variables
        const headers = {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        }

        // Delete
        const deleteElement = async e => {
            e.preventDefault();
            Swal.fire({
              title: e.target.dataset.name,
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#DD6B55',
              confirmButtonText: 'OUI',
              cancelButtonText: 'NON',
              preConfirm: () => {
                  return fetch(e.target.getAttribute('href'), {
                      method: 'DELETE',
                      headers: headers
                  })
                  .then(response => response.json())
                  .then(response => {
                      console.log(response.statusText, response)
                      if (response.ok) {
                          // Si la r??ponse est OK on supprime la ligne du tableau
                          e.target.parentNode.parentNode.remove();
                      } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Whoops!',
                            text: "Il y a quelques problemes"
                        });

                        console.log(response, response.message)

                          $('#alert').removeClass('d-none')

                          $('#message').text(response.message);
                      }

                  });
              }
            });
        }

        // Valid
        const validElement = async e => {
            e.preventDefault();
            fetch(e.target.getAttribute('href'), {
                method: 'PUT',
                headers: headers
            })
            .then(response => {
                if (response.ok) {
                    document.location.reload();
                } else {
                  Swal.fire({
                      icon: 'error',
                      title: 'Whoops!',
                      text: "Il y a quelques problemes"
                  });
                }
            });
        }

        // Listener wrapper
        const wrapper = (selector, type, callback, condition = 'true', capture = false) => {
            const element = document.querySelector(selector);
            if(element) {
                document.querySelector(selector).addEventListener(type, e => {
                    if(eval(condition)) {
                        callback(e);
                    }
                }, capture);
            }
        };

        // Set listeners
        window.addEventListener('DOMContentLoaded', () => {
            // https://laravel.sillo.org/modifier-ou-supprimer-un-article/
            wrapper('table', 'click', deleteElement, "e.target.matches('.btn-danger')");

            // Tableau  Commentaire lors de clic sur icon de probation  | https://laravel.sillo.org/les-commentaires/
            wrapper('table', 'click', validElement, `e.target.matches('[data-name="valid"]')`);
        });

    })()

  </script>

@endsection
