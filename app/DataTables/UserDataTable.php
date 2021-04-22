<?php

namespace App\DataTables;

use App\Models\User;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class UserDataTable extends DataTable
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
            ->editColumn('role', function ($user) {
                return $this->badge($user->role, 'info');
            })
            ->editColumn('action', function ($user) {
                return $this->button(
                        'user.edit',
                        $user->id,
                        'warning',
                        'Editer',
                        'edit'
                    ). $this->button(
                        'user.destroy',
                        $user->id,
                        'danger',
                        'Supprimer',
                        'trash-alt',
                        __('Etes-vous sure de le supprimer ?')
                    );
            })
            ->rawColumns(['role', 'action'])
            ;
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(User $model)
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
                    ->setTableId('user-table')
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
            Column::make('identifiant')->title('Identifiant')->addClass('align-middle text-center font-weight-bold'),
            Column::make('email')->title('Email')->addClass('align-middle text-center font-weight-bold'),

        ];

        array_push($columns,
            Column::computed('role')->title('Role')->addClass('align-middle text-center'),
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
        return 'User_' . date('YmdHis');
    }
}
