<button {{ $attributes->merge(['type' => 'submit', 'class' => 'kt-btn-primary']) }}>
    {{ $slot }}
</button>