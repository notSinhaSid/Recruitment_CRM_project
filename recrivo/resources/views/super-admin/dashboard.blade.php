<x-super-admin-layout title="Dashboard — Super Admin">

    <h1 class="text-xl font-semibold text-white mb-1">Platform Overview</h1>
    <p class="text-sm text-white/40 mb-8">Recrivo-wide usage across all tenants.</p>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-10">
        <div class="rounded-xl border border-white/10 p-5" style="background:#1F2023;">
            <p class="text-xs text-white/40 mb-1">Tenants</p>
            <p class="text-3xl font-semibold text-white">{{ $stats['tenants'] }}</p>
        </div>
        <div class="rounded-xl border border-white/10 p-5" style="background:#1F2023;">
            <p class="text-xs text-white/40 mb-1">Users</p>
            <p class="text-3xl font-semibold text-white">{{ $stats['users'] }}</p>
        </div>
        <div class="rounded-xl border border-white/10 p-5" style="background:#1F2023;">
            <p class="text-xs text-white/40 mb-1">Candidates</p>
            <p class="text-3xl font-semibold text-white">{{ $stats['candidates'] }}</p>
        </div>
        <div class="rounded-xl border border-white/10 p-5" style="background:#1F2023;">
            <p class="text-xs text-white/40 mb-1">Applications</p>
            <p class="text-3xl font-semibold text-white">{{ $stats['applications'] }}</p>
        </div>
    </div>

    <a href="{{ route('super-admin.tenants') }}"
       class="inline-flex items-center gap-2 px-4 py-2.5 rounded-lg text-sm font-medium text-white transition"
       style="background: var(--color-coral);">
        View all tenants →
    </a>

</x-super-admin-layout>
