<x-app-layout>
    <x-slot name="header">
        <h1 class="text-xl font-semibold text-[#1F2937]">Dashboard</h1>
    </x-slot>

    <div class="space-y-8">

        {{-- Stat Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
            <div class="bg-white rounded-xl border border-[#E4E8EB] p-5 shadow-sm hover:shadow-md transition-shadow">
                <p class="text-sm text-[#6B7684]">Candidates</p>
                <p class="mt-2 text-3xl font-semibold text-[#1F2937]">{{ $counts['candidates'] }}</p>
            </div>
            <div class="bg-white rounded-xl border border-[#E4E8EB] p-5 shadow-sm hover:shadow-md transition-shadow">
                <p class="text-sm text-[#6B7684]">Job Postings</p>
                <p class="mt-2 text-3xl font-semibold text-[#1F2937]">{{ $counts['job_postings'] }}</p>
            </div>
            <div class="bg-white rounded-xl border border-[#E4E8EB] p-5 shadow-sm hover:shadow-md transition-shadow">
                <p class="text-sm text-[#6B7684]">Applications</p>
                <p class="mt-2 text-3xl font-semibold text-[#1F2937]">{{ $counts['applications'] }}</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- Stage Breakdown --}}
            <div class="lg:col-span-2 bg-white rounded-xl border border-[#E4E8EB] p-6 shadow-sm">
                <h2 class="text-base font-semibold text-[#1F2937] mb-5">Applications by Stage</h2>

                @php
                    $stageOrder = ['applied', 'screening', 'interview', 'offer', 'hired', 'on_hold', 'rejected'];
                    $maxCount = $stageBreakdown->max() ?: 1;
                @endphp

                @if ($stageBreakdown->isEmpty())
                    <p class="text-sm text-[#6B7684]">No applications yet.</p>
                @else
                    <div class="space-y-4">
                        @foreach ($stageOrder as $stage)
                            @php
                                $total = $stageBreakdown[$stage] ?? 0;
                                $pct = $maxCount > 0 ? round(($total / $maxCount) * 100) : 0;
                            @endphp
                            <div>
                                <div class="flex items-center justify-between mb-1.5">
                                    <x-badge :status="$stage" />
                                    <span class="text-sm font-medium text-[#1F2937]">{{ $total }}</span>
                                </div>
                                <div class="h-2 rounded-full bg-[#F7F8F9] overflow-hidden">
                                    <div
                                        class="h-full rounded-full transition-all
                                            @if($stage === 'hired' || $stage === 'offer') bg-[#FFC078]
                                            @elseif($stage === 'rejected') bg-[#D4634A]
                                            @else bg-[#3B4A5A]
                                            @endif"
                                        style="width: {{ $pct }}%"
                                    ></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Recent Activity --}}
            <div class="bg-white rounded-xl border border-[#E4E8EB] p-6 shadow-sm">
                <h2 class="text-base font-semibold text-[#1F2937] mb-5">Recent Activity</h2>

                <div class="space-y-4">
                    @forelse ($recentActivity as $log)
                        <div class="flex gap-3 text-sm">
                            <div class="w-1.5 h-1.5 rounded-full bg-[#5A6B7A] mt-2 flex-shrink-0"></div>
                            <div>
                                <p class="text-[#1F2937]">
                                    <span class="font-medium">{{ $log->user->first_name ?? 'System' }} {{ $log->user->last_name ?? '' }}</span>
                                    {{ strtolower($log->action) }} a
                                    {{ class_basename($log->auditable_type) }}
                                </p>
                                <p class="text-xs text-[#6B7684] mt-0.5">
                                    {{ $log->created_at->diffForHumans() }}
                                </p>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-[#6B7684]">No activity yet.</p>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</x-app-layout>