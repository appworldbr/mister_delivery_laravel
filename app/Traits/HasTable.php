<?php

namespace App\Traits;

use Gate;
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
    protected $creatable = true;
    protected $editable = true;
    protected $deletable = true;
    protected $bulkDeletable = true;

    abstract public function defineTable();

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

    public function isCreatable($value)
    {
        $this->creatable = $value;
        return $this;
    }

    public function getCreatable()
    {
        $name = $this->getName();
        return $this->creatable && Gate::allows($name . ":create");
    }

    public function isEditable($value)
    {
        $this->editable = $value;
        return $this;
    }

    public function getEditable()
    {
        $name = $this->getName();
        return $this->editable && Gate::allows($name . ":update");
    }

    public function isDeletable($value)
    {
        $this->deletable = $value;
        return $this;
    }

    public function getDeletable()
    {
        $name = $this->getName();
        return $this->deletable && Gate::allows($name . ":delete");
    }

    public function isBulkDeletable($value)
    {
        $this->bulkDeletable = $value;
        return $this;
    }

    public function getBulkDeletable()
    {
        $name = $this->getName();
        return $this->bulkDeletable && Gate::allows($name . ":delete");
    }

    public function getName()
    {
        return Str::camel(class_basename(static::class));
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
            $query->orWhere($searchField, 'like', "%$search%");
        }
        return $query->orderBy($sortBy, $sortDirection)->paginate($paginate);
    }
}
