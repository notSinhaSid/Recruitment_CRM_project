<!DOCTYPE html>
<html>
<head><title>Edit Candidate</title></head>
<body>
    <h1>Edit Candidate</h1>

    @if ($errors->any())
        <ul style="color:red">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form method="POST" action="{{ route('candidates.update', $candidate) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <label>First Name</label><br>
        <input type="text" name="first_name" value="{{ old('first_name', $candidate->first_name) }}" required><br><br>

        <label>Last Name</label><br>
        <input type="text" name="last_name" value="{{ old('last_name', $candidate->last_name) }}" required><br><br>

        <label>Email</label><br>
        <input type="email" name="email" value="{{ old('email', $candidate->email) }}" required><br><br>

        <label>Phone</label><br>
        <input type="text" name="phone" value="{{ old('phone', $candidate->phone) }}"><br><br>

        <label>LinkedIn URL</label><br>
        <input type="url" name="linkedin_url" value="{{ old('linkedin_url', $candidate->linkedin_url) }}"><br><br>

        <label>Years of Experience</label><br>
        <input type="number" name="years_of_experience" value="{{ old('years_of_experience', $candidate->years_of_experience) }}" min="0"><br><br>

        <label>Source</label><br>
        <input type="text" name="source" value="{{ old('source', $candidate->source) }}"><br><br>

        <label>Resume (PDF or DOC, max 3MB)</label><br>
        @if ($candidate->resume_path)
            <p>Current: <a href="{{ Storage::url($candidate->resume_path) }}" target="_blank">View existing resume</a></p>
        @endif
        <input type="file" name="resume" accept=".pdf,.doc,.docx"><br><br>

        <label>Notes</label><br>
        <textarea name="notes">{{ old('notes', $candidate->notes) }}</textarea><br><br>

        <button type="submit">Update</button>
    </form>
</body>
</html>