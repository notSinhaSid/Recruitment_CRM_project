<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Log in — Recrivo</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    @vite('resources/css/app.css')
</head>
<body class="font-sans antialiased min-h-screen flex">

    {{-- Left: brand panel --}}
    <div class="hidden lg:flex lg:w-1/2 relative overflow-hidden bg-[var(--color-sidebar)]">

        <div class="absolute inset-0 opacity-40" style="background: radial-gradient(circle at 20% 20%, var(--color-primary-light) 0%, transparent 45%), radial-gradient(circle at 80% 70%, var(--color-primary) 0%, transparent 50%);"></div>

        <svg class="absolute inset-0 w-full h-full opacity-20" viewBox="0 0 600 800" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle cx="480" cy="150" r="4" fill="var(--color-amber)"/>
            <circle cx="120" cy="620" r="5" fill="var(--color-amber)"/>
            <circle cx="90" cy="200" r="3" fill="white"/>
            <circle cx="540" cy="520" r="4" fill="white"/>
            <path d="M90 200 Q 250 260 480 150" stroke="white" stroke-width="1" fill="none"/>
            <path d="M120 620 Q 320 560 540 520" stroke="white" stroke-width="1" fill="none"/>
            <circle cx="300" cy="400" r="140" stroke="white" stroke-width="1" fill="none"/>
            <circle cx="300" cy="400" r="220" stroke="white" stroke-width="1" fill="none"/>
        </svg>

        <div class="relative z-10 flex flex-col justify-center px-16 text-white">
            <div class="mb-10">
                <img src="{{ asset('images/recrivo-lockup-horizontal-white.png') }}" alt="Recrivo" class="h-10 w-auto">
            </div>

            <h1 class="text-4xl font-bold leading-tight mb-4">
                Welcome back to<br>your pipeline.
            </h1>
            <p class="text-white/60 text-base max-w-sm">
                Sign in to manage candidates, job postings, and applications across your recruitment workspace.
            </p>
        </div>
    </div>

    {{-- Right: form --}}
    <div class="w-full lg:w-1/2 flex items-center justify-center px-6 py-12 bg-[var(--color-bg)]">
        <div class="w-full max-w-sm">

            <div class="lg:hidden text-center mb-8">
                <img src="{{ asset('images/recrivo-lockup-horizontal-black.png') }}" alt="Recrivo" class="h-9 w-auto mx-auto">
            </div>

            <h2 class="text-2xl font-semibold text-[var(--color-text)] mb-1">Log in to your account</h2>
            <p class="text-sm text-[var(--color-text-secondary)] mb-8">Please sign in to continue.</p>

            @if (session('success'))
                <div class="mb-6 rounded-lg border border-[var(--color-border)] bg-white px-4 py-3">
                    <p class="text-sm text-[var(--color-text)]">{{ session('success') }}</p>
                </div>
            @endif

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

                <div class="flex items-center justify-between">
                    <label class="flex items-center gap-2 text-sm text-[var(--color-text-secondary)]">
                        <input type="checkbox" name="remember"
                            class="rounded border-[var(--color-border)] text-[var(--color-primary)] focus:ring-[var(--color-primary)]/30">
                        Remember me
                    </label>
                    <a href="{{ route('password.request') }}" class="text-sm font-medium text-[var(--color-primary)] hover:underline">Forgot password?</a>
                </div>

                <button type="submit"
                    class="w-full py-3 rounded-lg text-white text-sm font-semibold transition shadow-sm hover:shadow-md"
                    style="background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-primary-light) 100%);">
                    Log in
                </button>
            </form>

            <p class="text-center text-sm text-[var(--color-text-secondary)] mt-8">
                No account?
                <a href="{{ route('register') }}" class="text-[var(--color-primary)] font-medium hover:underline">Register</a>
            </p>
        </div>
    </div>

</body>
</html>