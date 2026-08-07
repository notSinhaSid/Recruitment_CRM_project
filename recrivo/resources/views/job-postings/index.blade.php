<!DOCTYPE html>
<html>
<head><title>Job Postings</title></head>
<body>
    <h1>Job Postings</h1>

    @if (session('success'))
        <p style="color:green">{{ session('success') }}</p>
    @endif

    <a href="{{ route('job-postings.create') }}">+ New Job Posting</a>
    <a href="{{ route('companies.index') }}">Back to Companies</a>

    <table border="1" cellpadding="5">
        <tr>
            <th>Title</th>
            <th>Company</th>
            <th>Status</th>
            <th>Open Spots</th>
            <th>Actions</th>
        </tr>
        @forelse ($jobPostings as $jobPosting)
            <tr>
                <td>{{ $jobPosting->title }}</td>
                <td>{{ $jobPosting->company->name }}</td>
                <td>{{ $jobPosting->status }}</td>
                <td>{{ $jobPosting->open_spots }}</td>
                <td>
                    <a href="{{ route('job-postings.show', $jobPosting) }}">View</a>
                    <a href="{{ route('job-postings.edit', $jobPosting) }}">Edit</a>
                    <form method="POST" action="{{ route('job-postings.destroy', $jobPosting) }}" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Delete this job posting?')">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="5">No job postings yet.</td></tr>
        @endforelse
    </table>

    {{ $jobPostings->links() }}
</body>
</html>