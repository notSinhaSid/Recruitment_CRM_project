<x-super-admin-layout title="Dashboard — Super Admin">

    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-xl font-semibold" style="color: var(--color-text);">Platform Overview</h1>
            <p class="text-sm mt-1" style="color: var(--color-text-secondary);">Recrivo-wide usage across all tenants.</p>
        </div>
        @if ($stats['suspended'] > 0)
            <div class="flex items-center gap-2 px-3 py-1.5 rounded-lg text-xs font-medium"
                 style="background: rgba(212,99,74,0.1); color: var(--color-coral); border: 1px solid rgba(212,99,74,0.25);">
                <span class="w-1.5 h-1.5 rounded-full" style="background: var(--color-coral);"></span>
                {{ $stats['suspended'] }} suspended {{ Str::plural('tenant', $stats['suspended']) }}
            </div>
        @endif
    </div>

    {{-- Stat cards with trend deltas --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <x-stat-card
            label="Tenants"
            :value="$stats['tenants']"
            :delta="$trends['tenants_this_week'] - $trends['tenants_last_week']"
        />
        <x-stat-card
            label="Users"
            :value="$stats['users']"
        />
        <x-stat-card
            label="Candidates"
            :value="$stats['candidates']"
        />
        <x-stat-card
            label="Applications"
            :value="$stats['applications']"
            :delta="$trends['applications_this_week'] - $trends['applications_last_week']"
        />
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Main chart --}}
        <div class="lg:col-span-2 rounded-xl p-6" style="background: var(--color-card); border: 1px solid var(--color-border);">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-sm font-semibold" style="color: var(--color-text);">Tenant Growth</p>
                    <p class="text-xs" style="color: var(--color-text-secondary);">Last 8 weeks</p>
                </div>
            </div>
            <div id="tenantGrowthChart"></div>
        </div>

        {{-- Recent tenants --}}
        <div class="rounded-xl p-6" style="background: var(--color-card); border: 1px solid var(--color-border);">
            <p class="text-sm font-semibold mb-4" style="color: var(--color-text);">Recent Tenants</p>
            <div class="space-y-4">
                @forelse ($recentTenants as $tenant)
                    <div class="flex items-center justify-between">
                        <div class="min-w-0">
                            <p class="text-sm font-medium truncate" style="color: var(--color-text);">{{ $tenant->name }}</p>
                            <p class="text-xs" style="color: var(--color-text-secondary);">{{ $tenant->users_count }} {{ Str::plural('user', $tenant->users_count) }}</p>
                        </div>
                        <span class="text-xs px-2 py-0.5 rounded-full shrink-0"
                              style="{{ $tenant->is_active
                                    ? 'background: rgba(76,154,106,0.1); color: var(--color-success);'
                                    : 'background: rgba(212,99,74,0.1); color: var(--color-coral);' }}">
                            {{ $tenant->is_active ? 'Active' : 'Suspended' }}
                        </span>
                    </div>
                @empty
                    <p class="text-sm" style="color: var(--color-text-secondary);">No tenants yet.</p>
                @endforelse
            </div>
            <a href="{{ route('super-admin.tenants') }}"
               class="inline-flex items-center gap-1 mt-6 text-sm font-medium"
               style="color: var(--color-primary);">
                View all tenants →
            </a>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const growth = @json($tenantGrowth->values());

            new ApexCharts(document.querySelector('#tenantGrowthChart'), {
                chart: {
                    type: 'area',
                    height: 280,
                    toolbar: { show: false },
                    fontFamily: 'Inter, sans-serif',
                },
                series: [{
                    name: 'New Tenants',
                    data: growth.map(w => w.count),
                }],
                xaxis: {
                    categories: growth.map(w => w.label),
                    labels: { style: { colors: '#6B7684', fontSize: '11px' } },
                    axisBorder: { show: false },
                    axisTicks: { show: false },
                },
                yaxis: {
                    labels: { style: { colors: '#6B7684', fontSize: '11px' } },
                },
                colors: ['#3B4A5A'],
                fill: {
                    type: 'gradient',
                    gradient: { shadeIntensity: 1, opacityFrom: 0.35, opacityTo: 0.05 },
                },
                stroke: { curve: 'smooth', width: 2 },
                dataLabels: { enabled: false },
                grid: { borderColor: '#E4E8EB', strokeDashArray: 4 },
                tooltip: { theme: 'light' },
            }).render();
        });
    </script>
    @endpush

</x-super-admin-layout>