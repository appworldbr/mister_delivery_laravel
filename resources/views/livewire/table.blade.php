<div>
    <div class="flex flex-col w-full md:flex-row md:justify-between md:items-end">
        <div class="flex flex-row w-full justify-between items-end mb-4 md:w-auto">
            <div class="col-span-6 sm:col-span-4">
                <x-jet-label for="search" value="{{ __('Per Page') }}" />
                <x-select class="text-xs" wire:model="perPage">
                    <option value="10">10</option>
                    <option value="15">15</option>
                    <option value="20">20</option>
                </x-select>
            </div>
            @if ($model->getSearchable())
                <div class="col-span-6 ml-4 sm:col-span-4">
                    <x-jet-label for="search" value="{{ __('Search') }}" />
                    <x-jet-input id="search" type="text" class="block w-full text-xs"
                        wire:model.debounce.500ms="search" />
                </div>
            @endif
        </div>
        <div class="flex flex-row w-full justify-between items-end mb-4 md:w-auto">
            @if ($model->getBulkDeletable())
                @if (count($deleteList))
                    <x-jet-danger-button wire:click="$toggle('confirmingBulkDelete')">
                        {{ __('Bulk Delete') }}
                    </x-jet-danger-button>
                @else
                    <x-jet-danger-button wire:click="$toggle('confirmingBulkDelete')" disabled>
                        {{ __('Bulk Delete') }}
                    </x-jet-danger-button>
                @endif
            @endif
            @if ($model->getCreatable())
                <a href="{{ $model->getFormRoute() }}"
                    class="inline-flex items-center px-4 py-2 bg-green-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition' ml-2">
                    {{ __('Add') }}
                </a>
            @endif
        </div>
    </div>
    <div class="flex flex-col my-4">
        <div class="-my-2 overflow-x-auto md:-mx-6 lg:-mx-8">
            <div class="py-2 align-middle inline-block min-w-full md:px-6 lg:px-8">
                <div class="shadow overflow-hidden border-b border-gray-200 md:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                @if ($model->getBulkDeletable())
                                    <th scope="col" class="px-4 py-3 w-3">
                                        <div class="flex items-center relative">
                                            <input wire:model="pagesSelectedToDelete.{{ $page }}"
                                                type="checkbox" wire:loading.attr="disabled"
                                                wire:target="deleteList, pagesSelectedToDelete.{{ $page }}"
                                                wire:click="toggleThisPageToDelete"
                                                class="opacity-0 absolute h-5 w-5" />
                                            <div
                                                class="bg-white border-2 rounded-md border-gray-400 w-5 h-5 flex flex-shrink-0 justify-center items-center mr-2 focus-within:border-indigo-500">
                                                @if (isset($pagesSelectedTristage[$page]) && $pagesSelectedTristage[$page])
                                                    <svg class="fill-current hidden w-3 h-3 text-indigo-500 pointer-events-none"
                                                        version="1.1" viewBox="0 0 492 492"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M465.064 207.562H26.908C12.076 207.562 0 219.698 0 234.53v22.804c0 14.832 12.072 27.104 26.908 27.104h438.156c14.84 0 26.936-12.272 26.936-27.104V234.53c0-14.832-12.096-26.968-26.936-26.968z" />
                                                    </svg>
                                                @else
                                                    <svg class="fill-current hidden w-3 h-3 text-indigo-500 pointer-events-none"
                                                        version="1.1" viewBox="0 0 17 12"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <g fill="none" fill-rule="evenodd">
                                                            <g transform="translate(-9 -11)" fill="#1F73F1"
                                                                fill-rule="nonzero">
                                                                <path
                                                                    d="m25.576 11.414c0.56558 0.55188 0.56558 1.4439 0 1.9961l-9.404 9.176c-0.28213 0.27529-0.65247 0.41385-1.0228 0.41385-0.37034 0-0.74068-0.13855-1.0228-0.41385l-4.7019-4.588c-0.56584-0.55188-0.56584-1.4442 0-1.9961 0.56558-0.55214 1.4798-0.55214 2.0456 0l3.679 3.5899 8.3812-8.1779c0.56558-0.55214 1.4798-0.55214 2.0456 0z" />
                                                            </g>
                                                        </g>
                                                    </svg>
                                                @endif
                                            </div>
                                        </div>
                                    </th>
                                @endif
                                @foreach ($model->columns as $column)
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        @if (in_array($column, $model->sortableColumns))
                                            <button class="flex flex-row uppercase items-center focus:outline-none"
                                                wire:click="sortBy('{{ $column }}')">
                                                {{ __(Str::title($model->columnsName[$column] ?? $column)) }}
                                                @if ($column == $sortBy)
                                                    @if ($sortDirection == 'asc')
                                                        <div class="ml-3 p-2">
                                                            <svg class="h-3 w-3" xmlns="http://www.w3.org/2000/svg"
                                                                viewBox="0 0 451.847 451.847">
                                                                <path
                                                                    d="M225.923 354.706c-8.098 0-16.195-3.092-22.369-9.263L9.27 151.157c-12.359-12.359-12.359-32.397 0-44.751 12.354-12.354 32.388-12.354 44.748 0l171.905 171.915 171.906-171.909c12.359-12.354 32.391-12.354 44.744 0 12.365 12.354 12.365 32.392 0 44.751L248.292 345.449c-6.177 6.172-14.274 9.257-22.369 9.257z" />
                                                            </svg>
                                                        </div>
                                                    @else
                                                        <div class="ml-3 p-2 transform rotate-180">
                                                            <svg class="h-3 w-3" xmlns="http://www.w3.org/2000/svg"
                                                                viewBox="0 0 451.847 451.847">
                                                                <path
                                                                    d="M225.923 354.706c-8.098 0-16.195-3.092-22.369-9.263L9.27 151.157c-12.359-12.359-12.359-32.397 0-44.751 12.354-12.354 32.388-12.354 44.748 0l171.905 171.915 171.906-171.909c12.359-12.354 32.391-12.354 44.744 0 12.365 12.354 12.365 32.392 0 44.751L248.292 345.449c-6.177 6.172-14.274 9.257-22.369 9.257z" />
                                                            </svg>
                                                        </div>
                                                    @endif
                                                @else
                                                    <div class="ml-3 p-2">
                                                        <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg"
                                                            viewBox="0 0 492 492">
                                                            <path
                                                                d="M465.064 207.562H26.908C12.076 207.562 0 219.698 0 234.53v22.804c0 14.832 12.072 27.104 26.908 27.104h438.156c14.84 0 26.936-12.272 26.936-27.104V234.53c0-14.832-12.096-26.968-26.936-26.968z" />
                                                        </svg>
                                                    </div>
                                                @endif
                                            </button>
                                        @else
                                            {{ __(Str::title($model->columnsName[$column] ?? $column)) }}
                                        @endif
                                    </th>
                                @endforeach
                                <th scope="col" class="relative px-6 py-3">
                                    <span class="sr-only">
                                        {{ __('Edit') }}
                                    </span>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($items as $item)
                                <tr>
                                    @if ($model->getBulkDeletable())
                                        <td scope="col" class="px-4 py-4">
                                            <div class="flex items-center relative">
                                                <input wire:model="deleteList" type="checkbox"
                                                    value="{{ $item->id }}" class="opacity-0 absolute h-5 w-5"
                                                    wire:loading.attr="disabled"
                                                    wire:target="deleteList, pagesSelectedToDelete.{{ $page }}"
                                                    wire:click="validateTristage" />
                                                <div class="bg-white border-2 rounded-md border-gray-400 w-5 h-5 flex flex-shrink-0 justify-center items-center mr-2 focus-within:border-indigo-500"
                                                    wire:loading.class="bg-gray-100" wire:target="deleteList">
                                                    <svg class="fill-current hidden w-3 h-3 text-indigo-500 pointer-events-none"
                                                        version="1.1" viewBox="0 0 17 12"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <g fill="none" fill-rule="evenodd">
                                                            <g transform="translate(-9 -11)" fill="#1F73F1"
                                                                fill-rule="nonzero">
                                                                <path
                                                                    d="m25.576 11.414c0.56558 0.55188 0.56558 1.4439 0 1.9961l-9.404 9.176c-0.28213 0.27529-0.65247 0.41385-1.0228 0.41385-0.37034 0-0.74068-0.13855-1.0228-0.41385l-4.7019-4.588c-0.56584-0.55188-0.56584-1.4442 0-1.9961 0.56558-0.55214 1.4798-0.55214 2.0456 0l3.679 3.5899 8.3812-8.1779c0.56558-0.55214 1.4798-0.55214 2.0456 0z" />
                                                            </g>
                                                        </g>
                                                    </svg>
                                                </div>
                                            </div>
                                        </td>
                                    @endif
                                    @foreach ($model->columns as $column)
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            {{ $item->$column }}
                                        </td>
                                    @endforeach
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        @if ($item->getDeletable())
                                            <button wire:click="showDeleteModal({{ $item->id }})"
                                                class="px-3 py-1 inline-flex text-xs  font-semibold rounded bg-red-500 text-white opacity-25 hover:opacity-100 hover:bg-red-600 focus:border-red-700 active:bg-red-600 transition">
                                                {{ __('Delete') }}
                                            </button>
                                        @endif
                                        @if ($item->getEditable())
                                            <a href="{{ $item->getFormRoute() }}"
                                                class="px-3 py-1 inline-flex text-xs  font-semibold rounded bg-blue-500 text-white hover:bg-blue-600 focus:border-blue-700 active:bg-red-600 transition">
                                                {{ __('Edit') }}
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    {{ $items->links() }}

    @if ($model->getBulkDeletable())
        <x-jet-confirmation-modal wire:model="confirmingBulkDelete">
            <x-slot name="title">
                {{ __('Bulk Delete') }}
            </x-slot>

            <x-slot name="content">
                {{ __('Are you sure you want to delete? Once a time deleted, all of its resources and data will be permanently deleted.') }}
            </x-slot>

            <x-slot name="footer">
                <x-jet-secondary-button wire:click="$toggle('confirmingBulkDelete')" wire:loading.attr="disabled">
                    {{ __('Cancel') }}
                </x-jet-secondary-button>

                <x-jet-danger-button class="ml-2" wire:click="bulkDelete" wire:loading.attr="disabled">
                    {{ __('Delete') }}
                </x-jet-danger-button>
            </x-slot>
        </x-jet-confirmation-modal>
    @endif

    @if ($model->getDeletable())
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
</div>
