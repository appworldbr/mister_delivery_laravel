<?php

namespace App\Http\Livewire;

use App\Actions\Fortify\PasswordValidationRules;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Rules\Password;
use Livewire\Component;

class UserForm extends Component
{
    use PasswordValidationRules;

    public $user;
    public $state = [];
    public $confirmingDelete = false;

    public function saveUser()
    {
        $validatorEmail = $this->user
        ? ['required', 'string', 'email', 'max:255', "unique:users,email,{$this->user->id}"]
        : ['required', 'string', 'email', 'max:255', 'unique:users'];

        $validatorPassword = $this->user
        ? ['nullable', 'string', new Password]
        : ['required', 'string', new Password];

        Validator::make($this->state, [
            'name' => ['required', 'string', 'max:255'],
            'email' => $validatorEmail,
            'password' => $validatorPassword,
        ])->validate();

        if (isset($this->state['password']) && strlen($this->state['password'])) {
            $this->state['password'] = Hash::make($this->state['password']);
        }

        if (!$this->user) {
            $this->user = User::create($this->state);
        } else {
            $this->user->update($this->state);
        }

        return redirect()->route("users.index");
    }

    public function mount()
    {
        if ($this->user) {
            $this->state = [
                'name' => $this->user->name,
                'email' => $this->user->email,
            ];
        }
    }

    public function render()
    {
        return view('users.user-form');
    }
}
