<?php

namespace App\DataTables;

use App\Models\Langue;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class LangueDataTable extends DataTable
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
            ->editColumn('action', function ($langue) {
                return $this->button(
                    'langue.edit',
                    $langue->id,
                    'warning',
                    'Editer',
                    'edit'
                ) . $this->button(
                    'langue.destroy',
                    $langue->id,
                    'danger',
                    'Supprimer',
                    'trash-alt',
                    'Etes-vous sure de le supprimer ?'
                );
            })
            ->rawColumns(['action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Langue $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Langue $model)
    {
        # dd($model->newQuery()->toSql());
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
            ->setTableId('langue-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrtip')
            ->orderBy(1);
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
            Column::make('libelle')->title('Libelle')->addClass('align-middle text-center'),

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
        return 'Langue_' . date('YmdHis');
    }
}
