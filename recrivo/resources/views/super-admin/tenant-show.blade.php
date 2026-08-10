<x-super-admin-layout title="{{ $tenant->name }} — Super Admin">

    <a href="{{ route('super-admin.tenants') }}" class="text-sm text-white/40 hover:text-white/70 transition mb-6 inline-block">← All tenants</a>

    <div class="flex items-start justify-between mb-8">
        <div>
            <h1 class="text-xl font-semibold text-white mb-1">{{ $tenant->name }}</h1>
            <p class="text-sm text-white/40">Created {{ $tenant->created_at->format('M d, Y') }} · {{ $tenant->candidates_count }} candidates</p>
        </div>
        @if ($tenant->is_active)
            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium" style="background: rgba(255,192,120,0.15); color:#FFC078;">Active</span>
        @else
            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium" style="background: rgba(212,99,74,0.15); color:#D4634A;">Suspended</span>
        @endif
    </div>

    <h2 class="text-sm font-medium text-white/60 mb-3">Users ({{ $tenant->users->count() }})</h2>
    <div class="rounded-xl border border-white/10 overflow-hidden mb-8" style="background:#1F2023;">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-white/10 text-left text-white/40 text-xs uppercase tracking-wide">
                    <th class="px-5 py-3 font-medium">Name</th>
                    <th class="px-5 py-3 font-medium">Email</th>
                    <th class="px-5 py-3 font-medium">Role</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tenant->users as $user)
                    <tr class="border-b border-white/5 last:border-0">
                        <td class="px-5 py-3 text-white">{{ $user->first_name }} {{ $user->last_name }}</td>
                        <td class="px-5 py-3 text-white/60">{{ $user->email }}</td>
                        <td class="px-5 py-3 text-white/60">{{ $user->role->display_name ?? '—' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="flex items-center gap-3">
        <form method="POST" action="{{ route('super-admin.tenants.toggle', $tenant) }}">
            @csrf
            <button type="submit" class="text-sm px-4 py-2 rounded-lg border border-white/15 text-white/70 hover:text-white hover:border-white/30 transition">
                {{ $tenant->is_active ? 'Suspend Tenant' : 'Activate Tenant' }}
            </button>
        </form>
        <form method="POST" action="{{ route('super-admin.tenants.destroy', $tenant) }}"
              onsubmit="return confirm('Permanently delete {{ $tenant->name }}? This deletes all its users, candidates, and applications. This cannot be undone.');">
            @csrf
            @method('DELETE')
            <button type="submit" class="text-sm px-4 py-2 rounded-lg transition" style="background: rgba(212,99,74,0.15); color:#D4634A;">
                Delete Tenant Permanently
            </button>
        </form>
    </div>

</x-super-admin-layout>
