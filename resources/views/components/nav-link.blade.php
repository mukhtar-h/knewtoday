@props(['active'])

@php
    $classes = ($active ?? false)
        ? 'inline-flex items-center px-1 pt-1 border-b-2 border-kt-accent text-sm font-medium leading-5 text-kt-text focus:outline-none focus:border-kt-accent transition duration-150 ease-in-out'
        : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-kt-textMuted hover:text-kt-text hover:border-kt-border focus:outline-none focus:text-kt-text focus:border-kt-border transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>