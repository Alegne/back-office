<?php

namespace App\DataTables;

use App\Models\AnneeUniversitaireLibelle;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class AnneeUniversitaireLibelleDataTable extends DataTable
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
            ->editColumn('action', function ($annee) {
                return $this->button(
                        'annee-universitaire.edit',
                        $annee->id,
                        'warning',
                        'Editer',
                        'edit'
                    ). $this->button(
                        'annee-universitaire.destroy',
                        $annee->id,
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
     * @param \App\Models\AnneeUniversitaireLibelle $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(AnneeUniversitaireLibelle $model)
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
                    ->setTableId('anneeuniversitairelibelle-table')
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
            Column::make('libelle')->title('Libelle')->addClass('align-middle text-center font-weight-bold'),

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
        return 'AnneeUniversitaireLibelle_' . date('YmdHis');
    }
}
