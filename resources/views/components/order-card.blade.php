<div x-data="{ open: false }" x-on:click="open = !open" :class="{'{{ $borderOpenColor }}': open}"
    {{ $attributes->merge(['class' => 'rounded-lg border-2 my-2']) }}>
    <div class="flex justify-between items-center p-3 pb-3">
        <h3 class="font-bold">
            #{{ $order->id }} {{ $order->name }}
        </h3>
        <svg :class="{'transform rotate-180': open}" class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd"
                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                clip-rule="evenodd" />
        </svg>
    </div>
    <div :class="{'block': open, 'hidden': ! open}" class="hidden bg-white p-3">
        @php
            $telephone = $order->user
                ->telephones()
                ->where('is_default', true)
                ->first();
        @endphp
        @if ($telephone)
            <div class="flex items-center justify-between">
                <div class="mb-2">
                    <h4 class="font-bold">{{ __('Telephone') }}:</h4>
                    <p class="leading-none">{{ $telephone->telephone }}</p>
                </div>
                <a href="{{ route('user.form.update', ['user' => $order->user]) }}"
                    class="block border rounded-full p-2 transition hover:shadow {{ $userButtonColor }}"
                    target="_blank" x-on:click.stop>
                    <svg class="h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                        <path
                            d="M256 0c-74.439 0-135 60.561-135 135s60.561 135 135 135 135-60.561 135-135S330.439 0 256 0zM423.966 358.195C387.006 320.667 338.009 300 286 300h-60c-52.008 0-101.006 20.667-137.966 58.195C51.255 395.539 31 444.833 31 497c0 8.284 6.716 15 15 15h420c8.284 0 15-6.716 15-15 0-52.167-20.255-101.461-57.034-138.805z" />
                    </svg>
                </a>
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
                            {{ __('Unit.') }} R$ {{ number_format($food->price, 2, ',', '.') }}
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
                                                    {{ __('Unit.') }} R$
                                                    {{ number_format(round($extra->price, 2), 2, ',', '.') }}
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
    <div class="flex justify-between items-end p-3">
        <p class="font-bold text-lg">
            R$ {{ number_format($order->getTotal($order->food), 2, ',', '.') }}
        </p>

        @if (isset($actions))
            <div x-on:click.stop>
                {{ $actions }}
            </div>
        @endif
    </div>
</div>
