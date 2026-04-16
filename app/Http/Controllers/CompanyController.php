<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompanyController extends Controller
{
    public function create()
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403);
        }

        $company = Auth::user()->company;

        return view('companies.form', compact('company'));
    }

    public function store(Request $request)
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403);
        }

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'website' => ['nullable', 'url'],
            'location' => ['required', 'string', 'max:255'],
            'industry' => ['required', 'string', 'max:255'],
            'company_size' => ['required', 'string'],
        ]);

        $company = Auth::user()->company;

        if ($company) {
            $company->update($data);
            $message = 'Profil perusahaan berhasil diperbarui.';
        } else {
            $data['user_id'] = Auth::id();
            Company::create($data);
            $message = 'Profil perusahaan berhasil dibuat.';
        }

        return redirect()->route('admin.jobs.create')->with('success', $message);
    }
}
