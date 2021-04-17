<?php

namespace App\Traits\Table;

trait WithDelete
{
    public $deletable = true;
    public $confirmingDelete = false;
    public $deleteId;

    public function showDeleteModal($id)
    {
        $this->confirmingDelete = true;
        $this->deleteId = $id;
    }

    public function delete()
    {
        $this->authorize($this->model->getName() . ':delete');
        $this->model->find($this->deleteId)->delete();
        $this->deleteList = [];
        $this->resetPage();
        $this->confirmingDelete = false;
        $this->pagesSelectedToDelete = [];
        $this->pagesSelectedTristage = [];
    }
}
