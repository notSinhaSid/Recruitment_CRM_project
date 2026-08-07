<!DOCTYPE html>
<html>
<head><title>Edit Job Posting</title></head>
<body>
    <h1>Edit Job Posting</h1>

    @if ($errors->any())
        <ul style="color:red">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form method="POST" action="{{ route('job-postings.update', $jobPosting) }}">
        @csrf
        @method('PUT')

        <label>Company</label><br>
        <select name="company_id" required>
            @foreach ($companies as $company)
                <option value="{{ $company->id }}" @selected(old('company_id', $jobPosting->company_id) == $company->id)>
                    {{ $company->name }}
                </option>
            @endforeach
        </select><br><br>

        <label>Title</label><br>
        <input type="text" name="title" value="{{ old('title', $jobPosting->title) }}" required><br><br>

        <label>Description</label><br>
        <textarea name="description">{{ old('description', $jobPosting->description) }}</textarea><br><br>

        <label>Status</label><br>
        <select name="status" required>
            <option value="open" @selected(old('status', $jobPosting->status) == 'open')>Open</option>
            <option value="closed" @selected(old('status', $jobPosting->status) == 'closed')>Closed</option>
            <option value="on_hold" @selected(old('status', $jobPosting->status) == 'on_hold')>On Hold</option>
        </select><br><br>

        <label>Location</label><br>
        <input type="text" name="location" value="{{ old('location', $jobPosting->location) }}"><br><br>

        <label>Employment Type</label><br>
        <input type="text" name="employment_type" value="{{ old('employment_type', $jobPosting->employment_type) }}"><br><br>

        <label>Open Spots</label><br>
        <input type="number" name="open_spots" value="{{ old('open_spots', $jobPosting->open_spots) }}" min="1" required><br><br>

        <button type="submit">Update</button>
    </form>
</body>
</html>