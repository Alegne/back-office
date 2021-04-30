<?php

namespace App\DataTables;

use App\Models\Journal;
use App\Models\User;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class JournalDataTable extends DataTable
{
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
            ->editColumn('date_debut', function ($journal) {
                return formatDateTime($journal->created_at);
            })
            ->editColumn('date_fin', function ($journal) {
                return formatDateTime($journal->updated_at);
            })
            ->editColumn('utilisateur', function ($journal) {
                return User::find($journal->action)->identifiant;
            })
            /*->editColumn('action', function ($journal) {
                return $this->button(
                        'journal.edit',
                        $journal->id,
                        'warning',
                        'Editer',
                        'edit'
                    ). $this->button(
                        'journal.destroy',
                        $journal->id,
                        'danger',
                        'Supprimer',
                        'trash-alt',
                        __('Etes-vous sure de le supprimer ?')
                    );
            })
            ->rawColumns(['action'])*/
            ;
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Journal $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Journal $model)
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
                    ->setTableId('journal-table')
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
            Column::make('ip')->title('IP')->addClass('align-middle text-center font-weight-bold'),
            Column::make('utilisateur')->title('Utilisateur')->addClass('align-middle text-center font-weight-bold'),
            Column::make('date_debut')->title('Date debut')->addClass('align-middle text-center font-weight-bold'),
            Column::make('date_fin')->title('Date fin')->addClass('align-middle text-center font-weight-bold'),

            #Column::computed('action')->title('Action')->addClass('align-middle text-center')
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Journal_' . date('YmdHis');
    }
}
