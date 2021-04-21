<?php

namespace App\Traits;

use Auth;
use Str;

trait HasTable
{
    public $searchFields = [];

    public $columns = [];
    public $columnsName = [];
    public $sortableColumns = [];

    public $sortBy = 'id';
    public $sortDirection = 'asc';

    protected $searchable = true;
    protected $editable = true;
    protected $deletable = true;
    protected $bulkDeletable = true;

    protected function initializeHasTable()
    {
        $this->defineTable();
    }

    public function addSearchFields($fields)
    {
        foreach ($fields as $field) {
            $this->addSearchField($field);
        }
        return $this;
    }

    public function addSearchField($field)
    {
        $this->searchFields[] = $field;
        return $this;
    }

    public function addColumns($fields, $sortable = [])
    {
        foreach ($fields as $field) {
            $this->addColumn($field, in_array($field, $sortable));
        }
        return $this;
    }

    public function addColumn($field, $isSortable = false)
    {
        $this->columns[] = $field;
        if ($isSortable) {
            $this->addSortableField($field);
        }
        return $this;
    }

    public function addSortableField($field)
    {
        $this->sortableColumns[] = $field;
        return $this;
    }

    public function addColumnName($field, $name)
    {
        $this->columnsName[$field] = $name;
        return $this;
    }

    public function setSortBy($field)
    {
        $this->sortBy = $field;
        return $this;
    }

    public function setSortDirection($field)
    {
        $this->sortDirection = $field;
        return $this;
    }

    public function isSearchable($value)
    {
        $this->searchable = $value;
        return $this;
    }

    public function getSearchable()
    {
        return $this->searchable;
    }

    public function isEditable($value)
    {
        $this->editable = $value;
        return $this;
    }

    public function getEditable()
    {
        return $this->editable;
    }

    public function isDeletable($value)
    {
        $this->deletable = $value;
        return $this;
    }

    public function getDeletable()
    {
        return $this->deletable;
    }

    public function isBulkDeletable($value)
    {
        $this->bulkDeletable = $value;
        return $this;
    }

    public function getBulkDeletable()
    {
        return $this->bulkDeletable;
    }

    public function getName()
    {
        return Str::camel(class_basename(static::class));
    }

    public function validatePermission($type)
    {
        if (!Auth::user()->hasPermissionTo($this->getName() . ':' . $type)) {
            abort(403);
        }
        return true;
    }

    public function getFormRoute()
    {
        $name = $this->getName();

        if (!$this->id) {
            return route("$name.form.create");
        }

        return route("$name.form.update", [
            $name => $this->id,
        ]);
    }

    public function scopeTable($query, $paginate, $sortBy, $sortDirection, $search = '')
    {
        foreach ($this->searchFields as $searchField) {
            $query = $query->orWhere($searchField, 'like', "%$search%");
        }
        return $query->orderBy($sortBy, $sortDirection)->paginate($paginate);
    }

    abstract public function defineTable();
}
