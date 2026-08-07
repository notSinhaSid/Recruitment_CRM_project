<!DOCTYPE html>
<html>
<head><title>Applications</title></head>
<body>
    <h1>Applications</h1>

    @if (session('success'))
        <p style="color:green">{{ session('success') }}</p>
    @endif

    <a href="{{ route('applications.create') }}">+ New Application</a>
    <a href="{{ route('companies.index') }}">Back to Companies</a>

    <table border="1" cellpadding="5">
        <tr>
            <th>Candidate</th>
            <th>Job Posting</th>
            <th>Stage</th>
            <th>Applied At</th>
            <th>Actions</th>
        </tr>
        @forelse ($applications as $application)
            <tr>
                <td>{{ $application->candidate->first_name }} {{ $application->candidate->last_name }}</td>
                <td>{{ $application->jobPosting->title }}</td>
                <td>{{ $application->stage }}</td>
                <td>{{ $application->applied_at?->format('Y-m-d') ?? '—' }}</td>
                <td>
                    <a href="{{ route('applications.show', $application) }}">View</a>
                    <a href="{{ route('applications.edit', $application) }}">Edit</a>
                    <form method="POST" action="{{ route('applications.destroy', $application) }}" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Delete this application?')">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="5">No applications yet.</td></tr>
        @endforelse
    </table>

    {{ $applications->links() }}
</body>
</html>