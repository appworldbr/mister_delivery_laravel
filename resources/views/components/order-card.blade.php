<div x-data="{ open: false }" x-on:click="open = !open"
    {{ $attributes->merge(['class' => 'rounded-lg border my-2']) }}>
    <div class="flex justify-between items-center p-3 pb-3">
        <h3>
            #{{ $order->id }} {{ $order->name }}
        </h3>
        <svg :class="{'transform rotate-180': open}" class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd"
                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                clip-rule="evenodd" />
        </svg>
    </div>
    <div :class="{'block': open, 'hidden': ! open}" class="hidden bg-white px-3">
        <div class="mb-2">
            <h4 class="font-bold">{{ __('E-mail') }}:</h4>
            <p class="leading-none">{{ $order->email }}</p>
        </div>

        <div class="mb-2">
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
            <p class="leading-none">
                {{ $order->zip }}
            </p>
        </div>


        <h4 class="font-bold">
            {{ __('Order') }}
        </h4>
        <ul class="ml-5 list-disc">
            @foreach ($order->food as $food)
                <li class="border-b pb-2 mb-2">
                    <div class="flex font-bold justify-between">
                        <div class="flex-shrink-0">
                            {{ $food->quantity }}x {{ $food->name }}
                        </div>
                        <div class="w-full overflow-hidden mx-2">
                            {{ str_repeat('.', 200) }}
                        </div>
                        <div class="flex-shrink-0">
                            R$ {{ number_format($food->getTotal($food->extras), 2, ',', '.') }}
                        </div>
                    </div>
                    <div>
                        <div class="my-3">
                            <h4 class="font-bold text-gray-700">
                                {{ __('Observation') }}:
                            </h4>
                            <p>
                                {{ $food->observation }}
                            </p>
                        </div>
                        <div class="my-3">
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
                                                {{ str_repeat('.', 200) }}
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
