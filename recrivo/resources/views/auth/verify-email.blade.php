<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Verify Email — Recrivo</title>

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
                One last step.<br>Check your inbox.
            </h1>
            <p class="text-white/60 text-base max-w-sm">
                Verify your email to unlock your recruitment workspace.
            </p>
        </div>
    </div>

    {{-- Right: content --}}
    <div class="w-full lg:w-1/2 flex items-center justify-center px-6 py-12 bg-[var(--color-bg)]">
        <div class="w-full max-w-sm text-center">

            <div class="lg:hidden text-center mb-8">
                <span class="text-2xl font-semibold tracking-tight text-[var(--color-primary)]">Recrivo</span>
            </div>

            <div class="mx-auto w-14 h-14 rounded-full bg-[var(--color-amber)]/15 flex items-center justify-center mb-5">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-[#8a5a1f]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                </svg>
            </div>

            <h2 class="text-2xl font-semibold text-[var(--color-text)] mb-1">Verify your email</h2>
            <p class="text-sm text-[var(--color-text-secondary)] mb-8 leading-relaxed">
                We sent a verification link to<br>
                <span class="font-medium text-[var(--color-text)]">{{ auth()->user()->email }}</span>
            </p>

            @if (session('success'))
                <div class="mb-6 rounded-lg border border-[var(--color-border)] bg-white px-4 py-3">
                    <p class="text-sm text-[var(--color-text)]">{{ session('success') }}</p>
                </div>
            @endif

            @if (session('error'))
                <div class="mb-6 rounded-lg border border-[var(--color-coral)]/30 bg-[var(--color-coral)]/5 px-4 py-3">
                    <p class="text-sm text-[var(--color-coral)]">{{ session('error') }}</p>
                </div>
            @endif

            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit"
                    class="w-full py-3 rounded-lg text-white text-sm font-semibold transition shadow-sm hover:shadow-md"
                    style="background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-primary-light) 100%);">
                    Resend Verification Email
                </button>
            </form>

            <form method="POST" action="{{ route('logout') }}" class="mt-4">
                @csrf
                <button type="submit" class="text-sm text-[var(--color-text-secondary)] hover:text-[var(--color-text)] transition">
                    Log out
                </button>
            </form>
        </div>
    </div>

</body>
</html>
