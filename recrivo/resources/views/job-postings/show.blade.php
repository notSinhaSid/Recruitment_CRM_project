<x-app-layout header="Job Posting Details">

    <div class="max-w-3xl">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-2xl font-semibold text-[var(--color-text)]">{{ $jobPosting->title }}</h2>
                <p class="text-sm text-[var(--color-text-secondary)] mt-1">{{ $jobPosting->company->name }}</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('job-postings.edit', $jobPosting) }}"
                    class="px-4 py-2 rounded-lg border border-[var(--color-border)] text-sm font-medium text-[var(--color-text)] hover:bg-[var(--color-bg)] transition">
                    Edit
                </a>
                <a href="{{ route('job-postings.index') }}"
                    class="px-4 py-2 rounded-lg text-sm font-medium text-[var(--color-text-secondary)] hover:text-[var(--color-text)] transition">
                    Back to list
                </a>
            </div>
        </div>

        <div class="bg-[var(--color-card)] border border-[var(--color-border)] rounded-xl p-8">
            <dl class="grid grid-cols-2 gap-x-8 gap-y-6">
                <div>
                    <dt class="text-xs font-medium uppercase tracking-wide text-[var(--color-text-secondary)]">Status</dt>
                    <dd class="mt-1"><x-badge :status="$jobPosting->status" /></dd>
                </div>

                <div>
                    <dt class="text-xs font-medium uppercase tracking-wide text-[var(--color-text-secondary)]">Open Spots</dt>
                    <dd class="mt-1 text-sm text-[var(--color-text)]">{{ $jobPosting->open_spots }}</dd>
                </div>

                <div>
                    <dt class="text-xs font-medium uppercase tracking-wide text-[var(--color-text-secondary)]">Location</dt>
                    <dd class="mt-1 text-sm text-[var(--color-text)]">{{ $jobPosting->location ?? '—' }}</dd>
                </div>

                <div>
                    <dt class="text-xs font-medium uppercase tracking-wide text-[var(--color-text-secondary)]">Employment Type</dt>
                    <dd class="mt-1 text-sm text-[var(--color-text)]">{{ $jobPosting->employment_type ?? '—' }}</dd>
                </div>
            </dl>

            <div class="mt-6 pt-6 border-t border-[var(--color-border)]">
                <dt class="text-xs font-medium uppercase tracking-wide text-[var(--color-text-secondary)] mb-2">Description</dt>
                <dd class="text-sm text-[var(--color-text)] leading-relaxed">{{ $jobPosting->description ?? '—' }}</dd>
            </div>
        </div>
    </div>

</x-app-layout>
