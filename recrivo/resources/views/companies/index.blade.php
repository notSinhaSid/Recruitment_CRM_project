<x-app-layout header="Companies">

    <div class="flex items-center justify-between mb-6">
        <p class="text-sm text-[var(--color-text-secondary)]">
            {{ $companies->total() }} total compan{{ $companies->total() === 1 ? 'y' : 'ies' }}
        </p>
        <a href="{{ route('companies.create') }}"
           class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-[var(--color-primary)] text-white text-sm font-medium hover:bg-[var(--color-primary-light)] transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 5v14M5 12h14" />
            </svg>
            New Company
        </a>
    </div>

    <div class="bg-[var(--color-card)] border border-[var(--color-border)] rounded-xl overflow-hidden">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-[var(--color-border)] bg-[var(--color-bg)]">
                    <th class="text-left font-medium text-[var(--color-text-secondary)] px-6 py-3">Name</th>
                    <th class="text-left font-medium text-[var(--color-text-secondary)] px-6 py-3">Industry</th>
                    <th class="text-left font-medium text-[var(--color-text-secondary)] px-6 py-3">Location</th>
                    <th class="text-right font-medium text-[var(--color-text-secondary)] px-6 py-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($companies as $company)
                    <tr class="border-b border-[var(--color-border)] last:border-0 hover:bg-[var(--color-bg)] transition">
                        <td class="px-6 py-4 font-medium text-[var(--color-text)]">{{ $company->name }}</td>
                        <td class="px-6 py-4 text-[var(--color-text-secondary)]">{{ $company->industry ?? '—' }}</td>
                        <td class="px-6 py-4 text-[var(--color-text-secondary)]">{{ $company->location ?? '—' }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-end gap-3 text-[var(--color-text-secondary)]">
                                <a href="{{ route('companies.show', $company) }}" class="hover:text-[var(--color-primary)] transition">View</a>
                                <a href="{{ route('companies.edit', $company) }}" class="hover:text-[var(--color-primary)] transition">Edit</a>
                                <form method="POST" action="{{ route('companies.destroy', $company) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Delete this company?')"
                                        class="hover:text-[var(--color-coral)] transition">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center text-[var(--color-text-secondary)]">
                            No companies yet.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $companies->links() }}
    </div>

</x-app-layout>
