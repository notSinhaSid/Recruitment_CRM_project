<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Recrivo' }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    @vite('resources/css/app.css')
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>
<body class="font-sans antialiased text-[var(--color-text)]">
    <div class="flex h-screen overflow-hidden">

        {{-- Sidebar --}}
        <aside class="w-64 shrink-0 h-screen bg-[var(--color-sidebar)] text-white flex flex-col overflow-y-auto shadow-[4px_0_16px_rgba(0,0,0,0.12)] relative z-10">
            <div class="h-16 flex items-center px-6 border-b border-white/10">
                <span class="text-lg font-semibold tracking-tight">Recrivo</span>
            </div>

            <nav class="flex-1 px-3 py-4 space-y-1">
                <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                    <x-icon.home class="w-5 h-5" />
                    Dashboard
                </x-nav-link>

                <x-nav-link :href="route('applications.index')" :active="request()->routeIs('applications.*')">
                    <x-icon.pipeline class="w-5 h-5" />
                    Pipeline
                </x-nav-link>

                <x-nav-link :href="route('candidates.index')" :active="request()->routeIs('candidates.*')">
                    <x-icon.users class="w-5 h-5" />
                    Candidates
                </x-nav-link>

                <x-nav-link :href="route('job-postings.index')" :active="request()->routeIs('job-postings.*')">
                    <x-icon.briefcase class="w-5 h-5" />
                    Job Postings
                </x-nav-link>

                <x-nav-link :href="route('companies.index')" :active="request()->routeIs('companies.*')">
                    <x-icon.building class="w-5 h-5" />
                    Companies
                </x-nav-link>
            </nav>

            <div class="px-3 py-4 border-t border-white/10">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/70 hover:text-white hover:bg-white/5 transition">
                        <x-icon.logout class="w-5 h-5" />
                        Log out
                    </button>
                </form>
            </div>
        </aside>

        {{-- Main --}}
        <div class="flex-1 flex flex-col min-w-0 h-screen overflow-y-auto">
            <header class="h-16 shrink-0 bg-[var(--color-card)] border-b border-[var(--color-border)] flex items-center justify-between px-8 shadow-[0_2px_8px_rgba(0,0,0,0.04)] relative z-[5]">
                <h1 class="text-xl font-semibold text-[var(--color-text)]">{{ $header ?? '' }}</h1>
                <div class="flex items-center gap-3">
                    <a href="{{ route('profile.edit') }}" class="text-sm text-[var(--color-text-secondary)] hover:text-[var(--color-text)] transition">
                        {{ auth()->user()->first_name ?? auth()->user()->name ?? '' }}
                    </a>
                </div>
            </header>

            <main class="flex-1 p-8 bg-[var(--color-background)]">
                <x-toast />

                {{ $slot }}
            </main>
        </div>
    </div>
</body>
</html>