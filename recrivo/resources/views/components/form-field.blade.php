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
    @elseif ($type === 'richtext')
        <div x-data="{
                content: @js($slot->toHtml()),
                init() {
                    let editor = new Quill(this.$refs.editor, {
                        theme: 'snow',
                        placeholder: {{ Js::from($attributes->get('placeholder', '')) }},
                        modules: {
                            toolbar: [
                                ['bold', 'italic', 'underline'],
                                [{ list: 'ordered' }, { list: 'bullet' }],
                                ['link'],
                                ['clean']
                            ]
                        }
                    });
                    editor.root.innerHTML = this.content;
                    editor.on('text-change', () => {
                        this.$refs.hidden.value = editor.root.innerHTML;
                    });
                    this.$refs.hidden.value = this.content;
                }
             }">
            <div x-ref="editor"></div>
            <input type="hidden" id="{{ $name }}" name="{{ $name }}" x-ref="hidden">
        </div>
    @elseif ($type === 'file')
        <input type="file" id="{{ $name }}" name="{{ $name }}"
            {{ $attributes->merge(['class' => 'w-full text-sm text-[var(--color-text-secondary)] file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-[var(--color-bg)] file:text-[var(--color-text)] hover:file:bg-[var(--color-border)] file:cursor-pointer cursor-pointer border border-[var(--color-border)] rounded-lg']) }}>
    @elseif (in_array($type, ['email', 'password']))
        <div class="relative">
            <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-[var(--color-text-secondary)]">
                @if ($type === 'email')
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                    </svg>
                @else
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
                    </svg>
                @endif
            </span>
            <input type="{{ $type }}" id="{{ $name }}" name="{{ $name }}"
                {{ $attributes->merge(['class' => 'w-full rounded-lg border border-[var(--color-border)] bg-white pl-10 pr-3.5 py-2.5 text-sm text-[var(--color-text)] placeholder:text-[var(--color-text-secondary)] focus:outline-none focus:ring-2 focus:ring-[var(--color-primary)]/30 focus:border-[var(--color-primary)] transition']) }}>
        </div>
    @else
        <input type="{{ $type }}" id="{{ $name }}" name="{{ $name }}"
            {{ $attributes->merge(['class' => 'w-full rounded-lg border border-[var(--color-border)] bg-white px-3.5 py-2.5 text-sm text-[var(--color-text)] placeholder:text-[var(--color-text-secondary)] focus:outline-none focus:ring-2 focus:ring-[var(--color-primary)]/30 focus:border-[var(--color-primary)] transition']) }}>
    @endif

    @error($name)
        <p class="mt-1.5 text-sm text-[var(--color-coral)]">{{ $message }}</p>
    @enderror
</div>
