<!DOCTYPE html>
<html>
<head><title>Create Application</title></head>
<body>
    <h1>Create Application</h1>

    @if ($errors->any())
        <ul style="color:red">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form method="POST" action="{{ route('applications.store') }}">
        @csrf

        <label>Candidate</label><br>
        <select name="candidate_id" required>
            <option value="">-- Select --</option>
            @foreach ($candidates as $candidate)
                <option value="{{ $candidate->id }}" @selected(old('candidate_id') == $candidate->id)>
                    {{ $candidate->first_name }} {{ $candidate->last_name }} ({{ $candidate->email }})
                </option>
            @endforeach
        </select><br><br>

        <label>Job Posting</label><br>
        <select name="job_posting_id" required>
            <option value="">-- Select --</option>
            @foreach ($jobPostings as $jobPosting)
                <option value="{{ $jobPosting->id }}" @selected(old('job_posting_id') == $jobPosting->id)>
                    {{ $jobPosting->title }}
                </option>
            @endforeach
        </select><br><br>

        <label>Stage</label><br>
        <select name="stage" required>
            <option value="applied" @selected(old('stage', 'applied') == 'applied')>Applied</option>
            <option value="screening" @selected(old('stage') == 'screening')>Screening</option>
            <option value="interview" @selected(old('stage') == 'interview')>Interview</option>
            <option value="offer" @selected(old('stage') == 'offer')>Offer</option>
            <option value="hired" @selected(old('stage') == 'hired')>Hired</option>
            <option value="rejected" @selected(old('stage') == 'rejected')>Rejected</option>
        </select><br><br>

        <label>Applied At</label><br>
        <input type="date" name="applied_at" value="{{ old('applied_at', now()->format('Y-m-d')) }}"><br><br>

        <button type="submit">Create</button>
    </form>
</body>
</html>