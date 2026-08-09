<x-app-layout header="Company Details">

    <div class="max-w-3xl mx-auto">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-2xl font-semibold text-[var(--color-text)]">{{ $company->name }}</h2>
                <p class="text-sm text-[var(--color-text-secondary)] mt-1">{{ $company->industry ?? '—' }}</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('companies.edit', $company) }}"
                    class="px-4 py-2 rounded-lg border border-[var(--color-border)] text-sm font-medium text-[var(--color-text)] hover:bg-[var(--color-bg)] transition">
                    Edit
                </a>
                <a href="{{ route('companies.index') }}"
                    class="px-4 py-2 rounded-lg text-sm font-medium text-[var(--color-text-secondary)] hover:text-[var(--color-text)] transition">
                    Back to list
                </a>
            </div>
        </div>

        <div class="bg-[var(--color-card)] border border-[var(--color-border)] rounded-xl p-8">
            <dl class="grid grid-cols-2 gap-x-8 gap-y-6">
                <div>
                    <dt class="text-xs font-medium uppercase tracking-wide text-[var(--color-text-secondary)]">Website</dt>
                    <dd class="mt-1 text-sm">
                        @if ($company->website)
                            <a href="{{ $company->website }}" target="_blank" class="text-[var(--color-primary)] hover:underline">{{ $company->website }}</a>
                        @else
                            <span class="text-[var(--color-text)]">—</span>
                        @endif
                    </dd>
                </div>

                <div>
                    <dt class="text-xs font-medium uppercase tracking-wide text-[var(--color-text-secondary)]">Contact Number</dt>
                    <dd class="mt-1 text-sm text-[var(--color-text)]">{{ $company->contact_number ?? '—' }}</dd>
                </div>

                <div>
                    <dt class="text-xs font-medium uppercase tracking-wide text-[var(--color-text-secondary)]">Location</dt>
                    <dd class="mt-1 text-sm text-[var(--color-text)]">{{ $company->location ?? '—' }}</dd>
                </div>
            </dl>

            <div class="mt-6 pt-6 border-t border-[var(--color-border)]">
                <dt class="text-xs font-medium uppercase tracking-wide text-[var(--color-text-secondary)] mb-2">Notes</dt>
                <dd class="text-sm text-[var(--color-text)] leading-relaxed">{{ $company->notes ?? '—' }}</dd>
            </div>
        </div>
    </div>

</x-app-layout>
