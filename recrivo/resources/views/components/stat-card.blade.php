@props(['label', 'value', 'delta' => null])

<div class="rounded-xl p-5" style="background: var(--color-card); border: 1px solid var(--color-border);">
    <p class="text-xs mb-1" style="color: var(--color-text-secondary);">{{ $label }}</p>
    <p class="text-2xl font-semibold" style="color: var(--color-text);">{{ number_format($value) }}</p>

    @if (! is_null($delta))
        <p class="text-xs mt-2 flex items-center gap-1"
           style="color: {{ $delta >= 0 ? 'var(--color-primary)' : 'var(--color-coral)' }};">
            {{ $delta >= 0 ? '↑' : '↓' }} {{ abs($delta) }} this week
        </p>
    @endif
</div>
