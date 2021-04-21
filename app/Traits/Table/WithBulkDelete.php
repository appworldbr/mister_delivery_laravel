<?php

namespace App\Traits\Table;

trait WithBulkDelete
{
    public $pageListIds = [];
    public $pagesSelectedToDelete = [];
    public $pagesSelectedTristage = [];
    public $bulkDeletable = true;
    public $confirmingBulkDelete = false;
    public $deleteList = [];

    public function toggleThisPageToDelete()
    {
        if ($this->pagesSelectedToDelete[$this->page]) {
            foreach ($this->pageListIds as $id) {
                if (!in_array($id, $this->deleteList)) {
                    $this->deleteList[] = $id;
                }
            }
        } else {
            foreach ($this->pageListIds as $id) {
                $key = array_search($id, $this->deleteList);
                if ($key !== false) {
                    array_splice($this->deleteList, $key, 1);
                }
            }
            $this->pagesSelectedTristage[$this->page] = false;
        }
    }

    public function bulkDelete()
    {
        foreach ($this->model->whereIn('id', $this->deleteList)->get() as $model) {
            $model->delete();
        }
        $this->deleteList = [];
        $this->resetPage();
        $this->confirmingBulkDelete = false;
        $this->pagesSelectedToDelete = [];
        $this->pagesSelectedTristage = [];
    }

    public function validateTristage()
    {
        $counter = 0;
        foreach ($this->pageListIds as $id) {
            if (in_array($id, $this->deleteList)) {
                ++$counter;
            }
        }

        $this->pagesSelectedToDelete[$this->page] = !!$counter;
        $this->pagesSelectedTristage[$this->page] = count($this->pageListIds) != $counter;
    }

    public function getPageListIds($items)
    {
        $this->pageListIds = array_map(function ($id) {
            return (string) $id;
        }, $items->pluck('id')->toArray());
    }
}
