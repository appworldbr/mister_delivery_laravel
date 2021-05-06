<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-wrap -m-2">
                <x-dashboard-card class="bg-green-500" href="{{ route('order.index') }}">
                    <x-slot name="quantity">
                        R$ {{ number_format($priceTotal, 2, ',', '.') }}
                    </x-slot>
                    <x-slot name="description">
                        {{ __('Total Earnings This Month') }}
                    </x-slot>
                </x-dashboard-card>
                <x-dashboard-card class="bg-blue-500" href="{{ route('order.index') }}">
                    <x-slot name="quantity">
                        {{ $quantityCount }}
                    </x-slot>
                    <x-slot name="description">
                        {{ __('Total Orders This Month') }}
                    </x-slot>
                </x-dashboard-card>
                <x-dashboard-card class="bg-yellow-500" href="{{ route('user.index') }}">
                    <x-slot name="quantity">
                        {{ $clientCount }}
                    </x-slot>
                    <x-slot name="description">
                        {{ __('Total News Users This Month') }}
                    </x-slot>
                </x-dashboard-card>
            </div>
        </div>
    </div>
</x-app-layout>
