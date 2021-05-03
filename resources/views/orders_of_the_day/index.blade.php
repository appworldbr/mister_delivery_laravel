<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Orders Of The Day') }}
        </h2>
    </x-slot>

    <div class="bg-white">
        @livewire('orders-of-the-day')
    </div>
</x-app-layout>
