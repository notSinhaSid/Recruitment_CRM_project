<!DOCTYPE html>
<html>
<head><title>{{ $jobPosting->title }}</title></head>
<body>
    <h1>{{ $jobPosting->title }}</h1>

    <p><strong>Company:</strong> {{ $jobPosting->company->name }}</p>
    <p><strong>Status:</strong> {{ $jobPosting->status }}</p>
    <p><strong>Location:</strong> {{ $jobPosting->location ?? '—' }}</p>
    <p><strong>Employment Type:</strong> {{ $jobPosting->employment_type ?? '—' }}</p>
    <p><strong>Open Spots:</strong> {{ $jobPosting->open_spots }}</p>
    <p><strong>Description:</strong></p>
    <p>{{ $jobPosting->description ?? '—' }}</p>

    <a href="{{ route('job-postings.edit', $jobPosting) }}">Edit</a>
    <a href="{{ route('job-postings.index') }}">Back to list</a>
</body>
</html>