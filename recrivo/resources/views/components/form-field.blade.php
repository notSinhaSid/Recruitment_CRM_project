@props(['name', 'label', 'type' => 'text'])

<div>
    <label for="{{ $name }}" class="block text-sm font-medium text-[var(--color-text)] mb-1.5">
        {{ $label }}
    </label>

    @if ($type === 'select')
        <select id="{{ $name }}" name="{{ $name }}"
            {{ $attributes->merge(['class' => 'w-full rounded-lg border border-[var(--color-border)] bg-white px-3.5 py-2.5 text-sm text-[var(--color-text)] focus:outline-none focus:ring-2 focus:ring-[var(--color-primary)]/30 focus:border-[var(--color-primary)] transition']) }}>
            {{ $slot }}
        </select>
    @elseif ($type === 'textarea')
        <textarea id="{{ $name }}" name="{{ $name }}" rows="4"
            {{ $attributes->merge(['class' => 'w-full rounded-lg border border-[var(--color-border)] bg-white px-3.5 py-2.5 text-sm text-[var(--color-text)] placeholder:text-[var(--color-text-secondary)] focus:outline-none focus:ring-2 focus:ring-[var(--color-primary)]/30 focus:border-[var(--color-primary)] transition']) }}>{{ $slot }}</textarea>
    @elseif ($type === 'file')
        <input type="file" id="{{ $name }}" name="{{ $name }}"
            {{ $attributes->merge(['class' => 'w-full text-sm text-[var(--color-text-secondary)] file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-[var(--color-bg)] file:text-[var(--color-text)] hover:file:bg-[var(--color-border)] file:cursor-pointer cursor-pointer border border-[var(--color-border)] rounded-lg']) }}>
    @else
        <input type="{{ $type }}" id="{{ $name }}" name="{{ $name }}"
            {{ $attributes->merge(['class' => 'w-full rounded-lg border border-[var(--color-border)] bg-white px-3.5 py-2.5 text-sm text-[var(--color-text)] placeholder:text-[var(--color-text-secondary)] focus:outline-none focus:ring-2 focus:ring-[var(--color-primary)]/30 focus:border-[var(--color-primary)] transition']) }}>
    @endif

    @error($name)
        <p class="mt-1.5 text-sm text-[var(--color-coral)]">{{ $message }}</p>
    @enderror
</div>
