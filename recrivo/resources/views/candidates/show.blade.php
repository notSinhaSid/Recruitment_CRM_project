<!DOCTYPE html>
<html>
<head><title>{{ $candidate->first_name }} {{ $candidate->last_name }}</title></head>
<body>
    <h1>{{ $candidate->first_name }} {{ $candidate->last_name }}</h1>

    <p><strong>Email:</strong> {{ $candidate->email }}</p>
    <p><strong>Phone:</strong> {{ $candidate->phone ?? '—' }}</p>
    <p><strong>LinkedIn:</strong>
        @if ($candidate->linkedin_url)
            <a href="{{ $candidate->linkedin_url }}" target="_blank">{{ $candidate->linkedin_url }}</a>
        @else
            —
        @endif
    </p>
    <p><strong>Years of Experience:</strong> {{ $candidate->years_of_experience ?? '—' }}</p>
    <p><strong>Source:</strong> {{ $candidate->source ?? '—' }}</p>
    <p><strong>Resume:</strong>
        @if ($candidate->resume_path)
            <a href="{{ Storage::url($candidate->resume_path) }}" target="_blank">View resume</a>
        @else
            Not uploaded
        @endif
    </p>
    <p><strong>Notes:</strong></p>
    <p>{{ $candidate->notes ?? '—' }}</p>

    <a href="{{ route('candidates.edit', $candidate) }}">Edit</a>
    <a href="{{ route('candidates.index') }}">Back to list</a>
</body>
</html>