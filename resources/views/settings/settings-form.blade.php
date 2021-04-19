<x-jet-form-section submit="saveSettings">
    <x-slot name="title">
        {{ __('Settings') }}
    </x-slot>
    <x-slot name="description">
        {{ __('Create or Update your Settings.') }}
    </x-slot>
    <x-slot name="form">
        <div x-data="{logoName: null, logoPreview: null}" class="col-span-6 sm:col-span-4">
            <input type="file" class="hidden" wire:model="logo" x-ref="logo" x-on:change="
                    logoName = $refs.logo.files[0].name;
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        logoPreview = e.target.result;
                    };
                    reader.readAsDataURL($refs.logo.files[0]);
            " />

            <div class="mt-2" x-show="!logoPreview">
                <img src="{{ $logoUrl }}" alt="{{ __('Logo') }}" class="rounded-lg h-20 w-20 object-cover">
            </div>

            <div class="mt-2" x-show="logoPreview">
                <span class="block rounded-lg w-20 h-20"
                    x-bind:style="'background-size: cover; background-repeat: no-repeat; background-position: center center; background-image: url(\'' + logoPreview + '\');'">
                </span>
            </div>

            <x-jet-label for="logo" value="{{ __('Logo') }}" />

            <x-jet-secondary-button class="mt-2 mr-2" type="button" x-on:click.prevent="$refs.logo.click()">
                {{ __('Select A New Logo') }}
            </x-jet-secondary-button>

            <x-jet-input-error for="logo" class="mt-2" />
        </div>
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="name" value="{{ __('Name') }}" />
            <x-jet-input id="name" type="text" class="mt-1 block w-full" wire:model.defer="state.name" />
            <x-jet-input-error for="name" class="mt-2" />
        </div>
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="description" value="{{ __('Description') }}" />
            <x-jet-input id="description" type="text" class="mt-1 block w-full" wire:model.defer="state.description" />
            <x-jet-input-error for="description" class="mt-2" />
        </div>
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="address" value="{{ __('Address') }}" />
            <x-jet-input id="address" type="text" class="mt-1 block w-full" wire:model.defer="state.address" />
            <x-jet-input-error for="address" class="mt-2" />
        </div>
    </x-slot>
    <x-slot name="actions">
        <x-jet-action-message class="mr-3" on="saved">
            {{ __('Saved.') }}
        </x-jet-action-message>

        <x-jet-button class="ml-4">
            {{ __('Save') }}
        </x-jet-button>
    </x-slot>
</x-jet-form-section>
