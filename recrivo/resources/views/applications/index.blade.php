<x-app-layout header="Pipeline">

    <div
        x-data="{
            error: null,
            dragging: null,

            onDrop(newStage, event) {
                const appId = event.dataTransfer.getData('text/plain');
                if (!appId) return;

                this.error = null;
                const card = document.getElementById('app-card-' + appId);
                const url = card?.dataset.transitionUrl;
                if (!url) return;

                fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({ stage: newStage }),
                })
                .then(async (response) => {
                    const data = await response.json();
                    if (!response.ok) {
                        throw new Error(data.error || 'Transition failed.');
                    }
                    window.location.reload();
                })
                .catch((err) => {
                    this.error = err.message;
                    setTimeout(() => this.error = null, 4000);
                });
            }
        }"
        class="h-full"
    >
        <div class="flex items-center justify-between mb-6">
            <p class="text-sm text-[var(--color-text-secondary)]">
                Drag a card to move it forward, put it on hold, or reject it.
            </p>
            <a href="{{ route('applications.create') }}"
               class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-[var(--color-primary)] text-white text-sm font-medium hover:bg-[var(--color-primary-light)] transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 5v14M5 12h14" />
                </svg>
                New Application
            </a>
        </div>

        <div x-show="error" x-transition x-text="error"
             class="mb-4 rounded-lg border border-[var(--color-coral)]/30 bg-[var(--color-coral)]/5 px-4 py-3 text-sm text-[var(--color-coral)]"></div>

        <div class="flex gap-4 overflow-x-auto pb-4">
            @php
                $stages = [
                    'applied' => 'Applied',
                    'screening' => 'Screening',
                    'interview' => 'Interview',
                    'offer' => 'Offer',
                    'hired' => 'Hired',
                    'on_hold' => 'On Hold',
                    'rejected' => 'Rejected',
                ];
            @endphp

            @foreach ($stages as $key => $label)
                <div
                    class="flex-shrink-0 w-72 bg-[var(--color-bg)] border border-[var(--color-border)] rounded-xl"
                    @dragover.prevent
                    @drop.prevent="onDrop('{{ $key }}', $event)"
                >
                    <div class="flex items-center justify-between px-4 py-3 border-b border-[var(--color-border)]">
                        <h3 class="text-sm font-semibold text-[var(--color-text)]">{{ $label }}</h3>
                        <span class="text-xs font-medium text-[var(--color-text-secondary)] bg-white border border-[var(--color-border)] rounded-full px-2 py-0.5">
                            {{ ($applicationsByStage[$key] ?? collect())->count() }}
                        </span>
                    </div>

                    <div class="p-3 space-y-3 min-h-[120px]">
                        @forelse ($applicationsByStage[$key] ?? [] as $application)
                            <div
                                id="app-card-{{ $application->id }}"
                                draggable="true"
                                @dragstart="$event.dataTransfer.setData('text/plain', '{{ $application->id }}')"
                                data-transition-url="{{ route('applications.transition', $application) }}"
                                class="bg-[var(--color-card)] border border-[var(--color-border)] rounded-lg p-3 cursor-grab active:cursor-grabbing hover:shadow-sm transition"
                            >
                                <a href="{{ route('applications.show', $application) }}" class="block">
                                    <p class="text-sm font-medium text-[var(--color-text)]">
                                        {{ $application->candidate->first_name }} {{ $application->candidate->last_name }}
                                    </p>
                                    <p class="text-xs text-[var(--color-text-secondary)] mt-1">
                                        {{ $application->jobPosting->title }}
                                    </p>
                                    <p class="text-xs text-[var(--color-text-secondary)] mt-2">
                                        {{ $application->applied_at?->format('M j, Y') ?? '—' }}
                                    </p>
                                </a>
                            </div>
                        @empty
                            <p class="text-xs text-[var(--color-text-secondary)] text-center py-6">No applications</p>
                        @endforelse
                    </div>
                </div>
            @endforeach
        </div>
    </div>

</x-app-layout>