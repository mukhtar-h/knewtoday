@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'bg-kt-bg border-kt-border text-kt-text focus:border-kt-accent focus:ring-kt-accent rounded-md shadow-sm']) }}>