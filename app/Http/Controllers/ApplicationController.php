<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApplicationController extends Controller
{
    private function ensureAuth()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
    }

    private function ensureAdmin()
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403);
        }
    }

    public function adminIndex()
    {
        $this->ensureAdmin();

        $applications = Application::with(['user', 'job'])->orderByDesc('created_at')->get();

        return view('applications.index', compact('applications'));
    }

    public function jobs()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if (Auth::user()->role === 'admin') {
            abort(403);
        }

        $query = Job::with('company', 'category')->where('deadline', '>=', now());

        // Search
        if (request('search')) {
            $search = request('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filter by category
        if (request('category_id')) {
            $query->where('category_id', request('category_id'));
        }

        // Filter by location
        if (request('location')) {
            $query->where('location', 'like', '%' . request('location') . '%');
        }

        // Filter by job type
        if (request('job_type')) {
            $query->where('job_type', request('job_type'));
        }

        // Filter by experience level
        if (request('experience_level')) {
            $query->where('experience_level', request('experience_level'));
        }

        $jobs = $query->orderBy('deadline')->paginate(10);
        $categories = \App\Models\JobCategory::all();

        return view('jobs.index', compact('jobs', 'categories'));
    }

    public function mine()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $applications = Auth::user()->applications()->with('job')->orderByDesc('created_at')->get();

        return view('applications.mine', compact('applications'));
    }

    public function create(Job $job)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if (Auth::user()->role === 'admin') {
            abort(403);
        }

        return view('applications.create', compact('job'));
    }

    public function store(Request $request, Job $job)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if (Auth::user()->role === 'admin') {
            abort(403);
        }

        $alreadyApplied = Application::where('user_id', Auth::id())
            ->where('job_id', $job->id)
            ->exists();

        if ($alreadyApplied) {
            return redirect()->route('jobs.index')->with('error', 'Anda sudah mengajukan lamaran ke lowongan ini.');
        }

        Application::create([
            'user_id' => Auth::id(),
            'job_id' => $job->id,
            'status' => 'Pending',
            'note' => $request->input('note', ''),
        ]);

        return redirect()->route('applications.mine')->with('success', 'Lamaran berhasil diajukan.');
    }

    public function updateStatus(Request $request, Application $application)
    {
        $this->ensureAdmin();

        $data = $request->validate([
            'status' => ['required', 'in:Pending,Diterima,Ditolak'],
            'note' => ['nullable', 'string'],
        ]);

        $application->update($data);

        return redirect()->route('admin.applications.index')->with('success', 'Status lamaran berhasil diperbarui.');
    }
}
