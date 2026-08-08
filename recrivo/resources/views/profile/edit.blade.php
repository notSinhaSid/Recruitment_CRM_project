<x-app-layout>
    <x-slot name="header">
        <h1 class="text-xl font-semibold text-[#1F2937]">Profile</h1>
    </x-slot>

    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="max-w-3xl space-y-8">
        @csrf
        @method('PUT')

        {{-- Company / Tenant --}}
        <div class="bg-white rounded-xl border border-[#E4E8EB] p-6 shadow-sm">
            <h2 class="text-base font-semibold text-[#1F2937] mb-5">Company</h2>

            <div class="flex items-center gap-5 mb-6">
                <div class="w-16 h-16 rounded-lg bg-[#F7F8F9] border border-[#E4E8EB] overflow-hidden flex items-center justify-center shrink-0">
                    @if ($tenant->logo_path)
                        <img src="{{ Storage::url($tenant->logo_path) }}" alt="Company logo" class="w-full h-full object-cover">
                    @else
                        <span class="text-xs text-[#6B7684]">No logo</span>
                    @endif
                </div>
                <div class="flex-1">
                    <x-form-field type="file" name="logo" label="Company Logo" />
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div class="sm:col-span-2">
                    <x-form-field type="text" name="company_name" label="Company Name" :value="old('company_name', $tenant->name)" />
                </div>
                <div class="sm:col-span-2">
                    <x-form-field type="text" name="address_line1" label="Address Line 1" :value="old('address_line1', $tenant->address_line1)" />
                </div>
                <div class="sm:col-span-2">
                    <x-form-field type="text" name="address_line2" label="Address Line 2" :value="old('address_line2', $tenant->address_line2)" />
                </div>
                <x-form-field type="text" name="city" label="City" :value="old('city', $tenant->city)" />
                <x-form-field type="text" name="state" label="State" :value="old('state', $tenant->state)" />
                <x-form-field type="text" name="postal_code" label="Postal Code" :value="old('postal_code', $tenant->postal_code)" />
                <x-form-field type="text" name="country" label="Country" :value="old('country', $tenant->country)" />
            </div>
        </div>

        {{-- User account --}}
        <div class="bg-white rounded-xl border border-[#E4E8EB] p-6 shadow-sm">
            <h2 class="text-base font-semibold text-[#1F2937] mb-5">Your Account</h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <x-form-field type="text" name="first_name" label="First Name" :value="old('first_name', $user->first_name)" />
                <x-form-field type="text" name="last_name" label="Last Name" :value="old('last_name', $user->last_name)" />
                <div class="sm:col-span-2">
                    <x-form-field type="email" name="email" label="Email" :value="old('email', $user->email)" />
                </div>
            </div>
        </div>

        {{-- Password --}}
        <div class="bg-white rounded-xl border border-[#E4E8EB] p-6 shadow-sm">
            <h2 class="text-base font-semibold text-[#1F2937] mb-5">Change Password</h2>
            <p class="text-sm text-[#6B7684] mb-5">Leave blank to keep your current password.</p>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <x-form-field type="password" name="password" label="New Password" />
                <x-form-field type="password" name="password_confirmation" label="Confirm New Password" />
            </div>
        </div>

        <div class="flex justify-end">
            <button
                type="submit"
                class="px-5 py-2.5 rounded-lg bg-[#3B4A5A] text-white text-sm font-medium shadow-sm hover:shadow-md hover:bg-[#2C3844] transition"
            >
                Save Changes
            </button>
        </div>
    </form>
</x-app-layout>