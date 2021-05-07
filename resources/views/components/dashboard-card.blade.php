<a href="{{ $href }}"
    {{ $attributes->merge(['class' => 'w-1/4 text-white overflow-hidden shadow rounded-lg m-2 group hover:shadow-xl']) }}>
    <div class="p-3">
        <h3 class="font-bold text-3xl mb-3">
            {{ $quantity }}
        </h3>
        <p>
            {{ $description }}
        </p>
    </div>
    <div class="block w-full p-2 text-center bg-black bg-opacity-30 transition group-hover:bg-opacity-50">
        {{ __('More Info') }}
    </div>
</a>
