<?php

namespace App\DataTables;

use App\Models\Formation;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class FormationDataTable extends DataTable
{
    use DataTableTrait;

    # id | libelle | description | slug | photo

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
            ->editColumn('action', function ($formation) {
                return $this->button(
                        'formation.edit',
                        $formation->id,
                        'warning',
                        'Editer',
                        'edit'
                    ). $this->button(
                        'formation.destroy',
                        $formation->id,
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
     * @param \App\Models\Formation $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Formation $model)
    {
        # dd($model->newQuery());
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
                    ->setTableId('formation-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('Bfrtip')
                    ->orderBy(1)
                    # ->buttons(
                    #     Button::make('create'),
                    #     Button::make('export'),
                    #     Button::make('print'),
                    #     Button::make('reset'),
                    #     Button::make('reload')
                    # )
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
            Column::make('libelle')->title('Libelle')->addClass('align-middle text-center'),
            # Column::make('description')->title('description'),

            # Column::make('created_at')->title('Creation'),
            # Column::make('updated_at')->title('Modification'),
            # Column::make('valid')->title(__('Valid'))->addClass('align-middle text-center'),

            Column::computed('action')->title('Action')->addClass('align-middle text-center'),
        ];
        /*return [
            Column::computed('action')
                  ->exportable(false)
                  ->printable(false)
                  ->width(60)
                  ->addClass('text-center'),
            Column::make('id'),
            Column::make('add your columns'),
            Column::make('created_at'),
            Column::make('updated_at'),
        ];*/
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Formation_' . date('YmdHis');
    }
}
