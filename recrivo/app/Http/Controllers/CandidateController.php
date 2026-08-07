<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class CandidateController extends Controller
{
    public function index(): View
    {
        $candidates = Candidate::where('tenant_id', auth()->user()->tenant_id)
            ->latest()
            ->paginate(15);

        return view('candidates.index', compact('candidates'));
    }

    public function create(): View
    {
        return view('candidates.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('candidates')->where('tenant_id', auth()->user()->tenant_id),
            ],
            'phone' => 'nullable|string|max:255',
            'linkedin_url' => 'nullable|url|max:255',
            'years_of_experience' => 'nullable|integer|min:0',
            'source' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
            'resume' => 'nullable|file|mimes:pdf,doc,docx|max:3072',
        ]);

        $validated['tenant_id'] = auth()->user()->tenant_id;

        if ($request->hasFile('resume')) {
            $validated['resume_path'] = $request->file('resume')->store('resumes', 'public');
        }
        unset($validated['resume']);

        Candidate::create($validated);

        return redirect()->route('candidates.index')->with('success', 'Candidate created.');
    }

    public function show(Candidate $candidate): View
    {
        abort_if($candidate->tenant_id !== auth()->user()->tenant_id, 403);

        return view('candidates.show', compact('candidate'));
    }

    public function edit(Candidate $candidate): View
    {
        abort_if($candidate->tenant_id !== auth()->user()->tenant_id, 403);

        return view('candidates.edit', compact('candidate'));
    }

    public function update(Request $request, Candidate $candidate): RedirectResponse
    {
        abort_if($candidate->tenant_id !== auth()->user()->tenant_id, 403);

        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('candidates')
                    ->where('tenant_id', auth()->user()->tenant_id)
                    ->ignore($candidate->id),
            ],
            'phone' => 'nullable|string|max:255',
            'linkedin_url' => 'nullable|url|max:255',
            'years_of_experience' => 'nullable|integer|min:0',
            'source' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
            'resume' => 'nullable|file|mimes:pdf,doc,docx|max:3072',
        ]);

        if ($request->hasFile('resume')) {
            $validated['resume_path'] = $request->file('resume')->store('resumes', 'public');
        }
        unset($validated['resume']);

        $candidate->update($validated);

        return redirect()->route('candidates.index')->with('success', 'Candidate updated.');
    }

    public function destroy(Candidate $candidate): RedirectResponse
    {
        abort_if($candidate->tenant_id !== auth()->user()->tenant_id, 403);

        $candidate->delete();

        return redirect()->route('candidates.index')->with('success', 'Candidate deleted.');
    }
}