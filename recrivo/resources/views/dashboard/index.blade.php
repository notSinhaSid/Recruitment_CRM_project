<x-app-layout header="Dashboard">

    <div class="space-y-6">

        {{-- =========================
            PAGE HEADER
        ========================== --}}
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <div>
                <h2 class="text-2xl font-semibold text-[var(--color-text)]">
                    Dashboard
                </h2>

                <p class="mt-1 text-sm text-[var(--color-text-secondary)]">
                    Overview of your recruitment activity and application pipeline.
                </p>
            </div>

            <div class="flex flex-wrap items-center gap-2">

                <a
                    href="{{ route('candidates.index') }}"
                    class="inline-flex items-center justify-center gap-2 rounded-lg
                           border border-[var(--color-border)]
                           bg-[var(--color-card)]
                           px-4 py-2
                           text-sm font-medium
                           text-[var(--color-text)]
                           transition-all duration-200
                           hover:-translate-y-0.5
                           hover:border-[var(--color-primary)]
                           hover:text-[var(--color-primary)]
                           hover:shadow-sm"
                >
                    <span>View Candidates</span>
                    <span>→</span>
                </a>

                <a
                    href="{{ route('job-postings.index') }}"
                    class="inline-flex items-center justify-center gap-2 rounded-lg
                           bg-[var(--color-primary)]
                           px-4 py-2
                           text-sm font-medium
                           text-white
                           transition-all duration-200
                           hover:-translate-y-0.5
                           hover:opacity-90
                           hover:shadow-md"
                >
                    <span>Job Postings</span>
                    <span>+</span>
                </a>

            </div>

        </div>


        {{-- =========================
            OVERVIEW STATS
        ========================== --}}
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-3">

            {{-- Candidates --}}
            <a
                href="{{ route('candidates.index') }}"
                class="group rounded-xl
                       border border-[var(--color-border)]
                       bg-[var(--color-card)]
                       p-5
                       transition-all duration-200
                       hover:-translate-y-1
                       hover:border-[var(--color-primary)]
                       hover:shadow-lg"
            >

                <div class="flex items-start justify-between">

                    <div>

                        <p class="text-sm font-medium text-[var(--color-text-secondary)]">
                            Total Candidates
                        </p>

                        <p class="mt-2 text-3xl font-semibold text-[var(--color-text)]">
                            {{ $counts['candidates'] }}
                        </p>

                    </div>

                    <div
                        class="flex h-11 w-11 items-center justify-center rounded-xl
                               bg-[var(--color-primary)]/10
                               text-lg
                               transition-transform duration-200
                               group-hover:scale-110"
                    >
                        👤
                    </div>

                </div>

                <div class="mt-5 flex items-center justify-between">

                    <span class="text-xs text-[var(--color-text-secondary)]">
                        View all candidates
                    </span>

                    <span
                        class="text-sm text-[var(--color-primary)]
                               transition-transform duration-200
                               group-hover:translate-x-1"
                    >
                        →
                    </span>

                </div>

            </a>


            {{-- Job Postings --}}
            <a
                href="{{ route('job-postings.index') }}"
                class="group rounded-xl
                       border border-[var(--color-border)]
                       bg-[var(--color-card)]
                       p-5
                       transition-all duration-200
                       hover:-translate-y-1
                       hover:border-[var(--color-primary)]
                       hover:shadow-lg"
            >

                <div class="flex items-start justify-between">

                    <div>

                        <p class="text-sm font-medium text-[var(--color-text-secondary)]">
                            Job Postings
                        </p>

                        <p class="mt-2 text-3xl font-semibold text-[var(--color-text)]">
                            {{ $counts['job_postings'] }}
                        </p>

                    </div>

                    <div
                        class="flex h-11 w-11 items-center justify-center rounded-xl
                               bg-emerald-500/10
                               text-lg
                               transition-transform duration-200
                               group-hover:scale-110"
                    >
                        💼
                    </div>

                </div>

                <div class="mt-5 flex items-center justify-between">

                    <span class="text-xs text-[var(--color-text-secondary)]">
                        Manage job postings
                    </span>

                    <span
                        class="text-sm text-[var(--color-primary)]
                               transition-transform duration-200
                               group-hover:translate-x-1"
                    >
                        →
                    </span>

                </div>

            </a>


            {{-- Applications --}}
            <a
                href="{{ route('applications.index') }}"
                class="group rounded-xl
                       border border-[var(--color-border)]
                       bg-[var(--color-card)]
                       p-5
                       transition-all duration-200
                       hover:-translate-y-1
                       hover:border-[var(--color-primary)]
                       hover:shadow-lg"
            >

                <div class="flex items-start justify-between">

                    <div>

                        <p class="text-sm font-medium text-[var(--color-text-secondary)]">
                            Applications
                        </p>

                        <p class="mt-2 text-3xl font-semibold text-[var(--color-text)]">
                            {{ $counts['applications'] }}
                        </p>

                    </div>

                    <div
                        class="flex h-11 w-11 items-center justify-center rounded-xl
                               bg-amber-500/10
                               text-lg
                               transition-transform duration-200
                               group-hover:scale-110"
                    >
                        📄
                    </div>

                </div>

                <div class="mt-5 flex items-center justify-between">

                    <span class="text-xs text-[var(--color-text-secondary)]">
                        Review applications
                    </span>

                    <span
                        class="text-sm text-[var(--color-primary)]
                               transition-transform duration-200
                               group-hover:translate-x-1"
                    >
                        →
                    </span>

                </div>

            </a>

        </div>


        {{-- =========================
            APPLICATION PIPELINE
        ========================== --}}
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-5">

            {{-- Stage Breakdown --}}
            <div
                class="lg:col-span-3 overflow-hidden rounded-xl
                       border border-[var(--color-border)]
                       bg-[var(--color-card)]"
            >

                {{-- Card Header --}}
                <div
                    class="flex flex-col gap-3
                           border-b border-[var(--color-border)]
                           p-5 sm:flex-row sm:items-center sm:justify-between"
                >

                    <div>

                        <h3 class="text-base font-semibold text-[var(--color-text)]">
                            Applications by Stage
                        </h3>

                        <p class="mt-1 text-xs text-[var(--color-text-secondary)]">
                            Current application pipeline
                        </p>

                    </div>

                    <a
                        href="{{ route('applications.index') }}"
                        class="text-sm font-medium text-[var(--color-primary)]
                               hover:underline"
                    >
                        View applications →
                    </a>

                </div>


                {{-- Stage Content --}}
                <div class="p-5">

                    @php
                        $allStages = ['applied', 'screening', 'interview', 'offer', 'hired', 'on_hold', 'rejected'];
                        $breakdown = collect($stageBreakdown);
                        $hasAny = $breakdown->sum() > 0;
                    @endphp

                    @if ($hasAny)

                        <div class="grid grid-cols-2 gap-3 sm:grid-cols-3 xl:grid-cols-4">

                            @foreach ($allStages as $stage)

                                @php $total = $breakdown[$stage] ?? 0; @endphp

                                <div
                                    class="rounded-lg border border-[var(--color-border)] p-3
                                           {{ $total === 0 ? 'opacity-40' : '' }}"
                                >
                                    <x-badge :status="$stage" />
                                    <p class="mt-2 text-xl font-semibold text-[var(--color-text)]">
                                        {{ $total }}
                                    </p>
                                </div>

                            @endforeach

                        </div>

                    @else

                        <div class="flex min-h-40 items-center justify-center">

                            <div class="text-center">

                                <div class="text-3xl">
                                    📋
                                </div>

                                <p
                                    class="mt-2 text-sm font-medium
                                           text-[var(--color-text)]"
                                >
                                    No applications yet
                                </p>

                                <p
                                    class="mt-1 text-xs
                                           text-[var(--color-text-secondary)]"
                                >
                                    Applications will appear here once candidates apply.
                                </p>

                            </div>

                        </div>

                    @endif

                </div>

            </div>


            {{-- Quick Actions --}}
            <div
                class="lg:col-span-2 overflow-hidden rounded-xl
                       border border-[var(--color-border)]
                       bg-[var(--color-card)]"
            >

                <div
                    class="border-b border-[var(--color-border)]
                           p-5"
                >

                    <h3 class="text-base font-semibold text-[var(--color-text)]">
                        Quick Actions
                    </h3>

                    <p class="mt-1 text-xs text-[var(--color-text-secondary)]">
                        Frequently used recruitment actions
                    </p>

                </div>


                <div class="space-y-2 p-4">

                    {{-- Candidates --}}
                    <a
                        href="{{ route('candidates.index') }}"
                        class="group flex items-center gap-3 rounded-lg p-3
                               transition-all duration-200
                               hover:bg-[var(--color-bg)]"
                    >

                        <div
                            class="flex h-10 w-10 shrink-0 items-center justify-center
                                   rounded-lg
                                   bg-[var(--color-primary)]/10"
                        >
                            👤
                        </div>

                        <div class="min-w-0 flex-1">

                            <p
                                class="text-sm font-medium
                                       text-[var(--color-text)]"
                            >
                                Candidates
                            </p>

                            <p
                                class="mt-0.5 text-xs
                                       text-[var(--color-text-secondary)]"
                            >
                                Manage candidate profiles
                            </p>

                        </div>

                        <span
                            class="text-[var(--color-text-secondary)]
                                   transition-transform duration-200
                                   group-hover:translate-x-1"
                        >
                            →
                        </span>

                    </a>


                    {{-- Job Postings --}}
                    <a
                        href="{{ route('job-postings.index') }}"
                        class="group flex items-center gap-3 rounded-lg p-3
                               transition-all duration-200
                               hover:bg-[var(--color-bg)]"
                    >

                        <div
                            class="flex h-10 w-10 shrink-0 items-center justify-center
                                   rounded-lg
                                   bg-emerald-500/10"
                        >
                            💼
                        </div>

                        <div class="min-w-0 flex-1">

                            <p
                                class="text-sm font-medium
                                       text-[var(--color-text)]"
                            >
                                Job Postings
                            </p>

                            <p
                                class="mt-0.5 text-xs
                                       text-[var(--color-text-secondary)]"
                            >
                                Create and manage job openings
                            </p>

                        </div>

                        <span
                            class="text-[var(--color-text-secondary)]
                                   transition-transform duration-200
                                   group-hover:translate-x-1"
                        >
                            →
                        </span>

                    </a>


                    {{-- Applications --}}
                    <a
                        href="{{ route('applications.index') }}"
                        class="group flex items-center gap-3 rounded-lg p-3
                               transition-all duration-200
                               hover:bg-[var(--color-bg)]"
                    >

                        <div
                            class="flex h-10 w-10 shrink-0 items-center justify-center
                                   rounded-lg
                                   bg-amber-500/10"
                        >
                            📄
                        </div>

                        <div class="min-w-0 flex-1">

                            <p
                                class="text-sm font-medium
                                       text-[var(--color-text)]"
                            >
                                Applications
                            </p>

                            <p
                                class="mt-0.5 text-xs
                                       text-[var(--color-text-secondary)]"
                            >
                                Review candidate applications
                            </p>

                        </div>

                        <span
                            class="text-[var(--color-text-secondary)]
                                   transition-transform duration-200
                                   group-hover:translate-x-1"
                        >
                            →
                        </span>

                    </a>

                </div>

            </div>

        </div>



        {{-- =========================
            RECENT ACTIVITY
        ========================== --}}
        <div
            class="overflow-hidden rounded-xl
                   border border-[var(--color-border)]
                   bg-[var(--color-card)]"
        >

            {{-- Header --}}
            <div
                class="flex flex-col gap-3
                       border-b border-[var(--color-border)]
                       p-5 sm:flex-row sm:items-center sm:justify-between"
            >

                <div>

                    <h3 class="text-base font-semibold text-[var(--color-text)]">
                        Recent Activity
                    </h3>

                    <p class="mt-1 text-xs text-[var(--color-text-secondary)]">
                        Latest activity across your recruitment system
                    </p>

                </div>

                <a
                    href="{{ route('applications.index') }}"
                    class="text-sm font-medium text-[var(--color-primary)]
                           hover:underline"
                >
                    View all →
                </a>

            </div>

            {{-- Condensed activity feed --}}
            <div class="divide-y divide-[var(--color-border)]">

                @forelse ($recentActivity->take(6) as $log)

                    <div
                        class="flex items-center gap-3 px-5 py-3
                               transition-colors duration-200
                               hover:bg-[var(--color-bg)]"
                    >

                        <div
                            class="flex h-8 w-8 shrink-0 items-center justify-center
                                   rounded-full
                                   bg-[var(--color-primary)]/10
                                   text-xs font-semibold
                                   text-[var(--color-primary)]"
                        >
                            {{ strtoupper(substr($log->user->first_name ?? 'S', 0, 1)) }}
                        </div>

                        <p class="min-w-0 flex-1 truncate text-sm text-[var(--color-text)]">
                            <span class="font-medium">{{ $log->user->first_name ?? 'System' }}</span>
                            {{ strtolower($log->action) }} a
                            <span class="text-[var(--color-text-secondary)]">{{ class_basename($log->auditable_type) }}</span>
                        </p>

                        <span class="shrink-0 text-xs text-[var(--color-text-secondary)]">
                            {{ $log->created_at->diffForHumans() }}
                        </span>

                    </div>

                @empty

                    <div class="px-5 py-12 text-center">

                        <div class="text-3xl">
                            🕒
                        </div>

                        <p class="mt-2 text-sm font-medium text-[var(--color-text)]">
                            No recent activity
                        </p>

                        <p class="mt-1 text-xs text-[var(--color-text-secondary)]">
                            Activity will appear here when actions are performed.
                        </p>

                    </div>

                @endforelse

            </div>

        </div>

    </div>

</x-app-layout>
