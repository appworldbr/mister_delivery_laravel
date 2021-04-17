<?php

namespace App\Http\Livewire;

use App\Actions\Fortify\PasswordValidationRules;
use App\Models\User;
use Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Rules\Password;
use Livewire\Component;

class UserForm extends Component
{
    use PasswordValidationRules;
    use AuthorizesRequests;

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

        if (!$this->user) {
            $this->authorize('user:create');
            $data = [
                'name' => $this->state['name'],
                'email' => $this->state['email'],
                'password' => Hash::make($this->state['password']),
            ];
            $this->user = User::create($data);
        } else {
            $this->authorize('user:update');
            $data = [
                'name' => $this->state['name'],
                'email' => $this->state['email'],
            ];
            if (isset($this->state['password'])) {
                $data['password'] = Hash::make($this->state['password']);
            }
            $this->user->update($data);
        }

        if (isset($this->state['roles'])) {
            $this->user->syncRoles($this->state['roles']);
        }

        return redirect()->route("users.index");
    }

    public function delete()
    {
        $this->authorize('user:delete');

        if (!Auth::user()->hasRole('admin')) {
            if ($this->user->hasRole('admin')) {
                abort(403);
            }
        }

        if ($this->user->id == Auth::id()) {
            abort(403);
        }

        $this->user->delete();
        return redirect()->route("users.index");
    }

    public function mount()
    {
        if ($this->user) {
            $this->state = [
                'name' => $this->user->name,
                'email' => $this->user->email,
                'roles' => $this->user->getRoleNames()->toArray(),
            ];
        }
    }

    public function render()
    {
        return view('users.user-form');
    }
}
