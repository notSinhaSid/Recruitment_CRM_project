@props(['status'])

@php
    $positive = ['offer', 'hired', 'open'];
    $urgent = ['rejected', 'overdue', 'closed'];

    $normalized = strtolower($status);

    $classes = match(true) {
        in_array($normalized, $positive) => 'bg-[#FFC078]/20 text-[#8a5a1f] border-[#FFC078]/40',
        in_array($normalized, $urgent) => 'bg-[#D4634A]/10 text-[#D4634A] border-[#D4634A]/30',
        default => 'bg-[var(--color-border)] text-[var(--color-text-secondary)] border-[var(--color-border)]',
    };
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border $classes"]) }}>
    {{ ucfirst(str_replace('_', ' ', $status)) }}
</span>
