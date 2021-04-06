<?php

namespace App\DataTables;

use App\Models\DeliveryArea;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;

class DeliveryAreaDataTable extends DataTable
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

        return $dataTable->addColumn('action', 'delivery_areas.datatables_actions')
                        ->editColumn('prevent', function($model){
                            return $model->is_prevent;
                        });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\DeliveryArea $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(DeliveryArea $model)
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
            ->setTableId('delivery_areas-table')
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
        'initial_zip',
            'final_zip',
            'price',
            'prevent'
        */
        return [
            Column::make('initial_zip')->title('Cep Inicial'),
            Column::make('final_zip')->title('Cep Final'),
            Column::make('price')->title('Frete'),
            Column::make('prevent')->title('Evitavel'),
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
        return 'delivery_areas_datatable_' . date('YmdHis');
    }
}
