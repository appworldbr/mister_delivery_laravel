<?php

namespace App\Http\Livewire;

use App\Traits\Table\WithBulkDelete;
use App\Traits\Table\WithDelete;
use App\Traits\Table\WithEditable;
use App\Traits\Table\WithModel;
use App\Traits\Table\WithPerPage;
use App\Traits\Table\WithSearch;
use App\Traits\Table\WithSort;
use Livewire\Component;
use Livewire\WithPagination;

class Table extends Component
{
    use WithPagination, WithSearch, WithPerPage, WithEditable, WithDelete, WithBulkDelete, WithSort, WithModel;

    public $addUrl = false;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function mount($model)
    {
        $this->setModel($model);
        $this->setSettings();
        $this->setSortBy();
        $this->setSortDirection();
    }

    public function render()
    {
        $items = $this->getItems();
        $this->getPageListIds($items);
        $this->validateTristage();

        return view('livewire.table', [
            'items' => $items,
        ]);
    }
}
