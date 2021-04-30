<div wire:poll="reloadOrders" x-data="{ open: false }" :class="{'fixed top-0 left-0': open, 'relative': ! open}"
    class="w-full max-w-full overflow-x-visible overflow-y-hidden thin-scrollbar thin-scrollbar-horizontal flex h-screen pb-12 bg-white px-2 mx-auto">

    <x-order-column>
        <x-slot name="title">
            {{ __('Awaiting Approval') }}
        </x-slot>

        @foreach ($orders->where('status', \App\Models\Order::STATUS_WAITING) as $order)
            <x-order-card class="bg-gray-200 border-gray-300" :order="$order">
                <x-slot name="actions">
                    <x-order-card-button wire:click="showCancelModal({{ $order->id }})"
                        class="bg-red-500 opacity-25 hover:opacity-100">
                        {{ __('Cancel') }}
                    </x-order-card-button>
                    <x-order-card-button wire:click="showPreparationModal({{ $order->id }})"
                        class="bg-yellow-500 hover:bg-yellow-600">
                        {{ __('Go To Preparation') }}
                    </x-order-card-button>
                </x-slot>
            </x-order-card>
        @endforeach
    </x-order-column>

    <x-order-column>
        <x-slot name="title">
            {{ __('In Preparation') }}
        </x-slot>

        @foreach ($orders->where('status', \App\Models\Order::STATUS_PREPARATION) as $order)
            <x-order-card class="bg-yellow-100 border-yellow-200" :order="$order">
                <x-slot name="actions">
                    <x-order-card-button wire:click="showCancelModal({{ $order->id }})"
                        class="bg-red-500 opacity-25 hover:opacity-100">
                        {{ __('Cancel') }}
                    </x-order-card-button>
                    <x-order-card-button wire:click="showDeliveryModal({{ $order->id }})"
                        class="bg-blue-500 hover:bg-blue-600">
                        {{ __('Go To Delivery') }}
                    </x-order-card-button>
                </x-slot>
            </x-order-card>
        @endforeach
    </x-order-column>

    <x-order-column>
        <x-slot name="title">
            {{ __('In Delivery') }}
        </x-slot>

        @foreach ($orders->where('status', \App\Models\Order::STATUS_DELIVERY) as $order)
            <x-order-card class="bg-blue-200 border-blue-300" :order="$order">
                <x-slot name="actions">
                    <x-order-card-button wire:click="showCancelModal({{ $order->id }})"
                        class="bg-red-500 opacity-25 hover:opacity-100">
                        {{ __('Cancel') }}
                    </x-order-card-button>
                    <x-order-card-button wire:click="showConclusionModal({{ $order->id }})"
                        class="bg-green-500 hover:bg-green-600">
                        {{ __('Conclude') }}
                    </x-order-card-button>
                </x-slot>
            </x-order-card>
        @endforeach
    </x-order-column>

    <x-order-column>
        <x-slot name="title">
            {{ __('Concluded') }}
        </x-slot>

        @foreach ($orders->where('status', \App\Models\Order::STATUS_CONCLUDED) as $order)
            <x-order-card class="bg-green-300 border-green-400" :order="$order" />
        @endforeach
    </x-order-column>

    <button x-on:click="open = !open" class="fixed bottom-5 right-5 bg-purple-600 p-2 rounded shadow-lg text-white">
        <svg class="w-5 h-5 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
            <path
                d="M30 30h25.21V0H0v55.211h30zM0 91.357h30v55.211H0zM0 182.716h30v55.211H0zM365.432 0h55.21v30h-55.21zM274.074 0h55.21v30h-55.21zM182.716 0h55.21v30h-55.21zM91.358 0h55.21v30h-55.21zM456.79 0v30H482v25.211h30V0zM482 91.357h30v55.211h-30zM482 182.716h30v55.211h-30zM482 274.073h30v55.211h-30zM482 365.432h30v55.211h-30zM482 482h-25.21v30H512v-55.211h-30zM365.432 482h55.21v30h-55.21zM274.074 482h55.21v30h-55.21zM0 512h237.926V274.074H0zm30-207.926h177.926V482H30zM359.963 115.934h14.89l-80.528 80.528v-14.89h-30v66.103h66.103v-30h-14.89l80.528-80.529v14.891h30V85.934h-66.103z" />
        </svg>
    </button>

    <x-jet-confirmation-modal wire:model="confirmingPreparation">
        <x-slot name="title">
            {{ __('Please Confirm') }}
        </x-slot>

        <x-slot name="content">
            {{ __('Once changed it will no longer be reversible.') }}
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="closePreparationModal" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>

            <x-jet-button class="ml-2" wire:click="goToPreparation" wire:loading.attr="disabled">
                {{ __('Confirm') }}
            </x-jet-button>
        </x-slot>
    </x-jet-confirmation-modal>

    <x-jet-confirmation-modal wire:model="confirmingDelivery">
        <x-slot name="title">
            {{ __('Please Confirm') }}
        </x-slot>

        <x-slot name="content">
            {{ __('Once changed it will no longer be reversible.') }}
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="closeDeliveryModal" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>

            <x-jet-button class="ml-2" wire:click="goToDelivery" wire:loading.attr="disabled">
                {{ __('Confirm') }}
            </x-jet-button>
        </x-slot>
    </x-jet-confirmation-modal>

    <x-jet-confirmation-modal wire:model="confirmingConclusion">
        <x-slot name="title">
            {{ __('Please Confirm') }}
        </x-slot>

        <x-slot name="content">
            {{ __('Once changed it will no longer be reversible.') }}
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="closeConclusionModal" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>

            <x-jet-button class="ml-2" wire:click="conclude" wire:loading.attr="disabled">
                {{ __('Confirm') }}
            </x-jet-button>
        </x-slot>
    </x-jet-confirmation-modal>

    <x-jet-confirmation-modal wire:model="confirmingCancelation">
        <x-slot name="title">
            {{ __('Please Confirm') }}
        </x-slot>

        <x-slot name="content">
            {{ __('Once changed it will no longer be reversible.') }}
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="closeCancelModal" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>

            <x-jet-button class="ml-2" wire:click="cancel" wire:loading.attr="disabled">
                {{ __('Confirm') }}
            </x-jet-button>
        </x-slot>
    </x-jet-confirmation-modal>
</div>
