<!DOCTYPE html>
<html>
<head><title>Create Candidate</title></head>
<body>
    <h1>Create Candidate</h1>

    @if ($errors->any())
        <ul style="color:red">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form method="POST" action="{{ route('candidates.store') }}" enctype="multipart/form-data">
        @csrf

        <label>First Name</label><br>
        <input type="text" name="first_name" value="{{ old('first_name') }}" required><br><br>

        <label>Last Name</label><br>
        <input type="text" name="last_name" value="{{ old('last_name') }}" required><br><br>

        <label>Email</label><br>
        <input type="email" name="email" value="{{ old('email') }}" required><br><br>

        <label>Phone</label><br>
        <input type="text" name="phone" value="{{ old('phone') }}"><br><br>

        <label>LinkedIn URL</label><br>
        <input type="url" name="linkedin_url" value="{{ old('linkedin_url') }}"><br><br>

        <label>Years of Experience</label><br>
        <input type="number" name="years_of_experience" value="{{ old('years_of_experience') }}" min="0"><br><br>

        <label>Source</label><br>
        <input type="text" name="source" value="{{ old('source') }}" placeholder="LinkedIn, Referral, Job Board..."><br><br>

        <label>Resume (PDF or DOC, max 3MB)</label><br>
        <input type="file" name="resume" accept=".pdf,.doc,.docx"><br><br>

        <label>Notes</label><br>
        <textarea name="notes">{{ old('notes') }}</textarea><br><br>

        <button type="submit">Create</button>
    </form>
</body>
</html>