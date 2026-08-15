<x-super-admin-layout title="Tenants — Super Admin">

    <h1 class="text-xl font-semibold mb-1" style="color: var(--color-text);">Tenants</h1>
    <p class="text-sm mb-8" style="color: var(--color-text-secondary);">All organizations registered on Recrivo.</p>

    <div class="rounded-xl overflow-hidden" style="background: var(--color-card); border: 1px solid var(--color-border);">
        <table class="w-full text-sm">
            <thead>
                <tr class="text-left text-xs uppercase tracking-wide"
                    style="border-bottom: 1px solid var(--color-border); color: var(--color-text-secondary);">
                    <th class="px-5 py-3 font-medium">Name</th>
                    <th class="px-5 py-3 font-medium">Users</th>
                    <th class="px-5 py-3 font-medium">Candidates</th>
                    <th class="px-5 py-3 font-medium">Created</th>
                    <th class="px-5 py-3 font-medium">Status</th>
                    <th class="px-5 py-3 font-medium text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($tenants as $tenant)
                    <tr style="border-bottom: 1px solid var(--color-border);" class="last:border-0">
                        <td class="px-5 py-4">
                            <a href="{{ route('super-admin.tenants.show', $tenant) }}"
                               class="font-medium transition"
                               style="color: var(--color-text);"
                               onmouseover="this.style.color='var(--color-primary)'"
                               onmouseout="this.style.color='var(--color-text)'">
                                {{ $tenant->name }}
                            </a>
                        </td>
                        <td class="px-5 py-4" style="color: var(--color-text-secondary);">{{ $tenant->users_count }}</td>
                        <td class="px-5 py-4" style="color: var(--color-text-secondary);">{{ $tenant->candidates_count }}</td>
                        <td class="px-5 py-4" style="color: var(--color-text-secondary);">{{ $tenant->created_at->format('M d, Y') }}</td>
                        <td class="px-5 py-4">
                            @if ($tenant->is_active)
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium"
                                      style="background: rgba(76,154,106,0.1); color: var(--color-success);">
                                    Active
                                </span>
                            @else
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium"
                                      style="background: rgba(212,99,74,0.1); color: var(--color-coral);">
                                    Suspended
                                </span>
                            @endif
                        </td>
                        <td class="px-5 py-4">
                            <div class="flex items-center justify-end gap-2">
                                <form method="POST" action="{{ route('super-admin.tenants.toggle', $tenant) }}">
                                    @csrf
                                    <button type="submit"
                                            class="text-xs px-3 py-1.5 rounded-md transition"
                                            style="border: 1px solid var(--color-border); color: var(--color-text-secondary);"
                                            onmouseover="this.style.color='var(--color-text)'"
                                            onmouseout="this.style.color='var(--color-text-secondary)'">
                                        {{ $tenant->is_active ? 'Suspend' : 'Activate' }}
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('super-admin.tenants.destroy', $tenant) }}"
                                      onsubmit="return confirm('Permanently delete {{ $tenant->name }}? This deletes all its users, candidates, and applications. This cannot be undone.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-xs px-3 py-1.5 rounded-md transition" style="color: var(--color-coral);">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-5 py-8 text-center" style="color: var(--color-text-secondary);">No tenants yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</x-super-admin-layout>