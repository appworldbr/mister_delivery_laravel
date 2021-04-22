<x-jet-form-section submit="saveFood">
    <x-slot name="title">
        {{ __('Food') }}
    </x-slot>
    <x-slot name="description">
        {{ __('Create or Update this Food.') }}
    </x-slot>
    <x-slot name="form">

        <div x-data="{imageName: null, imagePreview: null}" class="col-span-6 sm:col-span-4">
            <input type="file" class="hidden" wire:model="image" x-ref="image" x-on:change="
                    imageName = $refs.image.files[0].name;
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        imagePreview = e.target.result;
                    };
                    reader.readAsDataURL($refs.image.files[0]);
            " />

            @if ($this->food)
                <div class="mt-2" x-show="!imagePreview">
                    <img src="{{ $this->food->image_url }}" alt="{{ __('Image') }}"
                        class="rounded-lg h-20 w-20 object-cover">
                </div>
            @endif

            <div class="mt-2" x-show="imagePreview">
                <span class="block rounded-lg w-20 h-20"
                    x-bind:style="'background-size: cover; background-repeat: no-repeat; background-position: center center; background-image: url(\'' + imagePreview + '\');'">
                </span>
            </div>

            <x-jet-label for="image" value="{{ __('Image') }}" />

            <x-jet-secondary-button class="mt-2 mr-2" type="button" x-on:click.prevent="$refs.image.click()">
                {{ __('Select a Image') }}
            </x-jet-secondary-button>

            <x-jet-input-error for="image" class="mt-2" />
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="name" value="{{ __('Name') }}" />
            <x-jet-input id="name" type="text" class="mt-1 block w-full" wire:model.defer="state.name"
                autocomplete="name" />
            <x-jet-input-error for="name" class="mt-2" />
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="description" value="{{ __('Description') }}" />
            <x-textarea id="description" class="mt-1 block w-full h-32 resize-none"
                wire:model.defer="state.description" />
            <x-jet-input-error for="description" class="mt-2" />
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
            <x-jet-label for="price" value="{{ __('Price') }}" />
            <x-jet-input id="price" type="text" class="mt-1 block w-full" wire:model.debounce.500ms="state.price" />
            <x-jet-input-error for="price" class="mt-2" />
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

        @if ($food && $food->getDeletable())
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
        @if ($food && $food->getDeletable())
            <x-jet-danger-button type="button" wire:click="$toggle('confirmingDelete')">
                {{ __('Delete') }}
            </x-jet-danger-button>
        @endif
        <x-jet-button class="ml-4">
            {{ __('Save') }}
        </x-jet-button>
    </x-slot>
</x-jet-form-section>
