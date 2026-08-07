<!DOCTYPE html>
<html>
<head><title>Candidates</title></head>
<body>
    <h1>Candidates</h1>

    @if (session('success'))
        <p style="color:green">{{ session('success') }}</p>
    @endif

    <a href="{{ route('candidates.create') }}">+ New Candidate</a>
    <a href="{{ route('companies.index') }}">Back to Companies</a>

    <table border="1" cellpadding="5">
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Experience</th>
            <th>Actions</th>
        </tr>
        @forelse ($candidates as $candidate)
            <tr>
                <td>{{ $candidate->first_name }} {{ $candidate->last_name }}</td>
                <td>{{ $candidate->email }}</td>
                <td>{{ $candidate->phone ?? '—' }}</td>
                <td>{{ $candidate->years_of_experience ?? '—' }}</td>
                <td>
                    <a href="{{ route('candidates.show', $candidate) }}">View</a>
                    <a href="{{ route('candidates.edit', $candidate) }}">Edit</a>
                    <form method="POST" action="{{ route('candidates.destroy', $candidate) }}" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Delete this candidate?')">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="5">No candidates yet.</td></tr>
        @endforelse
    </table>

    {{ $candidates->links() }}
</body>
</html>