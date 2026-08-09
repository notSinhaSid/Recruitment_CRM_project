<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Recrivo' }}</title>

    <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="any">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    @vite('resources/css/app.css')
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet">
    <style>
        .ql-toolbar.ql-snow {
            border-color: var(--color-border);
            border-radius: 0.5rem 0.5rem 0 0;
            background: var(--color-card);
        }
        .ql-container.ql-snow {
            border-color: var(--color-border);
            border-radius: 0 0 0.5rem 0.5rem;
            font-family: 'Inter', sans-serif;
            font-size: 0.875rem;
            min-height: 120px;
        }
        .ql-editor { color: var(--color-text); min-height: 120px; }
        .ql-snow .ql-stroke { stroke: var(--color-text-secondary); }
        .ql-snow .ql-fill { fill: var(--color-text-secondary); }
        .ql-snow.ql-toolbar button:hover .ql-stroke,
        .ql-snow .ql-toolbar button.ql-active .ql-stroke { stroke: var(--color-primary); }
        .ql-snow.ql-toolbar button:hover .ql-fill,
        .ql-snow .ql-toolbar button.ql-active .ql-fill { fill: var(--color-primary); }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    @stack('scripts')
</head>
<body class="font-sans antialiased text-[var(--color-text)]">
    <div class="flex h-screen overflow-hidden">

        {{-- Sidebar --}}
        <aside class="w-64 shrink-0 h-screen bg-[var(--color-sidebar)] text-white flex flex-col overflow-y-auto shadow-[4px_0_16px_rgba(0,0,0,0.12)] relative z-10">
            <div class="h-16 flex items-center px-6 border-b border-white/10">
                <img src="{{ asset('images/recrivo-lockup-horizontal-white.png') }}" alt="Recrivo" class="h-9 w-auto object-contain">
            </div>

            @php $tenant = auth()->user()->tenant ?? null; @endphp
            <div class="flex items-center gap-3 px-4 py-4 border-b border-white/10">
                @if($tenant?->logo_path)
                    <img src="{{ Storage::url($tenant->logo_path) }}"
                         alt="{{ $tenant->name }}"
                         class="w-9 h-9 rounded-lg object-cover shrink-0 bg-white/10">
                @else
                    <div class="w-9 h-9 rounded-lg bg-white/10 flex items-center justify-center shrink-0">
                        <span class="text-white font-semibold text-sm">
                            {{ strtoupper(substr($tenant->name ?? 'R', 0, 1)) }}
                        </span>
                    </div>
                @endif
                <div class="min-w-0">
                    <p class="text-white text-sm font-medium truncate">{{ $tenant->name ?? 'Your company' }}</p>
                    <p class="text-white/50 text-xs truncate">Workspace</p>
                </div>
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
                @php
                    $routeName = request()->route()?->getName() ?? '';
                    $prefix = explode('.', $routeName)[0] ?? '';
                    $action = explode('.', $routeName)[1] ?? 'index';

                    $sections = [
                        'dashboard' => ['label' => 'Dashboard', 'route' => 'dashboard'],
                        'applications' => ['label' => 'Pipeline', 'route' => 'applications.index'],
                        'candidates' => ['label' => 'Candidates', 'route' => 'candidates.index'],
                        'job-postings' => ['label' => 'Job Postings', 'route' => 'job-postings.index'],
                        'companies' => ['label' => 'Companies', 'route' => 'companies.index'],
                        'profile' => ['label' => 'Profile', 'route' => 'profile.edit'],
                    ];

                    $section = $sections[$prefix] ?? null;
                    $showLeaf = $section && $action !== 'index' && ($header ?? '') !== $section['label'];
                @endphp

                <nav class="flex items-center gap-2 min-w-0">
                    @if ($section)
                        <a href="{{ route($section['route']) }}"
                           class="text-sm truncate transition
                                  {{ $showLeaf ? 'text-[var(--color-text-secondary)] hover:text-[var(--color-text)] font-medium' : 'text-[var(--color-text)] font-semibold' }}">
                            {{ $section['label'] }}
                        </a>
                        @if ($showLeaf)
                            <span class="text-[var(--color-text-secondary)]/50 text-sm">/</span>
                            <span class="text-sm font-semibold text-[var(--color-text)] truncate">{{ $header ?? '' }}</span>
                        @endif
                    @else
                        <h1 class="text-lg font-semibold text-[var(--color-text)]">{{ $header ?? '' }}</h1>
                    @endif
                </nav>

                <div class="flex items-center gap-3">
                    <a href="{{ route('profile.edit') }}" class="flex items-center gap-1.5 text-sm text-[var(--color-text-secondary)] hover:text-[var(--color-text)] transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                        </svg>
                        {{ auth()->user()->first_name ?? auth()->user()->name ?? '' }}
                    </a>
                </div>
            </header>

            <main class="flex-1 p-8 relative bg-[var(--color-bg)]">
                <div
                    class="pointer-events-none absolute inset-0"
                    style="
                        background-image:
                            radial-gradient(circle at 15% 0%, color-mix(in srgb, var(--color-primary) 6%, transparent) 0%, transparent 45%),
                            radial-gradient(circle at 100% 100%, color-mix(in srgb, var(--color-amber) 5%, transparent) 0%, transparent 50%),
                            radial-gradient(circle, color-mix(in srgb, var(--color-primary) 6%, transparent) 1px, transparent 1px);
                        background-size: auto, auto, 22px 22px;
                    "
                ></div>

                <div class="relative">
                    <x-toast />

                    {{ $slot }}
                </div>
            </main>
        </div>
    </div>
</body>
</html>