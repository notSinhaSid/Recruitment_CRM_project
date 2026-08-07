<h1>Dashboard</h1>

<p>
    <a href="{{ route('candidates.index') }}">Candidates</a> |
    <a href="{{ route('job-postings.index') }}">Job Postings</a> |
    <a href="{{ route('applications.index') }}">Applications</a>
</p>

<h2>Overview</h2>
<table border="1" cellpadding="8">
    <tr>
        <th>Candidates</th>
        <th>Job Postings</th>
        <th>Applications</th>
    </tr>
    <tr>
        <td>{{ $counts['candidates'] }}</td>
        <td>{{ $counts['job_postings'] }}</td>
        <td>{{ $counts['applications'] }}</td>
    </tr>
</table>

<h2>Applications by Stage</h2>
<table border="1" cellpadding="8">
    <tr>
        <th>Stage</th>
        <th>Count</th>
    </tr>
    @forelse ($stageBreakdown as $stage => $total)
        <tr>
            <td>{{ ucfirst(str_replace('_', ' ', $stage)) }}</td>
            <td>{{ $total }}</td>
        </tr>
    @empty
        <tr>
            <td colspan="2">No applications yet.</td>
        </tr>
    @endforelse
</table>

<h2>Recent Activity</h2>
<table border="1" cellpadding="8">
    <tr>
        <th>When</th>
        <th>User</th>
        <th>Action</th>
        <th>Type</th>
    </tr>
    @forelse ($recentActivity as $log)
        <tr>
            <td>{{ $log->created_at->diffForHumans() }}</td>
            <td>{{ $log->user->first_name ?? 'System' }} {{ $log->user->last_name ?? '' }}</td>
            <td>{{ ucfirst($log->action) }}</td>
            <td>{{ class_basename($log->auditable_type) }}</td>
        </tr>
    @empty
        <tr>
            <td colspan="4">No activity yet.</td>
        </tr>
    @endforelse
</table>