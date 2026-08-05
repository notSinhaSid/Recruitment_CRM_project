<!DOCTYPE html>
<html>
<head><title>{{ $company->name }}</title></head>
<body>
    <h1>{{ $company->name }}</h1>
    <p><strong>Industry:</strong> {{ $company->industry }}</p>
    <p><strong>Website:</strong> {{ $company->website }}</p>
    <p><strong>Contact:</strong> {{ $company->contact_number }}</p>
    <p><strong>Location:</strong> {{ $company->location }}</p>
    <p><strong>Notes:</strong> {{ $company->notes }}</p>

    <a href="{{ route('companies.edit', $company) }}">Edit</a>
    <a href="{{ route('companies.index') }}">Back</a>
</body>
</html>