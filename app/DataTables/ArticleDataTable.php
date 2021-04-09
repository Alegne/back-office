<?php

namespace App\DataTables;

use App\Models\Article;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ArticleDataTable extends DataTable
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
            ->editColumn('club', function ($article) {
                return $article->club->libelle;
            })
            ->editColumn('action', function ($article) {
                return $this->button(
                        'article.edit',
                        $article->id,
                        'warning',
                        'Editer',
                        'edit'
                    ). $this->button(
                        'article.destroy',
                        $article->id,
                        'danger',
                        'Supprimer',
                        'trash-alt',
                        __('Etes-vous sure de le supprimer ?')
                    );
            })
            ->rawColumns(['club', 'action'])
            ;
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Article $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Article $model)
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
                    ->setTableId('article-table')
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
        $columns =  [
            Column::make('id')->title('ID')->addClass('align-middle text-center'),
            Column::make('titre')->title('Titre')->addClass('align-middle text-center font-weight-bold'),
            Column::make('posteur')->title('Posté par')->addClass('align-middle text-center font-weight-bold'),

        ];

        array_push($columns,
            Column::computed('formation')->title('Formation')->addClass('align-middle text-center'),
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
        return 'Article_' . date('YmdHis');
    }
}
