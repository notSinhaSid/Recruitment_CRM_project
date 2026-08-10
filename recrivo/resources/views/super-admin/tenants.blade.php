<x-super-admin-layout title="Tenants — Super Admin">

    <h1 class="text-xl font-semibold text-white mb-1">Tenants</h1>
    <p class="text-sm text-white/40 mb-8">All organizations registered on Recrivo.</p>

    <div class="rounded-xl border border-white/10 overflow-hidden" style="background:#1F2023;">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-white/10 text-left text-white/40 text-xs uppercase tracking-wide">
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
                    <tr class="border-b border-white/5 last:border-0">
                        <td class="px-5 py-4">
                            <a href="{{ route('super-admin.tenants.show', $tenant) }}" class="text-white font-medium hover:text-[var(--color-coral)] transition">
                                {{ $tenant->name }}
                            </a>
                        </td>
                        <td class="px-5 py-4 text-white/60">{{ $tenant->users_count }}</td>
                        <td class="px-5 py-4 text-white/60">{{ $tenant->candidates_count }}</td>
                        <td class="px-5 py-4 text-white/60">{{ $tenant->created_at->format('M d, Y') }}</td>
                        <td class="px-5 py-4">
                            @if ($tenant->is_active)
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium" style="background: rgba(255,192,120,0.15); color:#FFC078;">
                                    Active
                                </span>
                            @else
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium" style="background: rgba(212,99,74,0.15); color:#D4634A;">
                                    Suspended
                                </span>
                            @endif
                        </td>
                        <td class="px-5 py-4">
                            <div class="flex items-center justify-end gap-2">
                                <form method="POST" action="{{ route('super-admin.tenants.toggle', $tenant) }}">
                                    @csrf
                                    <button type="submit" class="text-xs px-3 py-1.5 rounded-md border border-white/15 text-white/70 hover:text-white hover:border-white/30 transition">
                                        {{ $tenant->is_active ? 'Suspend' : 'Activate' }}
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('super-admin.tenants.destroy', $tenant) }}"
                                      onsubmit="return confirm('Permanently delete {{ $tenant->name }}? This deletes all its users, candidates, and applications. This cannot be undone.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-xs px-3 py-1.5 rounded-md transition" style="color:#D4634A;">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-5 py-8 text-center text-white/40">No tenants yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</x-super-admin-layout>
