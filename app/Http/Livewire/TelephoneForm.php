<?php

namespace App\Http\Livewire;

use App\Models\UserTelephone;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Manny;

class TelephoneForm extends Component
{
    use AuthorizesRequests;

    public $state = [];
    public $user;

    public $telephone;
    public $confirmingTelephoneDelete = false;
    public $telephoneToDelete;

    public function showTelephoneModalDelete($id)
    {
        $this->confirmingTelephoneDelete = true;
        $this->telephoneToDelete = $id;
    }

    public function closeTelephoneModalDelete()
    {
        $this->confirmingTelephoneDelete = false;
        $this->telephoneToDelete = null;
    }

    public function createNew()
    {
        $this->authorize('user:update');

        $this->telephone = null;
        $this->saveTelephone();
    }

    public function editTelephone($id)
    {
        $this->telephone = UserTelephone::currentUser($this->user->id)->where('id', $id)->firstOrFail();
        $this->state = [
            'telephone' => $this->telephone->telephone,
        ];
    }

    public function saveTelephone()
    {
        $this->authorize('user:update');

        Validator::make($this->state, [
            'telephone' => ['required', 'regex:/^\([0-9]{2}\)\ ([0-9]\ )?[0-9]{4}\-[0-9]{4}$/'],
        ])->validate();

        if (!$this->telephone) {
            $data = array_merge($this->state, ['user_id' => $this->user->id, 'is_default' => false]);
            $this->telephone = UserTelephone::create($data);
        } else {
            $this->telephone->update($this->state);
        }

        $this->emit('saved');
        $this->clear();
    }

    public function deleteTelephone()
    {
        $this->authorize('user:update');

        $telephone = UserTelephone::currentUser($this->user->id)->where('id', $this->telephoneToDelete)->first();

        if (!$telephone) {
            abort(404, __('Address Not Found'));
        }

        if ($telephone->is_default) {
            abort(302, __('Address Is Default'));
        }

        $telephone->delete();
        $this->confirmingTelephoneDelete = false;
        $this->telephoneToDelete = null;
    }

    public function clear()
    {
        $this->telephone = null;
        $this->state = [];
    }

    public function setAddressAsDefault($id)
    {
        $this->authorize('user:update');
        UserTelephone::setDefault($id, $this->user);
    }

    public function updated($field)
    {
        if ($field == "state.telephone") {
            $this->state['telephone'] = preg_match_all('/[0-9]/', $this->state['telephone']) >= 11
            ? Manny::mask($this->state['telephone'], '(11) 1 1111-1111')
            : Manny::mask($this->state['telephone'], '(11) 1111-1111');
        }
    }

    public function render()
    {
        return view('users.telephone-form');
    }
}
