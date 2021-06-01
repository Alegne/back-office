<?php

namespace App\DataTables;

use App\Models\Annonce;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class AnnonceDataTable extends DataTable
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
            ->editColumn('type', function ($annonce) {
                if($annonce->type == 'public') {
                    return "Public";
                } elseif($annonce->type == 'private') {
                    return "Prive";
                }
            })
            ->editColumn('approuve', function($annonce) {

                #dd($annonce->approuve);

                if($annonce->approuve == 1) {
                    return $this->button(
                        'annonce.approuve.update',
                        $annonce->id,
                        'success',
                        'Approuve',
                        'thumbs-up',
                        'valid'
                    );
                }
                return $this->button(
                    'annonce.desapprouve.update',
                    $annonce->id,
                    'warning',
                    'Desapprouve',
                    'thumbs-down',
                    'valid'
                );
            })
            ->editColumn('action', function ($annonce) {
                return $this->button(
                        'annonce.edit',
                        $annonce->id,
                        'warning',
                        'Editer',
                        'edit'
                    ). $this->button(
                        'annonce.destroy',
                        $annonce->id,
                        'danger',
                        'Supprimer',
                        'trash-alt',
                        __('Etes-vous sure de le supprimer ?')
                    );
            })
            ->rawColumns(['approuve', 'type', 'action'])
            ;
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Annonce $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Annonce $model)
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
                    ->setTableId('annonce-table')
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
            Column::make('type')->title('VIsibilite')->addClass('align-middle text-center font-weight-bold'),
            Column::computed('approuve')->title('Approbation')->addClass('align-middle text-center'),

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
        return 'Annonce_' . date('YmdHis');
    }
}
