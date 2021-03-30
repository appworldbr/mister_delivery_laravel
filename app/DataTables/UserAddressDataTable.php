<?php

namespace App\DataTables;

use App\Models\UserAddress;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;

class UserAddressDataTable extends DataTable
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

        return $dataTable->addColumn('action', 'user_addresses.datatables_actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\UserAddress $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(UserAddress $model)
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
            ->setTableId('user_addresses-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrtip')
            ->orderBy(0, 'desc')
            ->buttons(
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
            'zip',
            'state',
            'city',
            'district',
            'address',
            'number',
            'complement',
            'is_default' => ['searchable' => false],
            'use_id'
        */
        return [
            Column::make('...')->title('...'),
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
        return 'user_addresses_datatable_' . date('YmdHis');
    }
}
