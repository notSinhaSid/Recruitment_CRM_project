<!DOCTYPE html>
<html>
<head><title>New Company</title></head>
<body>
    <h1>New Company</h1>

    @if ($errors->any())
        <div style="color:red">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('companies.store') }}">
        @csrf
        <div><label>Name</label><input type="text" name="name" value="{{ old('name') }}" required></div>
        <div><label>Industry</label><input type="text" name="industry" value="{{ old('industry') }}"></div>
        <div><label>Website</label><input type="text" name="website" value="{{ old('website') }}"></div>
        <div><label>Contact Number</label><input type="text" name="contact_number" value="{{ old('contact_number') }}"></div>
        <div><label>Location</label><input type="text" name="location" value="{{ old('location') }}"></div>
        <div><label>Notes</label><textarea name="notes">{{ old('notes') }}</textarea></div>
        <button type="submit">Save</button>
    </form>

    <a href="{{ route('companies.index') }}">Back</a>
</body>
</html>