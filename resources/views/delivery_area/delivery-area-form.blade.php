<x-jet-form-section submit="saveDeliveryArea">
    <x-slot name="title">
        {{ __('Delivery Area') }}
    </x-slot>
    <x-slot name="description">
        {{ __('Create or Update this Delivery Area.') }}
    </x-slot>
    <x-slot name="form">
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="initial" value="{{ __('Initial ZIP') }}" />
            <x-jet-input id="initial" type="text" class="mt-1 block w-full" wire:model.debounce.500ms="state.initial" />
            <x-jet-input-error for="initial" class="mt-2" />
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="final" value="{{ __('Final ZIP') }}" />
            <x-jet-input id="final" type="text" class="mt-1 block w-full" wire:model.debounce.500ms="state.final" />
            <x-jet-input-error for="final" class="mt-2" />
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="price" value="{{ __('Price') }}" />
            <x-jet-input id="price" type="text" class="mt-1 block w-full" wire:model.debounce.500ms="state.price" />
            <x-jet-input-error for="price" class="mt-2" />
        </div>

        <div class="col-span-6 sm:col-span-4">
            <div class="mt-2 grid grid-cols-1 md:grid-cols-2 gap-4">
                <label class="flex items-center">
                    <x-jet-checkbox wire:model.defer="state.prevent" value="1" />
                    <span class="ml-2 text-sm text-gray-600">{{ __('Preventable') }}</span>
                </label>
            </div>
            <x-jet-input-error for="prevent" class="mt-2" />
        </div>

        @if ($deliveryArea && $deliveryArea->getDeletable())
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
        @if ($deliveryArea && $deliveryArea->getDeletable($deliveryArea))
            <x-jet-danger-button type="button" wire:click="$toggle('confirmingDelete')">
                {{ __('Delete') }}
            </x-jet-danger-button>
        @endif
        <x-jet-button class="ml-4">
            {{ __('Save') }}
        </x-jet-button>
    </x-slot>
</x-jet-form-section>
