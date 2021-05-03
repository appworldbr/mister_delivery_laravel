<div>
    <x-jet-form-section submit="save">
        <x-slot name="title">
            {{ __('Day Off') }}
        </x-slot>
        <x-slot name="description">
            {{ __('Create or Update this Day Off.') }}
        </x-slot>
        <x-slot name="form">
            <div class="col-span-6 sm:col-span-4">
                <x-jet-label for="dat" value="{{ __('Day') }}" />
                <x-jet-input id="day" type="text" class="mt-1 block w-full" wire:model.debounce.500ms="state.day" />
                <x-jet-input-error for="day" class="mt-2" />
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

            @if ($dayOff && $dayOff->getDeletable())
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
            @if ($dayOff && $dayOff->getDeletable())
                <x-jet-danger-button type="button" wire:click="$toggle('confirmingDelete')">
                    {{ __('Delete') }}
                </x-jet-danger-button>
            @endif
            <x-jet-button class="ml-4">
                {{ __('Save') }}
            </x-jet-button>
        </x-slot>
    </x-jet-form-section>
    @push('scripts')
        <script>
            datepicker('#day', {
                formatter: (input, date, instance) => {
                    const value = date.toLocaleDateString('pt-BR')
                    input.value = value
                },
                customDays: [
                    'D',
                    'S',
                    'T',
                    'Q',
                    'Q',
                    'S',
                    'S'
                ],
                customMonths: [
                    'Jan',
                    'Fev',
                    'Mar',
                    'Abr',
                    'Mai',
                    'Jun',
                    'Jul',
                    'Ago',
                    'Set',
                    'Out',
                    'Nov',
                    'Dez'
                ],
                disableYearOverlay: true
            });

        </script>
    @endpush
</div>
