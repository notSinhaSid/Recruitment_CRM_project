<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function edit(): View
    {
        $user = auth()->user();
        $tenant = $user->tenant;

        return view('profile.edit', compact('user', 'tenant'));
    }

    public function update(Request $request): RedirectResponse
    {
        $user = auth()->user();
        $tenant = $user->tenant;

        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'password' => ['nullable', 'confirmed', 'min:8'],
            'company_name' => ['required', 'string', 'max:255'],
            'logo' => ['nullable', 'image', 'max:2048'],
            'address_line1' => ['nullable', 'string', 'max:255'],
            'address_line2' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:255'],
            'state' => ['nullable', 'string', 'max:255'],
            'postal_code' => ['nullable', 'string', 'max:50'],
            'country' => ['nullable', 'string', 'max:255'],
        ]);

        $user->first_name = $validated['first_name'];
        $user->last_name = $validated['last_name'];
        $user->email = $validated['email'];

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        $tenant->name = $validated['company_name'];
        $tenant->address_line1 = $validated['address_line1'] ?? null;
        $tenant->address_line2 = $validated['address_line2'] ?? null;
        $tenant->city = $validated['city'] ?? null;
        $tenant->state = $validated['state'] ?? null;
        $tenant->postal_code = $validated['postal_code'] ?? null;
        $tenant->country = $validated['country'] ?? null;

        if ($request->hasFile('logo')) {
            if ($tenant->logo_path) {
                Storage::disk('public')->delete($tenant->logo_path);
            }
            $tenant->logo_path = $request->file('logo')->store('tenant-logos', 'public');
        }

        $tenant->save();

        return redirect()->route('profile.edit')->with('success', 'Profile updated successfully.');
    }
}
