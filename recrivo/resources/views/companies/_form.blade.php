@php
    $c = $company ?? null;
@endphp

<div class="grid grid-cols-2 gap-5">
    <x-form-field name="name" label="Client Company Name" required value="{{ old('name', $c->name ?? '') }}" />
    <x-form-field name="industry" label="Industry" value="{{ old('industry', $c->industry ?? '') }}" />
</div>

<div class="grid grid-cols-2 gap-5 mt-5">
    <x-form-field name="website" label="Website" value="{{ old('website', $c->website ?? '') }}" />
    <x-form-field name="contact_number" label="Contact Number" value="{{ old('contact_number', $c->contact_number ?? '') }}" />
</div>

<div class="mt-5">
    <x-form-field name="location" label="Location" value="{{ old('location', $c->location ?? '') }}" />
</div>

<div class="mt-5">
    <x-form-field name="notes" label="Notes" type="textarea">{{ old('notes', $c->notes ?? '') }}</x-form-field>
</div>
