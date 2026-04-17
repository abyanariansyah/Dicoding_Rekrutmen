<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

/**
 * Example Controller untuk consume API dari Backend
 * Catatan: Aplikasi ini sudah consume API dari Frontend (JavaScript)
 * Controller ini hanya untuk referensi backend consumption
 */
class JobApiController extends Controller
{
    /**
     * Get jobs dari API (Backend example)
     */
    public function indexFromApi()
    {
        try {
            $response = Http::get(url('/api/v1/jobs'), [
                'per_page' => 20
            ]);
            
            $jobs = $response->json();
            
            return view('jobs.index', [
                'jobs' => $jobs['data'] ?? [],
                'pagination' => $jobs['pagination'] ?? []
            ]);
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memuat jobs');
        }
    }
    
    /**
     * Search jobs dengan filter (Backend example)
     */
    public function search()
    {
        $search = request()->get('search');
        $jobType = request()->get('job_type');
        $location = request()->get('location');
        
        try {
            $query = [
                'per_page' => 20,
            ];
            
            if ($search) $query['search'] = $search;
            if ($jobType) $query['job_type'] = $jobType;
            if ($location) $query['location'] = $location;
            
            $response = Http::get(url('/api/v1/jobs'), $query);
            $jobs = $response->json();
            
            return view('jobs.index', [
                'jobs' => $jobs['data'] ?? [],
                'pagination' => $jobs['pagination'] ?? []
            ]);
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal search jobs');
        }
    }
}
