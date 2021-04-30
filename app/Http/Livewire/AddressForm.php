<?php

namespace App\Http\Livewire;

use App\Models\UserAddress;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Manny;

class AddressForm extends Component
{
    use AuthorizesRequests;

    public $state = [
        'state' => 'RJ',
    ];
    public $user;
    public $address;

    public $confirmingAddressDelete = false;
    public $addressToDelete;

    public function showAddressModalDelete($id)
    {
        $this->confirmingAddressDelete = true;
        $this->addressToDelete = $id;
    }

    public function createNew()
    {
        $this->authorize('user:update');

        $this->address = null;
        $this->saveAddress();
    }

    public function editAddress($id)
    {
        $this->address = UserAddress::get($id, $this->user);

        if (!$this->address) {
            abort(403);
        }

        $this->state = [
            'name' => $this->address->name,
            'zip' => $this->address->zip,
            'state' => $this->address->state,
            'city' => $this->address->city,
            'district' => $this->address->district,
            'address' => $this->address->address,
            'number' => $this->address->number,
            'complement' => $this->address->complement,
        ];
    }

    public function saveAddress()
    {
        $this->authorize('user:update');

        AddressForm::validator($this->state);

        if (!$this->address) {
            $data = array_merge($this->state, ['user_id' => $this->user->id, 'is_default' => false]);
            $this->address = UserAddress::create($data);
        } else {
            $this->address->update($this->state);
        }

        $this->emit('saved');
        $this->clear();
    }

    public function deleteAddress()
    {
        $this->authorize('user:update');

        $address = UserAddress::currentUser()->where('id', $this->addressToDelete)->first();

        if (!$address) {
            abort(404, __('Address Not Found'));
        }

        if ($address->is_default) {
            abort(302, __('Address Is Default'));
        }

        $address->delete();
    }

    public function clear()
    {
        $this->address = null;
        $this->state = [
            'state' => 'RJ',
        ];
    }

    public function setAddressAsDefault($id)
    {
        $this->authorize('user:update');
        UserAddress::setDefault($this->user, $id);
    }

    public function updated($field)
    {
        if ($field == "state.zip") {
            $this->state['zip'] = Manny::mask($this->state['zip'], '11111-111');
            if (preg_match('/[0-9]{5}\-[0-9]{3}/', $this->state['zip'])) {
                $data = UserAddress::getZipInformation($this->state['zip']);

                if (isset($data['logradouro'])) {
                    $this->state['address'] = $data['logradouro'];
                }

                if (isset($data['complemento'])) {
                    $this->state['complement'] = $data['complemento'];
                }

                if (isset($data['bairro'])) {
                    $this->state['district'] = $data['bairro'];
                }

                if (isset($data['localidade'])) {
                    $this->state['city'] = $data['localidade'];
                }

                if (isset($data['uf'])) {
                    $this->state['state'] = $data['uf'];
                }
            }
        }
    }

    public function render()
    {
        return view('users.address-form');
    }
}
