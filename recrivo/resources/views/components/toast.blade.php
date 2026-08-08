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
                <div
                    class="w-2 h-2 rounded-full mt-1.5 shrink-0"
                    :class="{
                        'bg-[#3B4A5A]': toast.type === 'success' || toast.type === 'info',
                        'bg-[#D4634A]': toast.type === 'error',
                        'bg-[#FFC078]': toast.type === 'warning',
                    }"
                ></div>
                <p class="text-sm text-[#1F2937]" x-text="toast.message"></p>
            </div>
        </template>
    </div>
@endif