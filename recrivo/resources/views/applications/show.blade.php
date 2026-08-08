<x-app-layout header="Application Details">

    <div class="max-w-2xl">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-2xl font-semibold text-[var(--color-text)]">
                    {{ $application->candidate->first_name }} {{ $application->candidate->last_name }}
                </h2>
                <p class="text-sm text-[var(--color-text-secondary)] mt-1">
                    <a href="{{ route('job-postings.show', $application->jobPosting) }}" class="hover:text-[var(--color-primary)] transition">
                        {{ $application->jobPosting->title }}
                    </a>
                </p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('applications.edit', $application) }}"
                    class="px-4 py-2 rounded-lg border border-[var(--color-border)] text-sm font-medium text-[var(--color-text)] hover:bg-[var(--color-bg)] transition">
                    Edit
                </a>
                <a href="{{ route('applications.index') }}"
                    class="px-4 py-2 rounded-lg text-sm font-medium text-[var(--color-text-secondary)] hover:text-[var(--color-text)] transition">
                    Back to pipeline
                </a>
            </div>
        </div>

        <div class="bg-[var(--color-card)] border border-[var(--color-border)] rounded-xl p-8">
            <dl class="grid grid-cols-2 gap-x-8 gap-y-6 mb-6">
                <div>
                    <dt class="text-xs font-medium uppercase tracking-wide text-[var(--color-text-secondary)]">Candidate</dt>
                    <dd class="mt-1 text-sm">
                        <a href="{{ route('candidates.show', $application->candidate) }}" class="text-[var(--color-primary)] hover:underline">
                            {{ $application->candidate->first_name }} {{ $application->candidate->last_name }}
                        </a>
                    </dd>
                </div>

                <div>
                    <dt class="text-xs font-medium uppercase tracking-wide text-[var(--color-text-secondary)]">Applied At</dt>
                    <dd class="mt-1 text-sm text-[var(--color-text)]">{{ $application->applied_at?->format('M j, Y') ?? '—' }}</dd>
                </div>
            </dl>

            <div
                x-data="{
                    stage: '{{ $application->stage }}',
                    previousStage: {{ $application->previous_stage ? "'{$application->previous_stage}'" : 'null' }},
                    loading: false,
                    error: null,

                    transition(newStage) {
                        this.loading = true;
                        this.error = null;

                        fetch('{{ route('applications.transition', $application) }}', {
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
                            this.stage = data.stage;
                            this.previousStage = data.previous_stage;
                        })
                        .catch((err) => {
                            this.error = err.message;
                        })
                        .finally(() => {
                            this.loading = false;
                        });
                    }
                }"
                class="border-t border-[var(--color-border)] pt-6"
            >
                <div class="flex items-center gap-3 mb-4">
                    <span class="text-xs font-medium uppercase tracking-wide text-[var(--color-text-secondary)]">Current Stage</span>
                    <span
                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border"
                        :class="{
                            'bg-[#FFC078]/20 text-[#8a5a1f] border-[#FFC078]/40': ['offer', 'hired'].includes(stage),
                            'bg-[#D4634A]/10 text-[#D4634A] border-[#D4634A]/30': stage === 'rejected',
                            'bg-[var(--color-border)] text-[var(--color-text-secondary)] border-[var(--color-border)]': !['offer', 'hired', 'rejected'].includes(stage),
                        }"
                        x-text="stage.charAt(0).toUpperCase() + stage.slice(1).replace('_', ' ')"
                    ></span>
                </div>

                <div x-show="error" x-transition x-text="error"
                     class="mb-4 rounded-lg border border-[var(--color-coral)]/30 bg-[var(--color-coral)]/5 px-4 py-2.5 text-sm text-[var(--color-coral)]"></div>

                <div x-show="loading" class="mb-4 text-sm text-[var(--color-text-secondary)]">Updating...</div>

                <div class="flex flex-wrap gap-2">
                    <template x-if="stage === 'applied'">
                        <button @click="transition('screening')" :disabled="loading"
                            class="px-4 py-2 rounded-lg bg-[var(--color-primary)] text-white text-sm font-medium hover:bg-[var(--color-primary-light)] transition disabled:opacity-50">
                            Move to Screening
                        </button>
                    </template>
                    <template x-if="stage === 'screening'">
                        <button @click="transition('interview')" :disabled="loading"
                            class="px-4 py-2 rounded-lg bg-[var(--color-primary)] text-white text-sm font-medium hover:bg-[var(--color-primary-light)] transition disabled:opacity-50">
                            Move to Interview
                        </button>
                    </template>
                    <template x-if="stage === 'interview'">
                        <button @click="transition('offer')" :disabled="loading"
                            class="px-4 py-2 rounded-lg bg-[var(--color-primary)] text-white text-sm font-medium hover:bg-[var(--color-primary-light)] transition disabled:opacity-50">
                            Move to Offer
                        </button>
                    </template>
                    <template x-if="stage === 'offer'">
                        <button @click="transition('hired')" :disabled="loading"
                            class="px-4 py-2 rounded-lg bg-[var(--color-primary)] text-white text-sm font-medium hover:bg-[var(--color-primary-light)] transition disabled:opacity-50">
                            Mark Hired
                        </button>
                    </template>

                    <template x-if="!['hired', 'rejected', 'on_hold'].includes(stage)">
                        <button @click="transition('on_hold')" :disabled="loading"
                            class="px-4 py-2 rounded-lg border border-[var(--color-border)] text-sm font-medium text-[var(--color-text)] hover:bg-[var(--color-bg)] transition disabled:opacity-50">
                            Put On Hold
                        </button>
                    </template>

                    <template x-if="stage === 'on_hold'">
                        <button @click="transition(previousStage)" :disabled="loading"
                            class="px-4 py-2 rounded-lg border border-[var(--color-border)] text-sm font-medium text-[var(--color-text)] hover:bg-[var(--color-bg)] transition disabled:opacity-50">
                            Resume (back to <span x-text="previousStage"></span>)
                        </button>
                    </template>

                    <template x-if="!['hired', 'rejected'].includes(stage)">
                        <button @click="transition('rejected')" :disabled="loading"
                            class="px-4 py-2 rounded-lg text-sm font-medium text-[var(--color-coral)] hover:bg-[var(--color-coral)]/5 transition disabled:opacity-50">
                            Reject
                        </button>
                    </template>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>