<?php

namespace App\DataTables;

use App\Exports\EtudiantExport;
use App\Models\Etudiant;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Support\Facades\Route;

class EtudiantDataTable extends DataTable
{
    use DataTableTrait;

    protected $exportClass = EtudiantExport::class;

    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->editColumn('status', function ($user) {
                # return $user->status == 'actif' ? '<i class="fas fa-check"></i>' : '';
                $couleur = $user->status == 'actif' ? 'secondary' : 'danger';
                return $this->badge($user->status, $couleur);
            })
            ->editColumn('parcours', function ($etudiant) {
                return $etudiant->parcours->tag;
            })
            ->editColumn('niveau', function ($etudiant) {
                return $this->getNiveaux($etudiant);
            })
            ->editColumn('annee', function ($etudiant) {
                return $this->getAnneeUniversitaires($etudiant);
            })
            ->editColumn('action', function ($etudiant) {
                return $this->button(
                        'etudiant.edit',
                        $etudiant->id,
                        'warning',
                        'Editer',
                        'edit'
                    ). $this->button(
                        'etudiant.destroy',
                        $etudiant->id,
                        'danger',
                        'Supprimer',
                        'trash-alt',
                        __('Etes-vous sure de le supprimer ?')
                    );
            })
            ->rawColumns(['action', 'parcours', 'niveau', 'annee', 'status'])
            ;
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Etudiant $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Etudiant $model)
    {
        $query = $model->newQuery();

        if(Route::currentRouteNamed('etudiant.indexactif')) {
            $query->where('status', '=','actif');
        }

        if(Route::currentRouteNamed('etudiant.indexold')) {
            $query->where('status', '=','ancien');
        }

        # dd($query->toSql()); # "select * from "cactus_etudiants"
        # "select * from "cactus_etudiants" where "status" = ?"

        return $query
            /*->select(
                'etudiant.id',
                'numero',
                'nom',
                'niveau',
                'parcours',
                'annee',
                'user_id'
            )
            ->with(
                'user:id,name',
                'categories:title'
            )*/
            # ->withCount('comments')
        ;
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('etudiant-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('Bfrtip')
                    ->orderBy(1)
                    ->parameters([
                        'buttons'      => ['excel'],
                    ])

            ;
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        $columns =  [
            Column::make('id')->title('ID')->addClass('align-middle text-center'),
            # Column::make('numero')->title('Numero')->addClass('align-middle text-center font-weight-bold'),
            Column::make('nom')->title('Nom')->addClass('align-middle text-center font-weight-bold'),

        ];

        array_push($columns,
            Column::computed('niveau')->title('Niveau')->addClass('align-middle text-center'),
            Column::computed('parcours')->title('Parcours')->addClass('align-middle text-center'),
            Column::computed('annee')->title('Anne Universitaire')->addClass('align-middle text-center'),
            Column::computed('status')->title('Status')->addClass('align-middle text-center'),
            Column::computed('action')->title('Action')->addClass('align-middle text-center'));

        return $columns;
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Etudiant_' . date('YmdHis');
    }

    protected function getNiveaux($etudiant)
    {
        $html = '';

        foreach($etudiant->niveau as $niveau) {
            $html .= $niveau->tag . '<br>';
        }

        return $html;
    }

    protected function getAnneeUniversitaires($etudiant)
    {
        $html = '';

        foreach($etudiant->annee as $annee) {
            $html .= $annee->libelle . '<br>';
        }

        return $html;
    }
}
