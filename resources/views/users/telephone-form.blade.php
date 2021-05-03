<div>
    @if ($user)
        <div class="mt-10 sm:mt-0">
            <x-jet-action-section>
                <x-slot name="title">
                    {{ __('Telephones Registered') }}
                </x-slot>

                <x-slot name="description">
                    {{ __('Manage the registered telephone.') }}
                </x-slot>

                <x-slot name="content">
                    <div class="space-y-8">
                        @php
                            $all_telephones = $user->telephones()->get();
                        @endphp
                        @if (count($all_telephones))
                            @foreach ($all_telephones as $_telephone)
                                <div class="flex items-center justify-between">
                                    <div class="@if ($_telephone->is_default) font-bold @endif">
                                        {{ $_telephone->telephone }}
                                    </div>
                                    <div class="flex">
                                        @if (!$_telephone->is_default)
                                            <button
                                                class="mx-2 px-3 py-1 inline-flex text-xs font-semibold rounded bg-red-500 text-white opacity-25 hover:opacity-100 hover:bg-red-600 focus:border-red-700 active:bg-red-600 transition"
                                                wire:click="showTelephoneModalDelete({{ $_telephone->id }})">
                                                {{ __('Delete') }}
                                            </button>
                                        @endif
                                        <button
                                            class="mx-2 px-3 py-1 inline-flex text-xs font-semibold rounded bg-blue-500 text-white hover:bg-blue-600 focus:border-blue-700 active:bg-red-600 transition"
                                            wire:click="editTelephone({{ $_telephone->id }})">
                                            {{ __('Edit') }}
                                        </button>
                                        <button
                                            class="ml-2 px-3 py-1 inline-flex text-xs font-semibold rounded bg-green-500 text-white hover:bg-blue-600 focus:border-blue-700 active:bg-red-600 transition"
                                            wire:click="setAddressAsDefault({{ $_telephone->id }})">
                                            {{ __('Set as Default') }}
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div>{{ __('No Record') }}</div>
                        @endif
                    </div>
                </x-slot>
            </x-jet-action-section>
            <x-jet-confirmation-modal wire:model="confirmingTelephoneDelete">
                <x-slot name="title">
                    {{ __('Delete') }}
                </x-slot>

                <x-slot name="content">
                    {{ __('Are you sure you want to delete? Once a time deleted, all of its resources and data will be permanently deleted.') }}
                </x-slot>

                <x-slot name="footer">
                    <x-jet-secondary-button wire:click="closeTelephoneModalDelete" wire:loading.attr="disabled">
                        {{ __('Cancel') }}
                    </x-jet-secondary-button>

                    <x-jet-danger-button class="ml-2" wire:click="deleteTelephone" wire:loading.attr="disabled">
                        {{ __('Delete') }}
                    </x-jet-danger-button>
                </x-slot>
            </x-jet-confirmation-modal>
        </div>
        <x-jet-section-border />
        <x-jet-form-section submit="saveTelephone">
            <x-slot name="title">
                {{ __('Telephone') }}
            </x-slot>
            <x-slot name="description">
                {{ __('Create or Update a Telephone.') }}
            </x-slot>
            <x-slot name="form">
                <div class="col-span-6 sm:col-span-4">
                    <x-jet-label for="telephone" value="{{ __('Telephone') }}" />
                    <x-jet-input id="telephone" type="text" class="mt-1 block w-full"
                        wire:model.debounce.500ms="state.telephone" />
                    <x-jet-input-error for="telephone" class="mt-2" />
                </div>
            </x-slot>
            <x-slot name="actions">
                <x-jet-action-message class="mr-3" on="saved">
                    {{ __('Saved.') }}
                </x-jet-action-message>

                @if ($telephone)
                    <x-jet-secondary-button class="ml-4" wire:click="createNew">
                        {{ __('Create New') }}
                    </x-jet-secondary-button>
                @endif

                <x-jet-button class="ml-4">
                    {{ __('Save') }}
                </x-jet-button>
            </x-slot>
        </x-jet-form-section>
    @endif
</div>
