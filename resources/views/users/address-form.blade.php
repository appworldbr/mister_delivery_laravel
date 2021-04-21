<div>
    @if ($user)
        <div class="mt-10 sm:mt-0">
            <x-jet-action-section>
                <x-slot name="title">
                    {{ __('Address Registered') }}
                </x-slot>

                <x-slot name="description">
                    {{ __('Manage the registered address.') }}
                </x-slot>

                <x-slot name="content">
                    <div class="space-y-8">
                        @php
                            $all_address = $user->address()->get();
                        @endphp
                        @if (count($all_address))
                            @foreach ($all_address as $_address)
                                <div class="flex items-center justify-between">
                                    <div class="@if ($_address->is_default) font-bold @endif">
                                        {{ $_address->name }}
                                    </div>
                                    <div class="flex">
                                        @if (!$_address->is_default)
                                            <button
                                                class="mx-2 px-3 py-1 inline-flex text-xs font-semibold rounded bg-red-500 text-white opacity-25 hover:opacity-100 hover:bg-red-600 focus:border-red-700 active:bg-red-600 transition"
                                                wire:click="showAddressModalDelete({{ $_address->id }})">
                                                {{ __('Delete') }}
                                            </button>
                                        @endif
                                        <button
                                            class="mx-2 px-3 py-1 inline-flex text-xs font-semibold rounded bg-blue-500 text-white hover:bg-blue-600 focus:border-blue-700 active:bg-red-600 transition"
                                            wire:click="editAddress({{ $_address->id }})">
                                            {{ __('Edit') }}
                                        </button>
                                        <button
                                            class="ml-2 px-3 py-1 inline-flex text-xs font-semibold rounded bg-green-500 text-white hover:bg-blue-600 focus:border-blue-700 active:bg-red-600 transition"
                                            wire:click="setAddressAsDefault({{ $_address->id }})">
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
            <x-jet-confirmation-modal wire:model="confirmingAddressDelete">
                <x-slot name="title">
                    {{ __('Delete') }}
                </x-slot>

                <x-slot name="content">
                    {{ __('Are you sure you want to delete? Once a time deleted, all of its resources and data will be permanently deleted.') }}
                </x-slot>

                <x-slot name="footer">
                    <x-jet-secondary-button wire:click="$toggle('confirmingAddressDelete')"
                        wire:loading.attr="disabled">
                        {{ __('Cancel') }}
                    </x-jet-secondary-button>

                    <x-jet-danger-button class="ml-2" wire:click="deleteAddress" wire:loading.attr="disabled">
                        {{ __('Delete') }}
                    </x-jet-danger-button>
                </x-slot>
            </x-jet-confirmation-modal>
        </div>
        <x-jet-section-border />
        <x-jet-form-section submit="saveAddress">
            <x-slot name="title">
                {{ __('Address') }}
            </x-slot>
            <x-slot name="description">
                {{ __('Create or Update a Address.') }}
            </x-slot>
            <x-slot name="form">
                <div class="col-span-6 sm:col-span-4">
                    <x-jet-label for="name" value="{{ __('Name') }}" />
                    <x-jet-input id="name" type="text" class="mt-1 block w-full" wire:model.defer="state.name" />
                    <x-jet-input-error for="name" class="mt-2" />
                </div>
                <div class="col-span-6 sm:col-span-1 sm:col-start-1">
                    <x-jet-label for="zip" value="{{ __('Zip') }}" />
                    <x-jet-input id="zip" type="text" class="mt-1 block w-full" wire:model.debounce.500ms="state.zip" />
                    <x-jet-input-error for="zip" class="mt-2" />
                </div>
                <div class="col-span-6 sm:col-span-2">
                    <x-jet-label for="state" value="{{ __('State') }}" />
                    <x-select id="state" class="mt-1 block w-full" wire:model.defer="state.state">
                        <option value="AC">Acre</option>
                        <option value="AL">Alagoas</option>
                        <option value="AP">Amapá</option>
                        <option value="AM">Amazonas</option>
                        <option value="BA">Bahia</option>
                        <option value="CE">Ceará</option>
                        <option value="DF">Distrito Federal</option>
                        <option value="ES">Espírito Santo</option>
                        <option value="GO">Goiás</option>
                        <option value="MA">Maranhão</option>
                        <option value="MT">Mato Grosso</option>
                        <option value="MS">Mato Grosso do Sul</option>
                        <option value="MG">Minas Gerais</option>
                        <option value="PA">Pará</option>
                        <option value="PB">Paraíba</option>
                        <option value="PR">Paraná</option>
                        <option value="PE">Pernambuco</option>
                        <option value="PI">Piauí</option>
                        <option value="RJ">Rio de Janeiro</option>
                        <option value="RN">Rio Grande do Norte</option>
                        <option value="RS">Rio Grande do Sul</option>
                        <option value="RO">Rondônia</option>
                        <option value="RR">Roraima</option>
                        <option value="SC">Santa Catarina</option>
                        <option value="SP">São Paulo</option>
                        <option value="SE">Sergipe</option>
                        <option value="TO">Tocantins</option>
                    </x-select>
                    <x-jet-input-error for="state" class="mt-2" />
                </div>
                <div class="col-span-6 sm:col-span-2 sm:col-start-1">
                    <x-jet-label for="city" value="{{ __('City') }}" />
                    <x-jet-input id="city" type="text" class="mt-1 block w-full" wire:model.defer="state.city" />
                    <x-jet-input-error for="city" class="mt-2" />
                </div>
                <div class="col-span-6 sm:col-span-2">
                    <x-jet-label for="district" value="{{ __('District') }}" />
                    <x-jet-input id="district" type="text" class="mt-1 block w-full"
                        wire:model.defer="state.district" />
                    <x-jet-input-error for="district" class="mt-2" />
                </div>
                <div class="col-span-6 sm:col-span-3 sm:col-start-1">
                    <x-jet-label for="address" value="{{ __('Address') }}" />
                    <x-jet-input id="address" type="text" class="mt-1 block w-full" wire:model.defer="state.address" />
                    <x-jet-input-error for="address" class="mt-2" />
                </div>
                <div class="col-span-6 sm:col-span-1">
                    <x-jet-label for="number" value="{{ __('Number') }}" />
                    <x-jet-input id="number" type="text" class="mt-1 block w-full" wire:model.defer="state.number" />
                    <x-jet-input-error for="number" class="mt-2" />
                </div>
                <div class="col-span-6 sm:col-span-4">
                    <x-jet-label for="complement" value="{{ __('Complement') }}" />
                    <x-jet-input id="complement" type="text" class="mt-1 block w-full"
                        wire:model.defer="state.complement" />
                    <x-jet-input-error for="complement" class="mt-2" />
                </div>
            </x-slot>
            <x-slot name="actions">
                <x-jet-action-message class="mr-3" on="saved">
                    {{ __('Saved.') }}
                </x-jet-action-message>

                @if ($address)
                    <x-jet-secondary-button class="ml-4" wire:click="createNew">
                        {{ __('Create New') }}
                    </x-jet-secondary-button>
                @endif

                <x-jet-button class="ml-4">
                    {{ __('Save') }}
                </x-jet-button>
            </x-slot>
        </x-jet-form-section>
        <x-jet-section-border />
    @endif
</div>
