<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use App\Models\User;
use App\Models\Candidate;
use App\Models\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SuperAdminController extends Controller
{
    public function dashboard(): View
    {
        $stats = [
            'tenants' => Tenant::count(),
            'users' => User::count(),
            'candidates' => Candidate::count(),
            'applications' => Application::count(),
            'suspended' => Tenant::where('is_active', false)->count(),
        ];

        $trends = [
            'tenants_this_week' => Tenant::where('created_at', '>=', now()->subWeek())->count(),
            'tenants_last_week' => Tenant::whereBetween('created_at', [now()->subWeeks(2), now()->subWeek()])->count(),
            'applications_this_week' => Application::where('created_at', '>=', now()->subWeek())->count(),
            'applications_last_week' => Application::whereBetween('created_at', [now()->subWeeks(2), now()->subWeek()])->count(),
        ];

        // Tenant growth over the last 8 weeks, for the chart
        $tenantGrowth = collect(range(7, 0))->map(function ($weeksAgo) {
            $start = now()->subWeeks($weeksAgo)->startOfWeek();
            $end = now()->subWeeks($weeksAgo)->endOfWeek();

            return [
                'label' => $start->format('M d'),
                'count' => Tenant::whereBetween('created_at', [$start, $end])->count(),
            ];
        });

        $recentTenants = Tenant::withCount('users')
            ->orderByDesc('created_at')
            ->take(5)
            ->get();

        return view('super-admin.dashboard', compact('stats', 'trends', 'tenantGrowth', 'recentTenants'));
    }

    public function tenants(): View
    {
        $tenants = Tenant::withCount(['users', 'candidates'])
            ->orderByDesc('created_at')
            ->get();

        return view('super-admin.tenants', compact('tenants'));
    }

    public function show(Tenant $tenant): View
    {
        $tenant->load(['users.role']);
        $tenant->loadCount('candidates');

        return view('super-admin.tenant-show', compact('tenant'));
    }

    public function toggleActive(Tenant $tenant): RedirectResponse
    {
        $tenant->update(['is_active' => ! $tenant->is_active]);

        return back()->with('success', $tenant->is_active
            ? "{$tenant->name} reactivated."
            : "{$tenant->name} suspended.");
    }

    public function destroy(Tenant $tenant): RedirectResponse
    {
        $tenant->delete(); // cascadeOnDelete on users FK handles cleanup

        return redirect()->route('super-admin.tenants')
            ->with('success', "{$tenant->name} permanently deleted.");
    }
}
