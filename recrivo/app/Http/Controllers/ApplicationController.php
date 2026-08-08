<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Candidate;
use App\Models\JobPosting;
use App\Services\PipelineStageService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use InvalidArgumentException;

class ApplicationController extends Controller
{
    public function __construct(private PipelineStageService $pipelineStageService) {}

    public function index(): View
    {
        $tenantId = auth()->user()->tenant_id;

        $applications = Application::with(['candidate', 'jobPosting'])
            ->where('tenant_id', $tenantId)
            ->latest()
            ->get();

        $applicationsByStage = $applications->groupBy('stage');

        return view('applications.index', compact('applicationsByStage'));
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
            'stage' => 'required|in:applied,screening,interview,offer,hired,on_hold,rejected',
            'applied_at' => 'nullable|date',
        ]);

        $validated['tenant_id'] = $tenantId;

        // Starting stage is set directly at creation time — this is the one place
        // the pipeline's forward-only rule intentionally does NOT apply
        // (handles referred/fast-tracked candidates starting mid-pipeline).
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
            'stage' => 'required|in:applied,screening,interview,offer,hired,on_hold,rejected',
            'applied_at' => 'nullable|date',
        ]);

        $stageChanged = $validated['stage'] !== $application->stage;

        // Update the non-stage fields directly — these aren't governed by pipeline rules
        $application->fill([
            'candidate_id' => $validated['candidate_id'],
            'job_posting_id' => $validated['job_posting_id'],
            'applied_at' => $validated['applied_at'],
        ]);
        $application->save();

        if ($stageChanged) {
            try {
                $this->pipelineStageService->transitionTo($application, $validated['stage']);
            } catch (InvalidArgumentException $e) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->withErrors(['stage' => $e->getMessage()]);
            }
        }

        return redirect()->route('applications.index')->with('success', 'Application updated.');
    }

    public function destroy(Application $application): RedirectResponse
    {
        abort_if($application->tenant_id !== auth()->user()->tenant_id, 403);

        $application->delete();

        return redirect()->route('applications.index')->with('success', 'Application deleted.');
    }

    public function transitionStage(Request $request, Application $application): \Illuminate\Http\JsonResponse
    {
        abort_if($application->tenant_id !== auth()->user()->tenant_id, 403);

        $validated = $request->validate([
            'stage' => 'required|in:applied,screening,interview,offer,hired,on_hold,rejected',
        ]);

        try {
            $this->pipelineStageService->transitionTo($application, $validated['stage']);
        } catch (InvalidArgumentException $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }

        return response()->json([
            'stage' => $application->fresh()->stage,
            'previous_stage' => $application->fresh()->previous_stage,
        ]);
    }
}
