<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Services\PipelineStageService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;
use InvalidArgumentException;

class ApplicationController extends Controller
{
    public function __construct(private PipelineStageService $pipelineStageService) {}

    public function index(Request $request): JsonResponse
    {
        $applications = Application::where('tenant_id', $request->user()->tenant_id)
            ->with(['candidate', 'jobPosting'])
            ->latest()
            ->paginate(15);

        return response()->json($applications);
    }

    public function show(Request $request, Application $application): JsonResponse
    {
        abort_if($application->tenant_id !== $request->user()->tenant_id, 403);

        return response()->json($application->load(['candidate', 'jobPosting']));
    }

    public function store(Request $request): JsonResponse
    {
        $tenantId = $request->user()->tenant_id;

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

        $application = Application::create($validated);

        return response()->json($application, 201);
    }

    public function update(Request $request, Application $application): JsonResponse
    {
        abort_if($application->tenant_id !== $request->user()->tenant_id, 403);

        $tenantId = $request->user()->tenant_id;

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
                return response()->json(['error' => $e->getMessage()], 422);
            }
        }

        return response()->json($application->fresh());
    }

    public function destroy(Request $request, Application $application): JsonResponse
    {
        abort_if($application->tenant_id !== $request->user()->tenant_id, 403);

        $application->delete();

        return response()->json(null, 204);
    }
}