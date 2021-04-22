<x-jet-form-section submit="save">
    <x-slot name="title">
        {{ __('User') }}
    </x-slot>
    <x-slot name="description">
        {{ __('Create or Update this User.') }}
    </x-slot>
    <x-slot name="form">
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="name" value="{{ __('Name') }}" />
            <x-jet-input id="name" type="text" class="mt-1 block w-full" wire:model.defer="state.name" />
            <x-jet-input-error for="name" class="mt-2" />
        </div>
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="email" value="{{ __('Email') }}" />
            <x-jet-input id="email" type="email" class="mt-1 block w-full" wire:model.defer="state.email" />
            <x-jet-input-error for="email" class="mt-2" />
        </div>
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="password" value="{{ __('Password') }}" />
            <x-jet-input id="password" type="password" class="mt-1 block w-full" wire:model.defer="state.password" />
            <x-jet-input-error for="password" class="mt-2" />
        </div>
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="permissions" value="{{ __('Roles') }}" />
            <div class="mt-2 grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach (\Spatie\Permission\Models\Role::all() as $role)
                    <label class="flex items-center">
                        <x-jet-checkbox wire:model.defer="state.roles" :value="$role->name" />
                        <span class="ml-2 text-sm text-gray-600">{{ __(Str::title($role->name)) }}</span>
                    </label>
                @endforeach
            </div>
        </div>
        @if ($user && $user->getDeletable())
            <x-jet-confirmation-modal wire:model="confirmingDelete">
                <x-slot name="title">
                    {{ __('Delete') }}
                </x-slot>

                <x-slot name="content">
                    {{ __('Are you sure you want to delete? Once a time deleted, all of its resources and data will be permanently deleted.') }}
                </x-slot>

                <x-slot name="footer">
                    <x-jet-secondary-button wire:click="$toggle('confirmingDelete')" wire:loading.attr="disabled">
                        {{ __('Cancel') }}
                    </x-jet-secondary-button>

                    <x-jet-danger-button class="ml-2" wire:click="delete" wire:loading.attr="disabled">
                        {{ __('Delete') }}
                    </x-jet-danger-button>
                </x-slot>
            </x-jet-confirmation-modal>
        @endif
    </x-slot>
    <x-slot name="actions">
        @if ($user && $user->getDeletable($user))
            <x-jet-danger-button type="button" wire:click="$toggle('confirmingDelete')">
                {{ __('Delete') }}
            </x-jet-danger-button>
        @endif
        <x-jet-button class="ml-4">
            {{ __('Save') }}
        </x-jet-button>
    </x-slot>
</x-jet-form-section>
