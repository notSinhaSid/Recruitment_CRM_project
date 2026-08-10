<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Super Admin — Recrivo' }}</title>

    <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="any">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    @vite('resources/css/app.css')
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>
<body class="font-sans antialiased text-white" style="background:#17181B;">
    <div class="min-h-screen flex flex-col">

        {{-- Top bar: deliberately distinct from tenant app-layout's left sidebar --}}
        <header class="h-16 shrink-0 flex items-center justify-between px-8 border-b border-white/10" style="background:#1F2023;">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-md flex items-center justify-center font-bold text-sm" style="background: var(--color-coral); color: white;">
                    R
                </div>
                <div>
                    <p class="text-sm font-semibold text-white leading-none">Recrivo Platform</p>
                    <p class="text-[11px] text-white/40 leading-none mt-1">Super Admin</p>
                </div>
            </div>

            <nav class="flex items-center gap-1">
                <a href="{{ route('super-admin.dashboard') }}"
                   class="px-3 py-1.5 rounded-md text-sm transition {{ request()->routeIs('super-admin.dashboard') ? 'text-white font-medium' : 'text-white/50 hover:text-white/80' }}"
                   style="{{ request()->routeIs('super-admin.dashboard') ? 'background: rgba(212,99,74,0.15);' : '' }}">
                    Dashboard
                </a>
                <a href="{{ route('super-admin.tenants') }}"
                   class="px-3 py-1.5 rounded-md text-sm transition {{ request()->routeIs('super-admin.tenants*') ? 'text-white font-medium' : 'text-white/50 hover:text-white/80' }}"
                   style="{{ request()->routeIs('super-admin.tenants*') ? 'background: rgba(212,99,74,0.15);' : '' }}">
                    Tenants
                </a>
            </nav>

            <div class="flex items-center gap-4">
                <span class="text-xs text-white/40">{{ auth()->user()->first_name ?? '' }}</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-xs text-white/50 hover:text-white transition">Log out</button>
                </form>
            </div>
        </header>

        <main class="flex-1 px-8 py-8 max-w-6xl w-full mx-auto">
            @if (session('success'))
                <div class="mb-6 rounded-lg border px-4 py-3 text-sm" style="background: rgba(212,99,74,0.08); border-color: rgba(212,99,74,0.25); color: #E8A697;">
                    {{ session('success') }}
                </div>
            @endif

            {{ $slot }}
        </main>
    </div>
</body>
</html>
