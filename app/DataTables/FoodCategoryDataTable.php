<?php

namespace App\DataTables;

use App\Models\FoodCategory;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;

class FoodCategoryDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $dataTable = new EloquentDataTable($query);

        return $dataTable->addColumn('action', 'food_categories.datatables_actions')
                        ->editColumn('has_details', function($model){
                            return $model->details;
                        });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\FoodCategory $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(FoodCategory $model)
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
            ->setTableId('food_categories-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrtip')
            ->orderBy(0, 'desc')
            ->buttons(
                Button::make('create'),
                Button::make('export'),
                Button::make('print'),
                Button::make('reset'),
                Button::make('reload')
            )
            ->parameters([
                'stateSave' => true,
                'language' => [
                    'url' => url('/vendor/datatables/lang/pt_br.json')
                ]
            ]);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        /*
        'name',
            'description' => ['searchable' => false],
            'has_details'
        */
        return [
            Column::make('name')->title('Nome'),
            Column::make('description')->title('Descrição'),
            Column::make('has_details')->title('Tem detalhes'),
            Column::computed('action')
                  ->exportable(false)
                  ->printable(false)
                  ->width(120)
                  ->title("Ações"),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'food_categories_datatable_' . date('YmdHis');
    }
}
