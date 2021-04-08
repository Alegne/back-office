<?php

namespace App\DataTables;

use App\Models\Parcour;
use App\Models\Parcours;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ParcoursDataTable extends DataTable
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
            ->editColumn('action', function ($parcours) {
                return $this->button(
                        'parcours.edit',
                        $parcours->id,
                        'warning',
                        'Editer',
                        'edit'
                    ). $this->button(
                        'parcours.destroy',
                        $parcours->id,
                        'danger',
                        'Supprimer',
                        'trash-alt',
                        __('Etes-vous sure de le supprimer ?')
                    );
            })
            ->rawColumns(['action'])
        ;
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Parcours $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Parcours $model)
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
                    ->setTableId('parcours-table')
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
            Column::make('tag')->title('Tag')->addClass('align-middle text-center font-weight-bold'),

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
        return 'Parcours_' . date('YmdHis');
    }
}
