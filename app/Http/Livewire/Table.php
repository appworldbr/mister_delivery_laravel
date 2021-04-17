<?php

namespace App\Http\Livewire;

use App\Traits\Table\WithBulkDelete;
use App\Traits\Table\WithDelete;
use App\Traits\Table\WithPerPage;
use App\Traits\Table\WithSearch;
use App\Traits\Table\WithSort;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Livewire\WithPagination;

class Table extends Component
{
    use WithPagination;
    use WithSort;
    use WithPerPage;
    use WithSearch;
    use WithBulkDelete;
    use WithDelete;
    use AuthorizesRequests;

    public $model;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function mount($model)
    {
        $this->model = app($model);
        $this->setSortBy();
        $this->setSortDirection();
    }

    public function render()
    {
        $items = $this->model->table($this->perPage, $this->sortBy, $this->sortDirection, $this->search);
        $this->getPageListIds($items);
        $this->validateTristage();

        return view('livewire.table', [
            'items' => $items,
        ]);
    }
}
