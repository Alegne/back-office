<?php

namespace App\DataTables;

use App\Models\Niveau;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class NiveauDataTable extends DataTable
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
            ->editColumn('formation', function ($niveau) {
                return $niveau->formation->libelle;
            })
            ->editColumn('action', function ($niveau) {
                return $this->button(
                        'niveau.edit',
                        $niveau->id,
                        'warning',
                        'Editer',
                        'edit'
                    ). $this->button(
                        'niveau.destroy',
                        $niveau->id,
                        'danger',
                        'Supprimer',
                        'trash-alt',
                        __('Etes-vous sure de le supprimer ?')
                    );
            })
            ->rawColumns(['formation', 'action'])
            ;
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Niveau $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Niveau $model)
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
                    ->setTableId('niveau-table')
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
        $columns =  [
            Column::make('id')->title('ID')->addClass('align-middle text-center'),
            Column::make('libelle')->title('Libelle')->addClass('align-middle text-center font-weight-bold'),
            Column::make('tag')->title('Tag')->addClass('align-middle text-center font-weight-bold'),

        ];

        array_push($columns,
            Column::computed('formation')->title('Formation')->addClass('align-middle text-center'),
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
        return 'Niveau_' . date('YmdHis');
    }
}
