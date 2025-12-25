@php
$message = session('success') ?? session('status') ?? session('error') ?? null;
$type = session('error') ? 'error' : (session('success') ? 'success' : 'status');

$styles = match ($type) {
'success' => 'border-emerald-500/60 bg-emerald-500/10 text-emerald-100',
'error' => 'border-red-500/60 bg-red-500/10 text-red-100',
default => 'border-kt-border bg-kt-card text-kt-text',
};

$label = match ($type) {
'success' => 'Success',
'error' => 'Error',
default => 'Notice',
};
@endphp

@if($message)
<div
    data-toast
    class="fixed bottom-4 right-4 z-50 max-w-sm transform transition-all duration-300 ease-out opacity-100 translate-y-0">

    <div class="px-4 py-3 rounded-xl border text-xs shadow-lg {{ $styles }}">
        <div class="flex items-start gap-3">
            <div class="mt-0.5">
                @if($type === 'success')
                <span class="inline-flex items-center justify-center w-5 h-5 rounded-full border border-emerald-400/60 text-[10px]">
                    ✓
                </span>
                @elseif($type === 'error')
                <span class="inline-flex items-center justify-center w-5 h-5 rounded-full border border-red-400/60 text-[10px]">
                    !
                </span>
                @else
                <span class="inline-flex items-center justify-center w-5 h-5 rounded-full border border-kt-border/70 text-[10px]">
                    i
                </span>
                @endif
            </div>

            <div class="flex-1">
                <p class="font-semibold text-[11px] uppercase tracking-[0.18em] mb-0.5">
                    {{ $label }}
                </p>
                <p class="text-[11px] leading-relaxed">
                    {{ $message }}
                </p>
            </div>

            <button type="button"
                data-toast-close
                class="ml-2 text-[11px] text-kt-muted hover:text-kt-text">
                ✕
            </button>
        </div>
    </div>
</div>

@once
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const toast = document.querySelector('[data-toast]');
        if (!toast) return;

        const closeBtn = toast.querySelector('[data-toast-close]');
        const hide = () => {
            toast.classList.add('opacity-0', 'translate-y-2');
            setTimeout(() => toast.remove(), 250);
        };

        // Auto-hide after 4.5s
        setTimeout(hide, 4500);

        // Manual close
        if (closeBtn) {
            closeBtn.addEventListener('click', hide);
        }
    });
</script>
@endpush
@endonce
@endif