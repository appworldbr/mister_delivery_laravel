<div>
    @php
        $cardBorderColor = ['border-red-400', 'border-green-400', 'border-gray-400', 'border-yellow-400', 'border-blue-400'][$this->order->getRawOriginal('status')];
        $cardHeaderFooterColor = ['bg-red-200', 'bg-green-300', 'bg-gray-100', 'bg-yellow-100', 'bg-blue-200'][$this->order->getRawOriginal('status')];
    @endphp
    <div class="flex flex-col bg-white p-3 rounded-lg">
        <h1 class="font-bold pb-2">
            {{ __('Change Status of Order To') }}:
        </h1>
        <div class="flex -mx-3">
            <button wire:click="$toggle('confirmingChangeToConclude')"
                class="bg-green-600 border-green-600 text-white hover:bg-white hover:text-green-600 hover:shadow transition border py-2 px-4 rounded-full mx-3 text-sm">
                {{ __('Concluded') }}
            </button>
            <button wire:click="$toggle('confirmingChangeToDelivery')"
                class="bg-blue-600 border-blue-600 text-white hover:bg-white hover:text-blue-600 hover:shadow transition border py-2 px-4 rounded-full mx-3 text-sm">
                {{ __('Delivery') }}
            </button>
            <button wire:click="$toggle('confirmingChangeToPreparation')"
                class="bg-yellow-600 border-yellow-600 text-white hover:bg-white hover:text-yellow-600 hover:shadow transition border py-2 px-4 rounded-full mx-3 text-sm">
                {{ __('Preparation') }}
            </button>
            <button wire:click="$toggle('confirmingChangeToAwaitingApproval')"
                class="bg-gray-600 border-gray-600 text-white hover:bg-white hover:text-gray-600 hover:shadow transition border py-2 px-4 rounded-full mx-3 text-sm">
                {{ __('Awaiting Approval') }}
            </button>
            <button wire:click="$toggle('confirmingChangeToCancel')"
                class="bg-red-600 border-red-600 text-white hover:bg-white hover:text-red-600 hover:shadow transition border py-2 px-4 rounded-full mx-3 text-sm">
                {{ __('Cancel') }}
            </button>
        </div>
    </div>
    <div class="rounded-lg border-2 my-2 {{ $cardBorderColor }} overflow-hidden">
        <div class="flex justify-between items-center p-3 pb-3 {{ $cardHeaderFooterColor }}">
            <h3 class="font-bold">
                #{{ $order->id }} {{ $order->name }}
            </h3>
            <p class="font-bold">
                {{ $order->status_text }}
            </p>
        </div>
        <div class="bg-white p-3">

            <div class="mb-8">
                <h4 class="font-bold">{{ __('User') }}:</h4>
                <p>
                    <span class="font-bold text-gray-600">{{ __('Name') }}:</span> {{ $order->user->name }}
                </p>
                <p>
                    <span class="font-bold text-gray-600">{{ __('E-mail') }}:</span> {{ $order->user->email }}
                </p>
            </div>

            @php
                $telephones = $order->user->telephones;
            @endphp
            @if ($telephones)
                <div class="mb-8">
                    <h4 class="font-bold">{{ __('Telephones') }}:</h4>
                    <ul>
                        @foreach ($order->user->telephones as $telephone)
                            <li>
                                {{ $telephone->telephone }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="mb-8">
                <h4 class="font-bold">{{ __('Address') }}:</h4>
                <p class="leading-none">
                    {{ $order->address }},
                    {{ $order->number }}
                </p>
                <p class="leading-none">
                    {{ $order->district }},
                    {{ $order->city }} -
                    {{ $order->state }}
                    {{ $order->zip }}
                </p>
                <p class="leading-none">
                    {{ $order->complement }}
                </p>
            </div>

            <h4 class="font-bold">
                {{ __('Order') }}:
            </h4>
            <ul class="ml-5 list-disc">
                @foreach ($order->food as $food)
                    <li class="border-b pb-2 mb-2">
                        <div class="flex font-bold justify-between">
                            <div class="flex-shrink-0">
                                {{ $food->quantity }}x {{ $food->name }}
                            </div>
                            <div class="w-full overflow-hidden mx-2">
                                {{ str_repeat('.', 500) }}
                            </div>
                            <div class="flex-shrink-0">
                                R$ {{ number_format($food->getTotal($food->extras), 2, ',', '.') }}
                            </div>
                        </div>
                        <div>
                            @if (strlen($food->observation))
                                <div class="my-1">
                                    <h4 class="font-bold text-gray-700">
                                        {{ __('Observation') }}:
                                    </h4>
                                    <p>
                                        {{ $food->observation }}
                                    </p>
                                </div>
                            @endif
                            @if ($food->extras && count($food->extras))
                                <div class="my-1">
                                    <h4 class="font-bold text-gray-700">
                                        {{ __('Extras') }}:
                                    </h4>
                                    <ul>
                                        @foreach ($food->extras as $extra)
                                            <li>
                                                <div class="flex justify-between">
                                                    <div class="flex-shrink-0">
                                                        {{ $extra->quantity }}x {{ $extra->name }}
                                                    </div>
                                                    <div class="w-full overflow-hidden mx-2">
                                                        {{ str_repeat('.', 500) }}
                                                    </div>
                                                    <div class="flex-shrink-0">
                                                        R$
                                                        {{ number_format(round($extra->quantity * $extra->price, 2), 2, ',', '.') }}
                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="flex justify-between items-end p-3 {{ $cardHeaderFooterColor }}">
            <p class="font-bold text-lg">
                R$ {{ number_format($order->getTotal($order->food), 2, ',', '.') }}
            </p>
        </div>
    </div>

    <x-jet-confirmation-modal wire:model="confirmingChangeToAwaitingApproval">
        <x-slot name="title">
            {{ __('Change Status To Awaiting Approval') }}
        </x-slot>

        <x-slot name="content">
            {{ __('Are you sure you want to change the status to awaiting approval.') }}
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('confirmingChangeToAwaitingApproval')"
                wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>

            <x-jet-danger-button class="ml-2" wire:click="changeToAwaitingApproval" wire:loading.attr="disabled">
                {{ __('Confirm') }}
            </x-jet-danger-button>
        </x-slot>
    </x-jet-confirmation-modal>

    <x-jet-confirmation-modal wire:model="confirmingChangeToPreparation">
        <x-slot name="title">
            {{ __('Change Status To Preparation') }}
        </x-slot>

        <x-slot name="content">
            {{ __('Are you sure you want to change the status to preparation.') }}
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('confirmingChangeToPreparation')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>

            <x-jet-danger-button class="ml-2" wire:click="changeToPreparation" wire:loading.attr="disabled">
                {{ __('Confirm') }}
            </x-jet-danger-button>
        </x-slot>
    </x-jet-confirmation-modal>

    <x-jet-confirmation-modal wire:model="confirmingChangeToDelivery">
        <x-slot name="title">
            {{ __('Change Status To Delivery') }}
        </x-slot>

        <x-slot name="content">
            {{ __('Are you sure you want to change the status to delivery.') }}
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('confirmingChangeToDelivery')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>

            <x-jet-danger-button class="ml-2" wire:click="changeToDelivery" wire:loading.attr="disabled">
                {{ __('Confirm') }}
            </x-jet-danger-button>
        </x-slot>
    </x-jet-confirmation-modal>

    <x-jet-confirmation-modal wire:model="confirmingChangeToConclude">
        <x-slot name="title">
            {{ __('Change Status To Conclude') }}
        </x-slot>

        <x-slot name="content">
            {{ __('Are you sure you want to change the status to conclude.') }}
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('confirmingChangeToConclude')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>

            <x-jet-danger-button class="ml-2" wire:click="changeToConclude" wire:loading.attr="disabled">
                {{ __('Confirm') }}
            </x-jet-danger-button>
        </x-slot>
    </x-jet-confirmation-modal>

    <x-jet-confirmation-modal wire:model="confirmingChangeToCancel">
        <x-slot name="title">
            {{ __('Change Status To Cancel') }}
        </x-slot>

        <x-slot name="content">
            {{ __('Are you sure you want to change the status to cancel.') }}
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('confirmingChangeToCancel')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>

            <x-jet-danger-button class="ml-2" wire:click="changeToCancel" wire:loading.attr="disabled">
                {{ __('Confirm') }}
            </x-jet-danger-button>
        </x-slot>
    </x-jet-confirmation-modal>
</div>
