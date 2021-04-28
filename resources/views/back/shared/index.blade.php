@extends('back.parent.layout')

@section('breadcrumb')

    @include('back.parent.partial.breadcrumb', [
        'parent' => 'Tableau de ' . str_replace('-', ' ', explode('.', Route::currentRouteName())[0]),
        'parent_route' => '#',
        'child' => str_replace('-', ' ', explode('.', Route::currentRouteName())[0]),
    ])

@endsection

@section('css')
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.23/css/dataTables.bootstrap4.min.css">

  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.0.3/css/buttons.dataTables.min.css">
  <style>
    a > * { pointer-events: none; }

.table-perso{
    width: 800px !important;
}
  </style>
@endsection

@section('main')

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

  <script src="https://cdn.datatables.net/buttons/1.0.3/js/dataTables.buttons.min.js"></script>
  <script src="{{ asset('vendor/datatables/buttons.server-side.js') }}"></script>

  @if(config('app.locale') == 'fr')
    <script>
      (($, DataTable) => {
        $.extend(true, DataTable.defaults, {
          language: {
            "sEmptyTable":     "Aucune donnée disponible dans le tableau",
            "sInfo":           "Affichage des éléments _START_ à _END_ sur _TOTAL_ éléments",
            "sInfoEmpty":      "Affichage de l'élément 0 à 0 sur 0 élément",
            "sInfoFiltered":   "(filtré à partir de _MAX_ éléments au total)",
            "sInfoPostFix":    "",
            "sInfoThousands":  ",",
            "sLengthMenu":     "Afficher _MENU_ éléments",
            "sLoadingRecords": "Chargement...",
            "sProcessing":     "Traitement...",
            "sSearch":         "Rechercher :",
            "sZeroRecords":    "Aucun élément correspondant trouvé",
            "oPaginate": {
              "sFirst":    "Premier",
              "sLast":     "Dernier",
              "sNext":     "Suivant",
              "sPrevious": "Précédent"
            },
            "oAria": {
              "sSortAscending":  ": activer pour trier la colonne par ordre croissant",
              "sSortDescending": ": activer pour trier la colonne par ordre décroissant"
            },
            "select": {
              "rows": {
                "_": "%d lignes sélectionnées",
                "0": "Aucune ligne sélectionnée",
                "1": "1 ligne sélectionnée"
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
                  .then(response => {
                      console.log(response.statusText)
                      if (response.ok) {
                          // Si la réponse est OK on supprime la ligne du tableau
                          e.target.parentNode.parentNode.remove();
                      } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Whoops!',
                            text: "Il y a quelques problemes"
                        });
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
