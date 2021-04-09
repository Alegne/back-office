<?php

namespace App\DataTables;

use App\Models\Evenement;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class EvenementDataTable extends DataTable
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
            ->editColumn('action', function ($evenement) {
                return $this->button(
                        'evenement.edit',
                        $evenement->id,
                        'warning',
                        'Editer',
                        'edit'
                    ). $this->button(
                        'evenement.destroy',
                        $evenement->id,
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
     * @param \App\Models\Evenement $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Evenement $model)
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
                    ->setTableId('evenement-table')
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
            Column::make('titre')->title('Titre')->addClass('align-middle text-center font-weight-bold'),
            Column::make('posteur')->title('Posté par')->addClass('align-middle text-center font-weight-bold'),
            Column::make('date_creation')->title('Date de publication')->addClass('align-middle text-center font-weight-bold'),

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
        return 'Evenement_' . date('YmdHis');
    }
}
