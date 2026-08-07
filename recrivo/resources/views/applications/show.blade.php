<!DOCTYPE html>
<html>
<head><title>Application Details</title></head>
<body>
    <h1>Application Details</h1>

    <p><strong>Candidate:</strong>
        <a href="{{ route('candidates.show', $application->candidate) }}">
            {{ $application->candidate->first_name }} {{ $application->candidate->last_name }}
        </a>
    </p>
    <p><strong>Job Posting:</strong>
        <a href="{{ route('job-postings.show', $application->jobPosting) }}">
            {{ $application->jobPosting->title }}
        </a>
    </p>

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
    >
        <p><strong>Stage:</strong> <span x-text="stage"></span></p>

        <p x-show="error" x-text="error" style="color: red;"></p>
        <p x-show="loading">Updating...</p>

        <template x-if="stage === 'applied'">
            <button @click="transition('screening')" :disabled="loading">Move to Screening</button>
        </template>
        <template x-if="stage === 'screening'">
            <button @click="transition('interview')" :disabled="loading">Move to Interview</button>
        </template>
        <template x-if="stage === 'interview'">
            <button @click="transition('offer')" :disabled="loading">Move to Offer</button>
        </template>
        <template x-if="stage === 'offer'">
            <button @click="transition('hired')" :disabled="loading">Mark Hired</button>
        </template>

        <template x-if="!['hired', 'rejected', 'on_hold'].includes(stage)">
            <button @click="transition('on_hold')" :disabled="loading">Put On Hold</button>
        </template>

        <template x-if="stage === 'on_hold'">
            <button @click="transition(previousStage)" :disabled="loading">
                Resume (back to <span x-text="previousStage"></span>)
            </button>
        </template>

        <template x-if="!['hired', 'rejected'].includes(stage)">
            <button @click="transition('rejected')" :disabled="loading">Reject</button>
        </template>
    </div>

    <p><strong>Applied At:</strong> {{ $application->applied_at?->format('Y-m-d') ?? '—' }}</p>

    <a href="{{ route('applications.edit', $application) }}">Edit</a>
    <a href="{{ route('applications.index') }}">Back to list</a>

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</body>
</html>