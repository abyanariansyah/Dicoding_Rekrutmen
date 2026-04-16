<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Application;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        if ($user->role === 'admin') {
            $jobsCount = Job::count();
            $applicationsCount = Application::count();
            $pendingCount = Application::where('status', 'Pending')->count();
            $acceptedCount = Application::where('status', 'Diterima')->count();
            $rejectedCount = Application::where('status', 'Ditolak')->count();

            return view('dashboard.admin', compact(
                'jobsCount',
                'applicationsCount',
                'pendingCount',
                'acceptedCount',
                'rejectedCount'
            ));
        }

        $jobs = Job::orderBy('deadline')->get();
        $applications = $user->applications()->with('job')->orderByDesc('created_at')->get();

        return view('dashboard.user', compact('jobs', 'applications'));
    }
}
