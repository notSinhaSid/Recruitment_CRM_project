<!DOCTYPE html>
<html>
<head><title>Application Details</title></head>
<body>
    <h1>Application Details</h1>

    <p><strong>Candidate:</strong>
        <a href="{{ route('candidates.show', $application->candidate) }}">
            {{ $application->candidate->first_name }} {{ $application->candidate->last_name }}
        </a>
    </p>
    <p><strong>Job Posting:</strong>
        <a href="{{ route('job-postings.show', $application->jobPosting) }}">
            {{ $application->jobPosting->title }}
        </a>
    </p>
    <p><strong>Stage:</strong> {{ $application->stage }}</p>
    <p><strong>Applied At:</strong> {{ $application->applied_at?->format('Y-m-d') ?? '—' }}</p>

    <a href="{{ route('applications.edit', $application) }}">Edit</a>
    <a href="{{ route('applications.index') }}">Back to list</a>
</body>
</html>