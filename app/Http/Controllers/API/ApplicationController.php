<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApplicationController extends Controller
{
    /**
     * Get all applications with pagination
     */
    public function index(Request $request)
    {
        $query = Application::query();

        // Filter by status
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        // Filter by job
        if ($request->has('job_id')) {
            $query->where('job_id', $request->job_id);
        }

        // Filter by user
        if ($request->has('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        $perPage = $request->get('per_page', 15);
        $applications = $query->with(['user', 'job'])
                              ->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $applications->items(),
            'pagination' => [
                'total' => $applications->total(),
                'per_page' => $applications->perPage(),
                'current_page' => $applications->currentPage(),
                'last_page' => $applications->lastPage(),
            ]
        ]);
    }

    /**
     * Get single application
     */
    public function show($id)
    {
        $application = Application::with(['user', 'job'])->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $application
        ]);
    }

    /**
     * Create application
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'job_id' => 'required|exists:job_openings,id',
            'cover_letter' => 'nullable|string',
            'cv_path' => 'nullable|string',
        ]);

        // Check if user already applied for this job
        $userId = Auth::id();
        $existing = Application::where('user_id', $userId)
                               ->where('job_id', $request->job_id)
                               ->first();

        if ($existing) {
            return response()->json([
                'success' => false,
                'message' => 'You already applied for this job'
            ], 422);
        }

        $validated['user_id'] = $userId;
        $validated['status'] = 'pending';

        $application = Application::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Application submitted successfully',
            'data' => $application
        ], 201);
    }

    /**
     * Update application status (Admin only)
     */
    public function updateStatus(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,accepted,rejected',
        ]);

        $application = Application::findOrFail($id);
        $application->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Application status updated',
            'data' => $application
        ]);
    }

    /**
     * Delete application
     */
    public function destroy($id)
    {
        $application = Application::findOrFail($id);
        $application->delete();

        return response()->json([
            'success' => true,
            'message' => 'Application deleted successfully'
        ]);
    }
}
