<button {{ $attributes->merge(['type' => 'button', 'class' => 'kt-btn-outline']) }}>
    {{ $slot }}
</button>