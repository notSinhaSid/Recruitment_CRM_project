<!DOCTYPE html>
<html>
<head><title>Companies</title></head>
<body>
    <h1>Companies</h1>

    @if (session('success'))
        <p style="color:green">{{ session('success') }}</p>
    @endif

    <a href="{{ route('companies.create') }}">+ New Company</a>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit">Logout</button>
    </form>

    <table border="1" cellpadding="5">
        <tr>
            <th>Name</th>
            <th>Industry</th>
            <th>Location</th>
            <th>Actions</th>
        </tr>
        @forelse ($companies as $company)
            <tr>
                <td>{{ $company->name }}</td>
                <td>{{ $company->industry }}</td>
                <td>{{ $company->location }}</td>
                <td>
                    <a href="{{ route('companies.show', $company) }}">View</a>
                    <a href="{{ route('companies.edit', $company) }}">Edit</a>
                    <form method="POST" action="{{ route('companies.destroy', $company) }}" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Delete this company?')">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="4">No companies yet.</td></tr>
        @endforelse
    </table>

    {{ $companies->links() }}
</body>
</html>