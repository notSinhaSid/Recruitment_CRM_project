@php
    $c = $candidate ?? null;
@endphp

<div class="grid grid-cols-2 gap-5">
    <x-form-field name="first_name" label="First Name" required value="{{ old('first_name', $c->first_name ?? '') }}" />
    <x-form-field name="last_name" label="Last Name" required value="{{ old('last_name', $c->last_name ?? '') }}" />
</div>

<div class="grid grid-cols-2 gap-5 mt-5">
    <x-form-field name="email" label="Email" type="email" required value="{{ old('email', $c->email ?? '') }}" />
    <x-form-field name="phone" label="Phone" value="{{ old('phone', $c->phone ?? '') }}" />
</div>

<div class="grid grid-cols-2 gap-5 mt-5">
    <x-form-field name="linkedin_url" label="LinkedIn URL" type="url" value="{{ old('linkedin_url', $c->linkedin_url ?? '') }}" />
    <x-form-field name="years_of_experience" label="Years of Experience" type="number" min="0" value="{{ old('years_of_experience', $c->years_of_experience ?? '') }}" />
</div>

<div class="mt-5">
    <x-form-field name="source" label="Source" placeholder="LinkedIn, Referral, Job Board..." value="{{ old('source', $c->source ?? '') }}" />
</div>

<div class="mt-5">
    <x-form-field name="resume" label="Resume (PDF or DOC, max 3MB)" type="file" accept=".pdf,.doc,.docx" />
    @if ($c && $c->resume_path)
        <p class="mt-2 text-sm text-[var(--color-text-secondary)]">
            Current file:
            <a href="{{ Storage::url($c->resume_path) }}" target="_blank" class="text-[var(--color-primary)] hover:underline">View existing resume</a>
        </p>
    @endif
</div>

<div class="mt-5">
    <x-form-field name="notes" label="Notes" type="textarea">{{ old('notes', $c->notes ?? '') }}</x-form-field>
</div>
