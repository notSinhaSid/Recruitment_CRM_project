<!DOCTYPE html>
<html>
<head><title>Create Job Posting</title></head>
<body>
    <h1>Create Job Posting</h1>

    @if ($errors->any())
        <ul style="color:red">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form method="POST" action="{{ route('job-postings.store') }}">
        @csrf

        <label>Company</label><br>
        <select name="company_id" required>
            <option value="">-- Select --</option>
            @foreach ($companies as $company)
                <option value="{{ $company->id }}" @selected(old('company_id') == $company->id)>
                    {{ $company->name }}
                </option>
            @endforeach
        </select><br><br>

        <label>Title</label><br>
        <input type="text" name="title" value="{{ old('title') }}" required><br><br>

        <label>Description</label><br>
        <textarea name="description">{{ old('description') }}</textarea><br><br>

        <label>Status</label><br>
        <select name="status" required>
            <option value="open" @selected(old('status', 'open') == 'open')>Open</option>
            <option value="closed" @selected(old('status') == 'closed')>Closed</option>
            <option value="on_hold" @selected(old('status') == 'on_hold')>On Hold</option>
        </select><br><br>

        <label>Location</label><br>
        <input type="text" name="location" value="{{ old('location') }}"><br><br>

        <label>Employment Type</label><br>
        <input type="text" name="employment_type" value="{{ old('employment_type') }}"><br><br>

        <label>Open Spots</label><br>
        <input type="number" name="open_spots" value="{{ old('open_spots', 1) }}" min="1" required><br><br>

        <button type="submit">Create</button>
    </form>
</body>
</html>