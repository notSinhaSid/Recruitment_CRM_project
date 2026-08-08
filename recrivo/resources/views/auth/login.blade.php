<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Log in — Recrivo</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    @vite('resources/css/app.css')
</head>
<body class="font-sans antialiased bg-[var(--color-bg)] min-h-screen flex items-center justify-center px-4">

    <div class="w-full max-w-md">
        <div class="text-center mb-8">
            <span class="text-2xl font-semibold tracking-tight text-[var(--color-primary)]">Recrivo</span>
        </div>

        <div class="bg-[var(--color-card)] border border-[var(--color-border)] rounded-xl p-8 shadow-sm">
            <h1 class="text-xl font-semibold text-[var(--color-text)] mb-6">Log in to your account</h1>

            @if ($errors->any())
                <div class="mb-6 rounded-lg border border-[var(--color-coral)]/30 bg-[var(--color-coral)]/5 px-4 py-3">
                    <ul class="text-sm text-[var(--color-coral)] space-y-0.5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <x-form-field name="email" label="Email" type="email" required autofocus value="{{ old('email') }}" />

                <x-form-field name="password" label="Password" type="password" required />

                <label class="flex items-center gap-2 text-sm text-[var(--color-text-secondary)]">
                    <input type="checkbox" name="remember"
                        class="rounded border-[var(--color-border)] text-[var(--color-primary)] focus:ring-[var(--color-primary)]/30">
                    Remember me
                </label>

                <button type="submit"
                    class="w-full py-2.5 rounded-lg bg-[var(--color-primary)] text-white text-sm font-medium hover:bg-[var(--color-primary-light)] transition">
                    Log in
                </button>
            </form>
        </div>

        <p class="text-center text-sm text-[var(--color-text-secondary)] mt-6">
            No account?
            <a href="{{ route('register') }}" class="text-[var(--color-primary)] font-medium hover:underline">Register</a>
        </p>
    </div>

</body>
</html>