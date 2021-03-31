<?php

namespace App\DataTables;

use App\Models\WorkSchedule;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;

class WorkScheduleDataTable extends DataTable
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

        return $dataTable->addColumn('action', 'work_schedules.datatables_actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\WorkSchedule $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(WorkSchedule $model)
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
            ->setTableId('work_schedules-table')
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
        'weekday',
            'start-time',
            'end_time'
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
        return 'work_schedules_datatable_' . date('YmdHis');
    }
}
