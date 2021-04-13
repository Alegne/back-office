<?php

namespace App\DataTables;

use App\Models\Club;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ClubDataTable extends DataTable
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
            ->editColumn('action', function ($club) {
                return $this->button(
                        'club.staff.view',
                        $club->id,
                        'info',
                        'Voir',
                        'eye',
                        $club->id
                    ). $this->button(
                        'club.edit',
                        $club->id,
                        'warning',
                        'Editer',
                        'edit'
                    ).
                    $this->button(
                        'club.destroy',
                        $club->id,
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
     * @param \App\Models\Club $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Club $model)
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
                    ->setTableId('club-table')
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
            Column::make('libelle')->title('Nom du Club')->addClass('align-middle text-center '),

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
        return 'Club_' . date('YmdHis');
    }
}
