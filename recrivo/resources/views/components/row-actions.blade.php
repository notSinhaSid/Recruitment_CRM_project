@props(['showRoute', 'editRoute', 'destroyRoute', 'confirmLabel' => 'this item'])

<div class="flex items-center justify-end gap-1.5">
    <a href="{{ $showRoute }}"
       class="flex items-center gap-1 px-2.5 py-1.5 rounded-md text-xs font-medium border
              border-[var(--color-primary)]/25 text-[var(--color-primary)] bg-[var(--color-primary)]/5
              hover:border-[var(--color-primary)] hover:bg-[var(--color-primary)]/10 transition">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
            <path d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
            <path d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
        </svg>
        View
    </a>

    <a href="{{ $editRoute }}"
       class="flex items-center gap-1 px-2.5 py-1.5 rounded-md text-xs font-medium border
              border-[#8a5a1f]/25 text-[#8a5a1f] bg-[var(--color-amber)]/15
              hover:border-[#8a5a1f]/50 hover:bg-[var(--color-amber)]/25 transition">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
            <path d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Z" />
            <path d="M19.5 13.5V19.5a2.25 2.25 0 0 1-2.25 2.25H4.5A2.25 2.25 0 0 1 2.25 19.5V6.75a2.25 2.25 0 0 1 2.25-2.25h6" />
        </svg>
        Edit
    </a>

    <form method="POST" action="{{ $destroyRoute }}">
        @csrf
        @method('DELETE')
        <button type="submit" onclick="return confirm('Delete {{ $confirmLabel }}?')"
            class="flex items-center gap-1 px-2.5 py-1.5 rounded-md text-xs font-medium border
                   border-[var(--color-coral)]/30 text-[var(--color-coral)] bg-[var(--color-coral)]/8
                   hover:border-[var(--color-coral)] hover:bg-[var(--color-coral)]/15 transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
                <path d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
            </svg>
            Delete
        </button>
    </form>
</div>