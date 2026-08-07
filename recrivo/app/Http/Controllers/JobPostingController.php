<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\JobPosting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class JobPostingController extends Controller
{
    public function index(): View
    {
        $jobPostings = JobPosting::where('tenant_id', auth()->user()->tenant_id)
            ->with('company')
            ->latest()
            ->paginate(15);

        return view('job-postings.index', compact('jobPostings'));
    }

    public function create(): View
    {
        $companies = Company::where('tenant_id', auth()->user()->tenant_id)->get();

        return view('job-postings.create', compact('companies'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'company_id' => 'required|exists:companies,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:open,closed,on_hold',
            'location' => 'nullable|string|max:255',
            'employment_type' => 'nullable|string|max:255',
            'open_spots' => 'required|integer|min:1',
        ]);

        // guard against a spoofed company_id from another tenant
        $company = Company::findOrFail($validated['company_id']);
        abort_if($company->tenant_id !== auth()->user()->tenant_id, 403);

        $validated['tenant_id'] = auth()->user()->tenant_id;

        JobPosting::create($validated);

        return redirect()->route('job-postings.index')->with('success', 'Job posting created.');
    }

    public function show(JobPosting $jobPosting): View
    {
        abort_if($jobPosting->tenant_id !== auth()->user()->tenant_id, 403);

        return view('job-postings.show', compact('jobPosting'));
    }

    public function edit(JobPosting $jobPosting): View
    {
        abort_if($jobPosting->tenant_id !== auth()->user()->tenant_id, 403);

        $companies = Company::where('tenant_id', auth()->user()->tenant_id)->get();

        return view('job-postings.edit', compact('jobPosting', 'companies'));
    }

    public function update(Request $request, JobPosting $jobPosting): RedirectResponse
    {
        abort_if($jobPosting->tenant_id !== auth()->user()->tenant_id, 403);

        $validated = $request->validate([
            'company_id' => 'required|exists:companies,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:open,closed,on_hold',
            'location' => 'nullable|string|max:255',
            'employment_type' => 'nullable|string|max:255',
            'open_spots' => 'required|integer|min:1',
        ]);

        $company = Company::findOrFail($validated['company_id']);
        abort_if($company->tenant_id !== auth()->user()->tenant_id, 403);

        $jobPosting->update($validated);

        return redirect()->route('job-postings.index')->with('success', 'Job posting updated.');
    }

    public function destroy(JobPosting $jobPosting): RedirectResponse
    {
        abort_if($jobPosting->tenant_id !== auth()->user()->tenant_id, 403);

        $jobPosting->delete();

        return redirect()->route('job-postings.index')->with('success', 'Job posting deleted.');
    }
}