<x-app-layout header="Candidates">

    <div class="flex items-center justify-between mb-6">
        <p class="text-sm text-[var(--color-text-secondary)]">
            {{ $candidates->total() }} total candidate{{ $candidates->total() === 1 ? '' : 's' }}
        </p>
        <a href="{{ route('candidates.create') }}"
           class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-[var(--color-primary)] text-white text-sm font-medium hover:bg-[var(--color-primary-light)] transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 5v14M5 12h14" />
            </svg>
            New Candidate
        </a>
    </div>

    <div class="bg-[var(--color-card)] border border-[var(--color-border)] rounded-xl overflow-hidden">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-[var(--color-border)] bg-[var(--color-bg)]">
                    <th class="text-left font-medium text-[var(--color-text-secondary)] px-6 py-3">Name</th>
                    <th class="text-left font-medium text-[var(--color-text-secondary)] px-6 py-3">Email</th>
                    <th class="text-left font-medium text-[var(--color-text-secondary)] px-6 py-3">Phone</th>
                    <th class="text-left font-medium text-[var(--color-text-secondary)] px-6 py-3">Experience</th>
                    <th class="text-right font-medium text-[var(--color-text-secondary)] px-6 py-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($candidates as $candidate)
                    <tr class="border-b border-[var(--color-border)] last:border-0 hover:bg-[var(--color-bg)] transition">
                        <td class="px-6 py-4 font-medium text-[var(--color-text)]">
                            {{ $candidate->first_name }} {{ $candidate->last_name }}
                        </td>
                        <td class="px-6 py-4 text-[var(--color-text-secondary)]">{{ $candidate->email }}</td>
                        <td class="px-6 py-4 text-[var(--color-text-secondary)]">{{ $candidate->phone ?? '—' }}</td>
                        <td class="px-6 py-4 text-[var(--color-text-secondary)]">
                            {{ $candidate->years_of_experience !== null ? $candidate->years_of_experience . ' yrs' : '—' }}
                        </td>
                        <td class="px-6 py-4">
                            <x-row-actions
                                :show-route="route('candidates.show', $candidate)"
                                :edit-route="route('candidates.edit', $candidate)"
                                :destroy-route="route('candidates.destroy', $candidate)"
                                confirm-label="this candidate"
                            />
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-[var(--color-text-secondary)]">
                            No candidates yet.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $candidates->links() }}
    </div>

</x-app-layout>
