<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register — Recrivo</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    @vite('resources/css/app.css')
</head>
<body class="font-sans antialiased bg-[var(--color-bg)] min-h-screen flex items-center justify-center px-4 py-12">

    <div class="w-full max-w-md">
        <div class="text-center mb-8">
            <span class="text-2xl font-semibold tracking-tight text-[var(--color-primary)]">Recrivo</span>
        </div>

        <div class="bg-[var(--color-card)] border border-[var(--color-border)] rounded-xl p-8 shadow-sm">
            <h1 class="text-xl font-semibold text-[var(--color-text)] mb-1">Create your account</h1>
            <p class="text-sm text-[var(--color-text-secondary)] mb-6">Set up your organization on Recrivo</p>

            @if ($errors->any())
                <div class="mb-6 rounded-lg border border-[var(--color-coral)]/30 bg-[var(--color-coral)]/5 px-4 py-3">
                    <ul class="text-sm text-[var(--color-coral)] space-y-0.5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}" class="space-y-5">
                @csrf

                <x-form-field name="company_name" label="Company Name" required value="{{ old('company_name') }}" />

                <div class="grid grid-cols-2 gap-4">
                    <x-form-field name="first_name" label="First Name" required value="{{ old('first_name') }}" />
                    <x-form-field name="last_name" label="Last Name" required value="{{ old('last_name') }}" />
                </div>

                <x-form-field name="email" label="Email" type="email" required value="{{ old('email') }}" />

                <x-form-field name="password" label="Password" type="password" required />

                <x-form-field name="password_confirmation" label="Confirm Password" type="password" required />

                <button type="submit"
                    class="w-full py-2.5 rounded-lg bg-[var(--color-primary)] text-white text-sm font-medium hover:bg-[var(--color-primary-light)] transition">
                    Create Account
                </button>
            </form>
        </div>

        <p class="text-center text-sm text-[var(--color-text-secondary)] mt-6">
            Already have an account?
            <a href="{{ route('login') }}" class="text-[var(--color-primary)] font-medium hover:underline">Log in</a>
        </p>
    </div>

</body>
</html>