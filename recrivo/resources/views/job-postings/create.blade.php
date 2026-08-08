<x-app-layout header="New Job Posting">

    <div class="max-w-3xl">
        <div class="bg-[var(--color-card)] border border-[var(--color-border)] rounded-xl p-8">

            @if ($errors->any())
                <div class="mb-6 rounded-lg border border-[var(--color-coral)]/30 bg-[var(--color-coral)]/5 px-4 py-3">
                    <p class="text-sm font-medium text-[var(--color-coral)] mb-1">Please fix the following:</p>
                    <ul class="list-disc list-inside text-sm text-[var(--color-coral)] space-y-0.5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('job-postings.store') }}">
                @csrf

                @include('job-postings._form')

                <div class="flex items-center gap-3 mt-8 pt-6 border-t border-[var(--color-border)]">
                    <button type="submit"
                        class="px-5 py-2.5 rounded-lg bg-[var(--color-primary)] text-white text-sm font-medium hover:bg-[var(--color-primary-light)] transition">
                        Create Job Posting
                    </button>
                    <a href="{{ route('job-postings.index') }}"
                        class="px-5 py-2.5 rounded-lg text-sm font-medium text-[var(--color-text-secondary)] hover:text-[var(--color-text)] transition">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>

</x-app-layout>
