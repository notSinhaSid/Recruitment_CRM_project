<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Candidate;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;

class CandidateController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $candidates = Candidate::where('tenant_id', $request->user()->tenant_id)
            ->latest()
            ->paginate(15);

        return response()->json($candidates);
    }

    public function show(Request $request, Candidate $candidate): JsonResponse
    {
        abort_if($candidate->tenant_id !== $request->user()->tenant_id, 403);

        return response()->json($candidate);
    }

    public function store(Request $request): JsonResponse
    {
        $tenantId = $request->user()->tenant_id;

        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('candidates')->where('tenant_id', $tenantId),
            ],
            'phone' => 'nullable|string|max:20',
            'linkedin_url' => 'nullable|url',
            'years_of_experience' => 'nullable|integer',
            'source' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
            'resume' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
        ]);

        $validated['tenant_id'] = $tenantId;

        if ($request->hasFile('resume')) {
            $validated['resume_path'] = $request->file('resume')->store('resumes', 'public');
            unset($validated['resume']);
        }

        $candidate = Candidate::create($validated);

        return response()->json($candidate, 201);
    }

    public function update(Request $request, Candidate $candidate): JsonResponse
    {
        abort_if($candidate->tenant_id !== $request->user()->tenant_id, 403);

        $tenantId = $request->user()->tenant_id;

        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('candidates')->where('tenant_id', $tenantId)->ignore($candidate->id),
            ],
            'phone' => 'nullable|string|max:20',
            'linkedin_url' => 'nullable|url',
            'years_of_experience' => 'nullable|integer',
            'source' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
            'resume' => 'nullable|file|mimes:pdf,doc,docx|max:3072',
        ]);

        if ($request->hasFile('resume')) {
            $validated['resume_path'] = $request->file('resume')->store('resumes', 'public');
        }
        unset($validated['resume']);

        $candidate->update($validated);

        return response()->json($candidate);
    }

    public function destroy(Request $request, Candidate $candidate): JsonResponse
    {
        abort_if($candidate->tenant_id !== $request->user()->tenant_id, 403);

        $candidate->delete();

        return response()->json(null, 204);
    }
}
