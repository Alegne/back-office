<?php

namespace App\DataTables;

use App\Models\EspaceNumerique;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class EspaceNumeriqueDataTable extends DataTable
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
            ->editColumn('action', function ($espaceNumerique) {
                return $this->button(
                        'espace-numerique-travail.edit',
                        $espaceNumerique->id,
                        'warning',
                        'Editer',
                        'edit'
                    ). $this->button(
                        'espace-numerique-travail.destroy',
                        $espaceNumerique->id,
                        'danger',
                        'Supprimer',
                        'trash-alt',
                        __('Etes-vous sure de le supprimer ?')
                    );
            })
            ->editColumn('enseignant', function ($espaceNumerique) {
                return $espaceNumerique->enseignant->nom;
            })
            ->editColumn('niveau', function ($espaceNumerique) {
                return $espaceNumerique->niveau->tag;
            })
            ->rawColumns(['action', 'enseignant', 'niveau'])
            ;
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\EspaceNumerique $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(EspaceNumerique $model)
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
                    ->setTableId('espacenumerique-table')
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
            Column::make('id')->title('ID')->addClass('align-middle text-center'),
            Column::make('libelle')->title('Libelle')->addClass('align-middle text-center '),
            Column::make('enseignant')->title('Enseignant')->addClass('align-middle text-center '),
            Column::make('niveau')->title('Niveau')->addClass('align-middle text-center '),

            Column::computed('action')->title('Action')->addClass('align-middle text-center'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'EspaceNumerique_' . date('YmdHis');
    }
}
