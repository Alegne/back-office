<?php

namespace App\DataTables;

use App\Models\Matiere;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class MatiereDataTable extends DataTable
{
    use DataTableTrait;

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
            ->editColumn('niveau', function ($matiere) {
                return $matiere->niveau->tag;
            })
            ->editColumn('parcours', function ($matiere) {
                # return $emploiTemps->parcours->tag;
                return $this->getParcours($matiere);
            })
            ->editColumn('enseignant', function ($matiere) {
                return $matiere->enseignant->nom;
            })
            ->editColumn('action', function ($matiere) {
                return $this->button(
                        'matiere.edit',
                        $matiere->id,
                        'warning',
                        'Editer',
                        'edit'
                    ). $this->button(
                        'matiere.destroy',
                        $matiere->id,
                        'danger',
                        'Supprimer',
                        'trash-alt',
                        __('Etes-vous sure de le supprimer ?')
                    );
            })
            ->rawColumns(['enseignant', 'parcours', 'niveau', 'action'])

            ;
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Matiere $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Matiere $model)
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('matiere-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('Bfrtip')
                    ->orderBy(1)
                    ;
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::make('libelle')->title('Libelle')->addClass('align-middle text-center font-weight-bold'),

            Column::computed('niveau')->title('Niveau')->addClass('align-middle text-center'),
            Column::computed('parcours')->title('Parcours')->addClass('align-middle text-center'),
            Column::computed('enseignant')->title('Enseignant')->addClass('align-middle text-center'),
            Column::computed('action')->title('Action')->addClass('align-middle text-center')
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Matiere_' . date('YmdHis');
    }



    /**
     * Get parcours.
     *
     * @param \App\Models\Matiere $matiere
     * @return string
     */
    protected function getParcours($matiere)
    {
        $html = '';

        foreach($matiere->parcours as $parcours) {
            $html .= $this->badge( $parcours->tag, 'info') . ' ';
        }

        return $html;
    }
}
