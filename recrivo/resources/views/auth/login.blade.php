<!DOCTYPE html>
<html>
<head><title>Login</title></head>
<body>
    <h1>Login</h1>

    @if ($errors->any())
        <div style="color:red">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div>
            <label>Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required>
        </div>
        <div>
            <label>Password</label>
            <input type="password" name="password" required>
        </div>
        <div>
            <label><input type="checkbox" name="remember"> Remember me</label>
        </div>
        <button type="submit">Login</button>
    </form>

    <p>No account? <a href="{{ route('register') }}">Register</a></p>
</body>
</html>