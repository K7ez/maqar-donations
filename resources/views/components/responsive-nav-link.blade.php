@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full ps-3 pe-4 py-2 border-s-4 border-primary text-start text-base font-medium text-primary bg-primarylight focus:outline-none focus:text-primarydark focus:bg-primarylight focus:border-primary transition duration-150 ease-in-out'
            : 'block w-full ps-3 pe-4 py-2 border-s-4 border-transparent text-start text-base font-medium text-inkmuted hover:text-primary hover:bg-primarylight hover:border-hairline focus:outline-none focus:text-primary focus:bg-primarylight focus:border-hairline transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
