<x-app-layout header="Candidate Details">

    <div class="max-w-3xl mx-auto">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-2xl font-semibold text-[var(--color-text)]">{{ $candidate->first_name }} {{ $candidate->last_name }}</h2>
                <p class="text-sm text-[var(--color-text-secondary)] mt-1">{{ $candidate->email }}</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('candidates.edit', $candidate) }}"
                    class="px-4 py-2 rounded-lg border border-[var(--color-border)] text-sm font-medium text-[var(--color-text)] hover:bg-[var(--color-bg)] transition">
                    Edit
                </a>
                <a href="{{ route('candidates.index') }}"
                    class="px-4 py-2 rounded-lg text-sm font-medium text-[var(--color-text-secondary)] hover:text-[var(--color-text)] transition">
                    Back to list
                </a>
            </div>
        </div>

        <div class="bg-[var(--color-card)] border border-[var(--color-border)] rounded-xl p-8">
            <dl class="grid grid-cols-2 gap-x-8 gap-y-6">
                <div>
                    <dt class="text-xs font-medium uppercase tracking-wide text-[var(--color-text-secondary)]">Phone</dt>
                    <dd class="mt-1 text-sm text-[var(--color-text)]">{{ $candidate->phone ?? '—' }}</dd>
                </div>

                <div>
                    <dt class="text-xs font-medium uppercase tracking-wide text-[var(--color-text-secondary)]">LinkedIn</dt>
                    <dd class="mt-1 text-sm">
                        @if ($candidate->linkedin_url)
                            <a href="{{ $candidate->linkedin_url }}" target="_blank" class="text-[var(--color-primary)] hover:underline">{{ $candidate->linkedin_url }}</a>
                        @else
                            <span class="text-[var(--color-text)]">—</span>
                        @endif
                    </dd>
                </div>

                <div>
                    <dt class="text-xs font-medium uppercase tracking-wide text-[var(--color-text-secondary)]">Years of Experience</dt>
                    <dd class="mt-1 text-sm text-[var(--color-text)]">{{ $candidate->years_of_experience ?? '—' }}</dd>
                </div>

                <div>
                    <dt class="text-xs font-medium uppercase tracking-wide text-[var(--color-text-secondary)]">Source</dt>
                    <dd class="mt-1 text-sm text-[var(--color-text)]">{{ $candidate->source ?? '—' }}</dd>
                </div>

                <div>
                    <dt class="text-xs font-medium uppercase tracking-wide text-[var(--color-text-secondary)]">Resume</dt>
                    <dd class="mt-1 text-sm">
                        @if ($candidate->resume_path)
                            <a href="{{ Storage::url($candidate->resume_path) }}" target="_blank" class="text-[var(--color-primary)] hover:underline">View resume</a>
                        @else
                            <span class="text-[var(--color-text)]">Not uploaded</span>
                        @endif
                    </dd>
                </div>
            </dl>

            <div class="mt-6 pt-6 border-t border-[var(--color-border)]">
                <dt class="text-xs font-medium uppercase tracking-wide text-[var(--color-text-secondary)] mb-2">Notes</dt>
                <dd class="text-sm text-[var(--color-text)] leading-relaxed [&_p]:mb-2 [&_ul]:list-disc [&_ul]:pl-5 [&_ol]:list-decimal [&_ol]:pl-5 [&_a]:text-[var(--color-primary)] [&_a]:underline">
                    @if ($candidate->notes)
                        {!! $candidate->notes !!}
                    @else
                        —
                    @endif
                </dd>
            </div>
        </div>
    </div>

</x-app-layout>
