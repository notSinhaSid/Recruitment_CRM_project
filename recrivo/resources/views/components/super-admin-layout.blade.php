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
<body class="font-sans antialiased" style="background: var(--color-bg); color: var(--color-text);">
    <div class="min-h-screen flex">

        {{-- Sidebar: uses --color-sidebar (dark) to visually distinguish Super Admin
             context from the tenant app, without the whole page being dark. --}}
        <aside class="w-64 shrink-0 flex flex-col" style="background: var(--color-sidebar);">
            <div class="h-16 flex items-center gap-3 px-6" style="border-bottom: 1px solid rgba(255,255,255,0.08);">
                <div class="w-8 h-8 rounded-md flex items-center justify-center font-bold text-sm"
                     style="background: var(--color-primary); color: white;">
                    R
                </div>
                <div>
                    <p class="text-sm font-semibold leading-none text-white">Recrivo Platform</p>
                    <p class="text-[11px] leading-none mt-1 text-white/40">Super Admin</p>
                </div>
            </div>

            <nav class="flex-1 px-3 py-4 space-y-1">
                <a href="{{ route('super-admin.dashboard') }}"
                   class="flex items-center gap-2.5 px-3 py-2 rounded-md text-sm transition"
                   style="{{ request()->routeIs('super-admin.dashboard')
                        ? 'background: rgba(255,255,255,0.08); color: white; font-weight: 500;'
                        : 'color: rgba(255,255,255,0.55);' }}">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" />
                    </svg>
                    Dashboard
                </a>
                <a href="{{ route('super-admin.tenants') }}"
                   class="flex items-center gap-2.5 px-3 py-2 rounded-md text-sm transition"
                   style="{{ request()->routeIs('super-admin.tenants*')
                        ? 'background: rgba(255,255,255,0.08); color: white; font-weight: 500;'
                        : 'color: rgba(255,255,255,0.55);' }}">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21" />
                    </svg>
                    Tenants
                </a>
            </nav>

            <div class="px-3 py-4 space-y-1" style="border-top: 1px solid rgba(255,255,255,0.08);">
                <div class="px-3 py-2 text-xs text-white/40">{{ auth()->user()->first_name ?? '' }}</div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="w-full text-left px-3 py-2 rounded-md text-sm transition text-white/55 hover:text-white hover:bg-white/5">
                        Log out
                    </button>
                </form>
            </div>
        </aside>

        <div class="flex-1 min-w-0">
            <main class="px-8 py-8 max-w-6xl w-full mx-auto">
                @if (session('success'))
                    <div class="mb-6 rounded-lg px-4 py-3 text-sm"
                         style="background: rgba(59,74,90,0.06); border: 1px solid rgba(59,74,90,0.2); color: var(--color-primary);">
                        {{ session('success') }}
                    </div>
                @endif

                {{ $slot }}
            </main>
        </div>
    </div>

    @stack('scripts')
</body>
</html>