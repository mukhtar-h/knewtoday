@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-medium text-sm text-kt-text']) }}>
    {{ $value ?? $slot }}
</label>