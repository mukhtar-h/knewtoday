    {{-- Global Loading Overlay --}}
    <div id="kt-loader"
        class="fixed inset-0 z-[9999] hidden items-center justify-center bg-black/70 backdrop-blur-sm">
        <div class="flex flex-col items-center gap-4 px-6">
            <div class="relative select-none">
                {{-- Animated “fill” layer (behind) --}}
                <div class="kt-loader-fill" aria-hidden="true">KNEWTODAY</div>

                {{-- Outline “hollow” layer (front) --}}
                <div class="kt-loader-outline" aria-hidden="true">KNEWTODAY</div>
            </div>

            <div class="flex items-center gap-2 text-[11px] text-slate-300">
                <span class="kt-dots">Loading</span>
            </div>
        </div>
    </div>