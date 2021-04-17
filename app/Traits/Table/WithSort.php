<?php

namespace App\Traits\Table;

trait WithSort
{
    public $sortBy;
    public $sortDirection;

    public function sortBy($field)
    {
        $this->sortDirection = $this->sortBy === $field
        ? $this->reverseSort()
        : 'asc';

        $this->sortBy = $field;
    }

    public function reverseSort()
    {
        return $this->sortDirection === 'asc'
        ? 'desc'
        : 'asc';
    }

    public function setSortBy()
    {
        $this->sortBy = $this->model->sortBy;
    }

    public function setSortDirection()
    {
        $this->sortDirection = $this->model->sortDirection;
    }
}
