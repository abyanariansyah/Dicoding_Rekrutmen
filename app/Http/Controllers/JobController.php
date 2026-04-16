<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobController extends Controller
{
    private function ensureAdmin()
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403);
        }
    }

    public function index()
    {
        $this->ensureAdmin();

        $jobs = Job::orderByDesc('created_at')->get();

        return view('jobs.admin_index', compact('jobs'));
    }

    public function create()
    {
        $this->ensureAdmin();

        $categories = \App\Models\JobCategory::all();
        $company = auth()->user()->company;

        if (!$company) {
            return redirect()->route('company.create')->with('error', 'Silakan buat profil perusahaan terlebih dahulu.');
        }

        return view('jobs.create', compact('categories', 'company'));
    }

    public function store(Request $request)
    {
        $this->ensureAdmin();

        $data = $request->validate([
            'category_id' => ['required', 'exists:job_categories,id'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'requirements' => ['nullable', 'string'],
            'location' => ['required', 'string', 'max:255'],
            'job_type' => ['required', 'in:Full-time,Part-time,Contract,Internship,Freelance'],
            'experience_level' => ['required', 'in:Entry Level,Mid Level,Senior,Expert'],
            'salary_min' => ['nullable', 'numeric', 'min:0'],
            'salary_max' => ['nullable', 'numeric', 'min:0'],
            'deadline' => ['required', 'date', 'after_or_equal:today'],
        ]);

        $data['company_id'] = auth()->user()->company->id;

        \App\Models\Job::create($data);

        return redirect()->route('admin.jobs.index')->with('success', 'Lowongan berhasil ditambahkan.');
    }

    public function edit(Job $job)
    {
        $this->ensureAdmin();

        $categories = \App\Models\JobCategory::all();

        return view('jobs.edit', compact('job', 'categories'));
    }

    public function update(Request $request, Job $job)
    {
        $this->ensureAdmin();

        $data = $request->validate([
            'category_id' => ['required', 'exists:job_categories,id'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'requirements' => ['nullable', 'string'],
            'location' => ['required', 'string', 'max:255'],
            'job_type' => ['required', 'in:Full-time,Part-time,Contract,Internship,Freelance'],
            'experience_level' => ['required', 'in:Entry Level,Mid Level,Senior,Expert'],
            'salary_min' => ['nullable', 'numeric', 'min:0'],
            'salary_max' => ['nullable', 'numeric', 'min:0'],
            'deadline' => ['required', 'date', 'after_or_equal:today'],
        ]);

        $job->update($data);

        return redirect()->route('admin.jobs.index')->with('success', 'Lowongan berhasil diperbarui.');
    }

    public function destroy(Job $job)
    {
        $this->ensureAdmin();

        $job->delete();

        return redirect()->route('admin.jobs.index')->with('success', 'Lowongan berhasil dihapus.');
    }
}
