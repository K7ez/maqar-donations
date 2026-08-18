@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-hairline focus:border-primary focus:ring-primary rounded-lg text-sm']) }}>
