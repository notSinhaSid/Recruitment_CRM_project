<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CompanyController extends Controller
{
    public function index(): View
    {
        $companies = Company::where('tenant_id', auth()->user()->tenant_id)
            ->latest()
            ->paginate(15);

        return view('companies.index', compact('companies'));
    }

    public function create(): View
    {
        return view('companies.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:companies,name',
            'industry' => 'nullable|string|max:255',
            'website' => 'nullable|string|max:255',
            'contact_number' => 'nullable|string|max:50',
            'location' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $validated['tenant_id'] = auth()->user()->tenant_id;

        Company::create($validated);

        return redirect()->route('companies.index')->with('success', 'Company created.');
    }

    public function show(Company $company): View
    {
        abort_if($company->tenant_id !== auth()->user()->tenant_id, 403);

        return view('companies.show', compact('company'));
    }

    public function edit(Company $company): View
    {
        abort_if($company->tenant_id !== auth()->user()->tenant_id, 403);

        return view('companies.edit', compact('company'));
    }

    public function update(Request $request, Company $company): RedirectResponse
    {
        abort_if($company->tenant_id !== auth()->user()->tenant_id, 403);

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:companies,name,' . $company->id,
            'industry' => 'nullable|string|max:255',
            'website' => 'nullable|string|max:255',
            'contact_number' => 'nullable|string|max:50',
            'location' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $company->update($validated);

        return redirect()->route('companies.index')->with('success', 'Company updated.');
    }

    public function destroy(Company $company): RedirectResponse
    {
        abort_if($company->tenant_id !== auth()->user()->tenant_id, 403);

        $company->delete();

        return redirect()->route('companies.index')->with('success', 'Company deleted.');
    }
}