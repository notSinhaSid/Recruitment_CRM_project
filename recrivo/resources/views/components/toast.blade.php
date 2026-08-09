@php
    $toasts = collect([
        'success' => session('success'),
        'error' => session('error'),
        'warning' => session('warning'),
        'info' => session('info'),
    ])->filter();
@endphp

@if ($toasts->isNotEmpty())
    <div
        x-data="{
            toasts: {{ $toasts->map(fn ($message, $type) => ['type' => $type, 'message' => $message])->values()->toJson() }}
        }"
        class="fixed top-6 right-6 z-50 flex flex-col gap-3 w-full max-w-sm"
    >
        <template x-for="(toast, index) in toasts" :key="index">
            <div
                x-show="true"
                x-init="setTimeout(() => toasts.splice(index, 1), 4000)"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-x-4"
                x-transition:enter-end="opacity-100 translate-x-0"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-x-0"
                x-transition:leave-end="opacity-0 translate-x-4"
                class="rounded-xl border bg-white shadow-md px-4 py-3 flex items-start gap-3"
                :class="{
                    'border-[#E4E8EB]': toast.type === 'success' || toast.type === 'info',
                    'border-[#D4634A]/30': toast.type === 'error',
                    'border-[#FFC078]/50': toast.type === 'warning',
                }"
            >
                <svg x-show="toast.type === 'success'" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 shrink-0 text-[#3B4A5A]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
                <svg x-show="toast.type === 'error'" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 shrink-0 text-[#D4634A]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
                    <path d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
                <svg x-show="toast.type === 'warning'" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 shrink-0 text-[#FFC078]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 9v3.75m0 3.75h.008v.008H12v-.008ZM10.29 3.86 1.82 18a1.5 1.5 0 0 0 1.28 2.25h17.8a1.5 1.5 0 0 0 1.28-2.25L13.71 3.86a1.5 1.5 0 0 0-2.42 0Z" />
                </svg>
                <svg x-show="toast.type === 'info'" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 shrink-0 text-[#3B4A5A]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
                    <path d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
                </svg>
                <p class="text-sm text-[#1F2937]" x-text="toast.message"></p>
            </div>
        </template>
    </div>
@endif