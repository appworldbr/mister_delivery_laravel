<x-jet-form-section submit="save">
    <x-slot name="title">
        {{ __('Extra') }}
    </x-slot>
    <x-slot name="description">
        {{ __('Create or Update this Extra.') }}
    </x-slot>
    <x-slot name="form">

        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="name" value="{{ __('Name') }}" />
            <x-jet-input id="name" type="text" class="mt-1 block w-full" wire:model.defer="state.name"
                autocomplete="name" />
            <x-jet-input-error for="name" class="mt-2" />
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="price" value="{{ __('Price') }}" />
            <x-jet-input id="price" type="text" class="mt-1 block w-full" wire:model.debounce.500ms="state.price" />
            <x-jet-input-error for="price" class="mt-2" />
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="limit" value="{{ __('Limit') }}" />
            <x-jet-input id="limit" type="number" step="1" min="1" class="mt-1 block w-full"
                wire:model.debounce.500ms="state.limit" />
            <x-jet-input-error for="limit" class="mt-2" />
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="category_id" value="{{ __('Category') }}" />
            <x-select id="category_id" class="mt-1 block w-full" wire:model.defer="state.category_id">
                @foreach (\App\Models\FoodCategory::all() as $foodCategory)
                    <option value="{{ $foodCategory->id }}">{{ $foodCategory->name }}</option>
                @endforeach
            </x-select>
            <x-jet-input-error for="category_id" class="mt-2" />
        </div>


        <div class="col-span-6 sm:col-span-4">
            <div class="mt-2 grid grid-cols-1 md:grid-cols-2 gap-4">
                <label class="flex items-center">
                    <x-jet-checkbox wire:model.defer="state.active" value="1" />
                    <span class="ml-2 text-sm text-gray-600">{{ __('Active') }}</span>
                </label>
            </div>
            <x-jet-input-error for="active" class="mt-2" />
        </div>

        @if ($foodExtra && $foodExtra->getDeletable())
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
        @if ($foodExtra && $foodExtra->getDeletable())
            <x-jet-danger-button type="button" wire:click="$toggle('confirmingDelete')">
                {{ __('Delete') }}
            </x-jet-danger-button>
        @endif
        <x-jet-button class="ml-4">
            {{ __('Save') }}
        </x-jet-button>
    </x-slot>
</x-jet-form-section>
