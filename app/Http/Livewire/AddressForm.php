<?php

namespace App\Http\Livewire;

use App\Models\UserAddress;
use Http;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Validator;
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

    public function saveAddress()
    {
        $this->authorize('user:update');

        Validator::make($this->state, [
            'name' => ['required', 'max:127'],
            'zip' => ['required', 'regex:/[0-9]{5}-[0-9]{3}/'],
            'state' => ['required', 'max:2'],
            'city' => ['required', 'max:100'],
            'district' => ['required', 'max:127'],
            'address' => ['required', 'max:127'],
            'number' => ['required', 'max:127'],
            'complement' => ['nullable', 'max:127'],
        ])->validate();

        $this->state['zip'] = preg_replace('/[^0-9]/', '', $this->state['zip']);

        if (!$this->address) {
            $this->address = UserAddress::create(array_merge($this->state, ['user_id' => $this->user->id]));
        } else {
            $this->address->update($this->state);
        }

        $this->emit('saved');
        $this->clear();
    }

    public function deleteAddress()
    {
        $address = $this->user->address()->where('id', $this->addressToDelete)->first();
        if ($address->is_default) {
            abort(403);
        }
        $address->delete();
        $this->confirmingAddressDelete = false;
    }

    public function clear()
    {
        unset($this->address);
        $this->state = [
            'state' => 'RJ',
        ];
    }

    public function editAddress($id)
    {
        $this->address = $this->user->address->where('id', $id)->first();

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

        if ($this->state['zip']) {
            $this->state['zip'] = preg_replace('/([0-9]{5})([0-9]{3})/', '$1-$2', $this->state['zip']);
        }
    }

    public function setAddressAsDefault($id)
    {
        $this->authorize('user:update');

        $this->user->address()->update([
            'is_default' => false,
        ]);

        $this->user->address->where('id', $id)->first()->update([
            'is_default' => true,
        ]);
    }

    public function updated($field)
    {
        if ($field == "state.zip") {
            $this->state['zip'] = Manny::mask($this->state['zip'], '11111-111');
            if (preg_match('/[0-9]{5}\-[0-9]{3}/', $this->state['zip'])) {
                $this->getZipInformations();
            }
        }
    }

    public function getZipInformations()
    {
        $response = Http::get("https://viacep.com.br/ws/{$this->state['zip']}/json/");
        if ($response->successful()) {
            $data = $response->json();

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

    public function render()
    {
        return view('users.address-form');
    }
}
