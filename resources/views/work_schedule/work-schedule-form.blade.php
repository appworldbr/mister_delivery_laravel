<x-jet-form-section submit="save">
    <x-slot name="title">
        {{ __('Work Schedule') }}
    </x-slot>
    <x-slot name="description">
        {{ __('Create or Update this Work Schedule.') }}
    </x-slot>
    <x-slot name="form">
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="weekday" value="{{ __('Weekday') }}" />
            <x-select id="weekday" name="weekday" class="mt-1 block w-full" wire:model.defer="state.weekday">
                <option value="0">{{ __('Sunday') }}</option>
                <option value="1">{{ __('Monday') }}</option>
                <option value="2">{{ __('Tuesday') }}</option>
                <option value="3">{{ __('Wednesday') }}</option>
                <option value="4">{{ __('Thursday') }}</option>
                <option value="5">{{ __('Friday') }}</option>
                <option value="6">{{ __('Saturday') }}</option>
            </x-select>
            <x-jet-input-error for="weekday" class="mt-2" />
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="start" value="{{ __('Start') }}" />
            <x-jet-input id="start" type="text" class="mt-1 block w-full" wire:model.debounce.500ms="state.start" />
            <x-jet-input-error for="start" class="mt-2" />
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="end" value="{{ __('End') }}" />
            <x-jet-input id="end" type="text" class="mt-1 block w-full" wire:model.debounce.500ms="state.end" />
            <x-jet-input-error for="end" class="mt-2" />
        </div>

        @if ($workSchedule && $workSchedule->getDeletable())
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
        @if ($workSchedule && $workSchedule->getDeletable())
            <x-jet-danger-button type="button" wire:click="$toggle('confirmingDelete')">
                {{ __('Delete') }}
            </x-jet-danger-button>
        @endif
        <x-jet-button class="ml-4">
            {{ __('Save') }}
        </x-jet-button>
    </x-slot>
</x-jet-form-section>
