<?php

namespace App\Traits\Table;

trait WithModel
{
    public $model;

    public function setModel($model)
    {
        $this->model = app($model);
    }

    public function getItems()
    {
        return $this->model->table($this->perPage, $this->sortBy, $this->sortDirection, $this->search);
    }

    public function setSettings()
    {
        $this->searchable = $this->model::$searchable;
        $this->editable = $this->model::$editable;
        $this->deletable = $this->model::$deletable;
        $this->bulkDeletable = $this->model::$bulkDeletable;
    }
}
