<x-app-layout header="Job Postings">

    <div class="flex items-center justify-between mb-6">
        <p class="text-sm text-[var(--color-text-secondary)]">
            {{ $jobPostings->total() }} total job posting{{ $jobPostings->total() === 1 ? '' : 's' }}
        </p>
        <a href="{{ route('job-postings.create') }}"
           class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-[var(--color-primary)] text-white text-sm font-medium hover:bg-[var(--color-primary-light)] transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 5v14M5 12h14" />
            </svg>
            New Job Posting
        </a>
    </div>

    <div class="bg-[var(--color-card)] border border-[var(--color-border)] rounded-xl overflow-hidden">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-[var(--color-border)] bg-[var(--color-bg)]">
                    <th class="text-left font-medium text-[var(--color-text-secondary)] px-6 py-3">Title</th>
                    <th class="text-left font-medium text-[var(--color-text-secondary)] px-6 py-3">Company</th>
                    <th class="text-left font-medium text-[var(--color-text-secondary)] px-6 py-3">Status</th>
                    <th class="text-left font-medium text-[var(--color-text-secondary)] px-6 py-3">Open Spots</th>
                    <th class="text-right font-medium text-[var(--color-text-secondary)] px-6 py-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($jobPostings as $jobPosting)
                    <tr class="border-b border-[var(--color-border)] last:border-0 hover:bg-[var(--color-bg)] transition">
                        <td class="px-6 py-4 font-medium text-[var(--color-text)]">{{ $jobPosting->title }}</td>
                        <td class="px-6 py-4 text-[var(--color-text-secondary)]">{{ $jobPosting->company->name }}</td>
                        <td class="px-6 py-4"><x-badge :status="$jobPosting->status" /></td>
                        <td class="px-6 py-4 text-[var(--color-text-secondary)]">{{ $jobPosting->open_spots }}</td>
                        <td class="px-6 py-4">
                            <x-row-actions
                                :show-route="route('job-postings.show', $jobPosting)"
                                :edit-route="route('job-postings.edit', $jobPosting)"
                                :destroy-route="route('job-postings.destroy', $jobPosting)"
                                confirm-label="this job posting"
                            />
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-[var(--color-text-secondary)]">
                            No job postings yet.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $jobPostings->links() }}
    </div>

</x-app-layout>
