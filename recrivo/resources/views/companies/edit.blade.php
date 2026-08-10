<x-app-layout header="Edit Client Company">

    <div class="max-w-3xl mx-auto">
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

            <form method="POST" action="{{ route('companies.update', $company) }}">
                @csrf
                @method('PUT')

                @include('companies._form')

                <div class="flex items-center gap-3 mt-8 pt-6 border-t border-[var(--color-border)]">
                    <button type="submit"
                        class="flex items-center gap-2 px-5 py-2.5 rounded-lg bg-[var(--color-primary)] text-white text-sm font-medium hover:bg-[var(--color-primary-light)] transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4.5 12.75l6 6 9-13.5" /></svg>
                        Update Client Company
                    </button>
                    <a href="{{ route('companies.index') }}"
                        class="flex items-center gap-2 px-5 py-2.5 rounded-lg text-sm font-medium text-[var(--color-text-secondary)] hover:text-[var(--color-text)] transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 18L18 6M6 6l12 12" /></svg>
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>

</x-app-layout>
