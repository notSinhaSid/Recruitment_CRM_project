<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\Application;
use App\Models\Candidate;
use App\Models\JobPosting;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $tenantId = auth()->user()->tenant_id;

        $counts = [
            'candidates' => Candidate::where('tenant_id', $tenantId)->count(),
            'job_postings' => JobPosting::where('tenant_id', $tenantId)->count(),
            'applications' => Application::where('tenant_id', $tenantId)->count(),
        ];

        $stageBreakdown = Application::where('tenant_id', $tenantId)
            ->selectRaw('stage, count(*) as total')
            ->groupBy('stage')
            ->pluck('total', 'stage');

        $recentActivity = AuditLog::where('tenant_id', $tenantId)
            ->with('user')
            ->latest()
            ->take(10)
            ->get();

        return view('dashboard.index', compact('counts', 'stageBreakdown', 'recentActivity'));
    }
}