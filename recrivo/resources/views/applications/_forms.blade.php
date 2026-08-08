@php
    $a = $application ?? null;
    $selectedCandidate = old('candidate_id', $a->candidate_id ?? '');
    $selectedJobPosting = old('job_posting_id', $a->job_posting_id ?? '');
    $selectedStage = old('stage', $a->stage ?? 'applied');
@endphp

<div class="grid grid-cols-2 gap-5">
    <x-form-field name="candidate_id" label="Candidate" type="select" required>
        @if (! $a)
            <option value="">-- Select --</option>
        @endif
        @foreach ($candidates as $candidate)
            <option value="{{ $candidate->id }}" @selected($selectedCandidate == $candidate->id)>
                {{ $candidate->first_name }} {{ $candidate->last_name }} ({{ $candidate->email }})
            </option>
        @endforeach
    </x-form-field>

    <x-form-field name="job_posting_id" label="Job Posting" type="select" required>
        @if (! $a)
            <option value="">-- Select --</option>
        @endif
        @foreach ($jobPostings as $jobPosting)
            <option value="{{ $jobPosting->id }}" @selected($selectedJobPosting == $jobPosting->id)>
                {{ $jobPosting->title }}
            </option>
        @endforeach
    </x-form-field>
</div>

<div class="grid grid-cols-2 gap-5 mt-5">
    <x-form-field name="stage" label="Stage" type="select" required>
        <option value="applied" @selected($selectedStage == 'applied')>Applied</option>
        <option value="screening" @selected($selectedStage == 'screening')>Screening</option>
        <option value="interview" @selected($selectedStage == 'interview')>Interview</option>
        <option value="offer" @selected($selectedStage == 'offer')>Offer</option>
        <option value="on_hold" @selected($selectedStage == 'on_hold')>On Hold</option>
        <option value="hired" @selected($selectedStage == 'hired')>Hired</option>
        <option value="rejected" @selected($selectedStage == 'rejected')>Rejected</option>
    </x-form-field>

    <x-form-field name="applied_at" label="Applied At" type="date"
        value="{{ old('applied_at', $a?->applied_at?->format('Y-m-d') ?? now()->format('Y-m-d')) }}" />
</div>