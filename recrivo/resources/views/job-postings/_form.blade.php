@php
    $jp = $jobPosting ?? null;
    $selectedCompany = old('company_id', $jp->company_id ?? '');
    $selectedStatus = old('status', $jp->status ?? 'open');
@endphp

<div class="grid grid-cols-2 gap-5">
    <x-form-field name="company_id" label="Company" type="select" required>
        @if (! $jp)
            <option value="">-- Select --</option>
        @endif
        @foreach ($companies as $company)
            <option value="{{ $company->id }}" @selected($selectedCompany == $company->id)>
                {{ $company->name }}
            </option>
        @endforeach
    </x-form-field>

    <x-form-field name="title" label="Title" required value="{{ old('title', $jp->title ?? '') }}" />
</div>

<div class="mt-5">
    <x-form-field name="description" label="Description" type="richtext">{{ old('description', $jp->description ?? '') }}</x-form-field>
</div>

<div class="grid grid-cols-2 gap-5 mt-5">
    <x-form-field name="status" label="Status" type="select" required>
        <option value="open" @selected($selectedStatus == 'open')>Open</option>
        <option value="closed" @selected($selectedStatus == 'closed')>Closed</option>
        <option value="on_hold" @selected($selectedStatus == 'on_hold')>On Hold</option>
    </x-form-field>

    <x-form-field name="open_spots" label="Open Spots" type="number" min="1" required value="{{ old('open_spots', $jp->open_spots ?? 1) }}" />
</div>

<div class="grid grid-cols-2 gap-5 mt-5">
    <x-form-field name="location" label="Location" value="{{ old('location', $jp->location ?? '') }}" />
    <x-form-field name="employment_type" label="Employment Type" value="{{ old('employment_type', $jp->employment_type ?? '') }}" />
</div>
