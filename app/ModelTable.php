<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

abstract class ModelTable extends Model
{
    static $searchField;
    static $sortBy = 'id';
    static $sortDirection = 'asc';
    static $columns = [];
    static $sortableColumns = [];

    static $searchable = true;
    static $editable = true;
    static $deletable = true;
    static $bulkDeletable = true;

    public static function table($paginate, $sortBy, $sortDirection, $search = '')
    {
        return static::where(static::$searchField, 'like', "%$search%")->orderBy($sortBy, $sortDirection)->paginate($paginate);
    }

    abstract public static function getFormRoute($id = null);
}
