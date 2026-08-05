<!DOCTYPE html>
<html>
<head><title>Register</title></head>
<body>
    <h1>Register</h1>

    @if ($errors->any())
        <div style="color:red">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div>
            <label>Company Name</label>
            <input type="text" name="company_name" value="{{ old('company_name') }}" required>
        </div>
        <div>
            <label>First Name</label>
            <input type="text" name="first_name" value="{{ old('first_name') }}" required>
        </div>
        <div>
            <label>Last Name</label>
            <input type="text" name="last_name" value="{{ old('last_name') }}" required>
        </div>
        <div>
            <label>Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required>
        </div>
        <div>
            <label>Password</label>
            <input type="password" name="password" required>
        </div>
        <div>
            <label>Confirm Password</label>
            <input type="password" name="password_confirmation" required>
        </div>
        <button type="submit">Register</button>
    </form>

    <p>Already have an account? <a href="{{ route('login') }}">Login</a></p>
</body>
</html>