<?php

namespace App\DataTables;

use App\Models\EmploiTemps;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class EmploiDuTempsDataTable extends DataTable
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
            ->editColumn('date_debut', function ($emploiTemps) {
                return formatDateItem($emploiTemps->date_debut);
            })
            ->editColumn('date_fin', function ($emploiTemps) {
                return formatDateItem($emploiTemps->date_fin);
            })
            ->editColumn('niveau', function ($emploiTemps) {
                return $emploiTemps->niveau->tag;
            })
            ->editColumn('parcours', function ($emploiTemps) {
                # return $emploiTemps->parcours->tag;
                return $this->getParcours($emploiTemps);
            })
            ->editColumn('annee', function ($emploiTemps) {
                return $emploiTemps->annee->libelle;
            })
            ->editColumn('action', function ($emploiTemps) {
                return $this->button(
                        'emploi-du-temps.edit',
                        $emploiTemps->id,
                        'warning',
                        'Editer',
                        'edit'
                    ). $this->button(
                        'emploi-du-temps.destroy',
                        $emploiTemps->id,
                        'danger',
                        'Supprimer',
                        'trash-alt',
                        __('Etes-vous sure de le supprimer ?')
                    );
            })
            ->rawColumns(['date_debut', 'date_fin', 'niveau', 'parcours', 'annee', 'action'])
            ;
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\EmploiTemps $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(EmploiTemps $model)
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
                    ->setTableId('emploidutemps-table')
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
            Column::computed('date_debut')->title('Date Debut')->addClass('align-middle text-center'),
            Column::computed('date_fin')->title('Date Fin')->addClass('align-middle text-center'),
            Column::computed('niveau')->title('Niveau')->addClass('align-middle text-center'),
            Column::computed('parcours')->title('Parcours')->addClass('align-middle text-center'),
            Column::computed('annee')->title('Annee Universitaire')->addClass('align-middle text-center'),
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
        return 'EmploiDuTemps_' . date('YmdHis');
    }

    /**
     * Get parcours.
     *
     * @param \App\Models\EmploiTemps $emploiDuTemps
     * @return string
     */
    protected function getParcours($emploiDuTemps)
    {
        $html = '';

        foreach($emploiDuTemps->parcours as $parcours) {
            # $html .= $parcours->tag . ' ';
            $html .= $this->badge( $parcours->tag, 'info') . ' ';
        }

        return $html;
    }
}
