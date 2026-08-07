<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Candidate;
use App\Models\JobPosting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ApplicationController extends Controller
{
    public function index(): View
    {
        $applications = Application::where('tenant_id', auth()->user()->tenant_id)
            ->with(['candidate', 'jobPosting'])
            ->latest()
            ->paginate(15);

        return view('applications.index', compact('applications'));
    }

    public function create(): View
    {
        $tenantId = auth()->user()->tenant_id;

        $candidates = Candidate::where('tenant_id', $tenantId)->get();
        $jobPostings = JobPosting::where('tenant_id', $tenantId)->get();

        return view('applications.create', compact('candidates', 'jobPostings'));
    }

    public function store(Request $request): RedirectResponse
    {
        $tenantId = auth()->user()->tenant_id;

        $validated = $request->validate([
            'candidate_id' => [
                'required',
                Rule::exists('candidates', 'id')->where('tenant_id', $tenantId),
            ],
            'job_posting_id' => [
                'required',
                Rule::exists('job_postings', 'id')->where('tenant_id', $tenantId),
                Rule::unique('applications')->where(function ($query) use ($request) {
                    return $query->where('candidate_id', $request->candidate_id);
                }),
            ],
            'stage' => 'required|in:applied,screening,interview,offer,hired,rejected',
            'applied_at' => 'nullable|date',
        ]);

        $validated['tenant_id'] = $tenantId;

        Application::create($validated);

        return redirect()->route('applications.index')->with('success', 'Application created.');
    }

    public function show(Application $application): View
    {
        abort_if($application->tenant_id !== auth()->user()->tenant_id, 403);

        return view('applications.show', compact('application'));
    }

    public function edit(Application $application): View
    {
        abort_if($application->tenant_id !== auth()->user()->tenant_id, 403);

        $tenantId = auth()->user()->tenant_id;

        $candidates = Candidate::where('tenant_id', $tenantId)->get();
        $jobPostings = JobPosting::where('tenant_id', $tenantId)->get();

        return view('applications.edit', compact('application', 'candidates', 'jobPostings'));
    }

    public function update(Request $request, Application $application): RedirectResponse
    {
        abort_if($application->tenant_id !== auth()->user()->tenant_id, 403);

        $tenantId = auth()->user()->tenant_id;

        $validated = $request->validate([
            'candidate_id' => [
                'required',
                Rule::exists('candidates', 'id')->where('tenant_id', $tenantId),
            ],
            'job_posting_id' => [
                'required',
                Rule::exists('job_postings', 'id')->where('tenant_id', $tenantId),
                Rule::unique('applications')
                    ->where(function ($query) use ($request) {
                        return $query->where('candidate_id', $request->candidate_id);
                    })
                    ->ignore($application->id),
            ],
            'stage' => 'required|in:applied,screening,interview,offer,hired,rejected',
            'applied_at' => 'nullable|date',
        ]);

        $application->update($validated);

        return redirect()->route('applications.index')->with('success', 'Application updated.');
    }

    public function destroy(Application $application): RedirectResponse
    {
        abort_if($application->tenant_id !== auth()->user()->tenant_id, 403);

        $application->delete();

        return redirect()->route('applications.index')->with('success', 'Application deleted.');
    }
}
