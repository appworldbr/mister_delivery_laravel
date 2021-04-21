<?php

namespace App\Http\Livewire;

use App\Models\Setting;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Livewire\WithFileUploads;
use Storage;

class SettingsForm extends Component
{
    use AuthorizesRequests;
    use WithFileUploads;

    public $state = [];
    public $logo;
    public $logoUrl;

    public function saveSettings()
    {
        $this->authorize('settings:update');

        $logoValidator = strlen($this->state['logo'])
        ? ['nullable', 'mimes:jpg,jpeg,png', 'max:1024']
        : ['required', 'mimes:jpg,jpeg,png', 'max:1024'];

        Validator::make(array_merge($this->state, ['logo' => $this->logo]), [
            'logo' => $logoValidator,
            'name' => ['required', 'min:2', 'max:100'],
            'description' => ['max:500'],
            'address' => ['max:150'],
        ])->validate();

        if ($this->logo) {
            tap($this->state['logo'], function ($previous) {
                $this->state['logo'] = $this->logo->storePublicly('settings', 'public');

                if ($previous) {
                    Storage::disk('public')->delete($previous);
                }
            });
        }

        Setting::set($this->state);

        $this->emit('saved');
    }

    public function mount()
    {
        $this->state = Setting::get(['logo', 'name', 'description', 'address']);

        $this->logoUrl = strlen($this->state['logo'])
        ? Storage::disk('public')->url($this->state['logo'])
        : Storage::disk('public')->url('/default.png');
    }

    public function render()
    {
        return view('settings.settings-form');
    }
}
