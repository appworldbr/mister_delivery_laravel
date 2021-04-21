<x-jet-form-section submit="saveFoodCategory">
    <x-slot name="title">
        {{ __('Food Category') }}
    </x-slot>
    <x-slot name="description">
        {{ __('Create or Update this Food Category.') }}
    </x-slot>
    <x-slot name="form">

        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="name" value="{{ __('Name') }}" />
            <x-jet-input id="name" type="text" class="mt-1 block w-full" wire:model.defer="state.name" />
            <x-jet-input-error for="name" class="mt-2" />
        </div>

        <div class="col-span6 sm:col-span-4">
            <x-jet-label for="icon" value="{{ __('Icon') }}" />
            <x-select id="icon" class="mt-1 block w-full" wire:model.defer="state.icon">
                <option value="hamburger">{{ __('Hamburger') }}</option>
                <option value="food">{{ __('Food') }}</option>
                <option value="japanese">{{ __('Japanese') }}</option>
                <option value="pastry">{{ __('Pastry') }}</option>
                <option value="candy">{{ __('Candy') }}</option>
                <option value="drink">{{ __('Drink') }}</option>
            </x-select>
            <x-jet-input-error for="icon" class="mt-2" />
        </div>

        @if ($foodCategory && $foodCategory->getDeletable())
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
        @if ($foodCategory && $foodCategory->getDeletable())
            <x-jet-danger-button type="button" wire:click="$toggle('confirmingDelete')">
                {{ __('Delete') }}
            </x-jet-danger-button>
        @endif
        <x-jet-button class="ml-4">
            {{ __('Save') }}
        </x-jet-button>
    </x-slot>
</x-jet-form-section>
