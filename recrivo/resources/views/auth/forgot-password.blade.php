<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Forgot Password — Recrivo</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    @vite('resources/css/app.css')
</head>
<body class="font-sans antialiased min-h-screen flex">

    {{-- Left: brand panel --}}
    <div class="hidden lg:flex lg:w-1/2 relative overflow-hidden bg-[var(--color-sidebar)]">

        <div class="absolute inset-0 opacity-40" style="background: radial-gradient(circle at 25% 25%, var(--color-primary-light) 0%, transparent 45%), radial-gradient(circle at 75% 70%, var(--color-primary) 0%, transparent 50%);"></div>

        <svg class="absolute inset-0 w-full h-full opacity-20" viewBox="0 0 600 800" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle cx="470" cy="170" r="4" fill="var(--color-amber)"/>
            <circle cx="140" cy="610" r="5" fill="var(--color-amber)"/>
            <circle cx="100" cy="220" r="3" fill="white"/>
            <circle cx="510" cy="510" r="4" fill="white"/>
            <path d="M100 220 Q 260 280 470 170" stroke="white" stroke-width="1" fill="none"/>
            <path d="M140 610 Q 320 550 510 510" stroke="white" stroke-width="1" fill="none"/>
            <circle cx="300" cy="400" r="145" stroke="white" stroke-width="1" fill="none"/>
            <circle cx="300" cy="400" r="225" stroke="white" stroke-width="1" fill="none"/>
        </svg>

        <div class="relative z-10 flex flex-col justify-center px-16 text-white">
            <div class="flex items-center gap-3 mb-10">
                <div class="w-11 h-11 rounded-xl bg-white/10 flex items-center justify-center">
                    <span class="text-xl font-bold">R</span>
                </div>
                <span class="text-2xl font-semibold tracking-tight">Recrivo</span>
            </div>

            <h1 class="text-4xl font-bold leading-tight mb-4">
                Locked out?<br>Let's fix that.
            </h1>
            <p class="text-white/60 text-base max-w-sm">
                Enter your email and we'll send you a secure link to reset your password.
            </p>
        </div>
    </div>

    {{-- Right: form --}}
    <div class="w-full lg:w-1/2 flex items-center justify-center px-6 py-12 bg-[var(--color-bg)]">
        <div class="w-full max-w-sm">

            <div class="lg:hidden text-center mb-8">
                <span class="text-2xl font-semibold tracking-tight text-[var(--color-primary)]">Recrivo</span>
            </div>

            <h2 class="text-2xl font-semibold text-[var(--color-text)] mb-1">Forgot your password?</h2>
            <p class="text-sm text-[var(--color-text-secondary)] mb-8">We'll email you a link to reset it.</p>

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

            <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
                @csrf

                <x-form-field name="email" label="Email" type="email" required autofocus value="{{ old('email') }}" />

                <button type="submit"
                    class="w-full py-3 rounded-lg text-white text-sm font-semibold transition shadow-sm hover:shadow-md"
                    style="background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-primary-light) 100%);">
                    Send Reset Link
                </button>
            </form>

            <p class="text-center text-sm text-[var(--color-text-secondary)] mt-8">
                Remembered it?
                <a href="{{ route('login') }}" class="text-[var(--color-primary)] font-medium hover:underline">Back to login</a>
            </p>
        </div>
    </div>

</body>
</html>
