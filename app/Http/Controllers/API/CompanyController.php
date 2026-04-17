<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    /**
     * Get all companies
     */
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 15);
        $companies = Company::paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $companies->items(),
            'pagination' => [
                'total' => $companies->total(),
                'per_page' => $companies->perPage(),
                'current_page' => $companies->currentPage(),
                'last_page' => $companies->lastPage(),
            ]
        ]);
    }

    /**
     * Get single company with its jobs
     */
    public function show($id)
    {
        $company = Company::with('jobs')->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $company
        ]);
    }

    /**
     * Create company
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:companies',
            'description' => 'nullable|string',
            'location' => 'nullable|string',
            'website' => 'nullable|url',
            'industry' => 'nullable|string',
        ]);

        $company = Company::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Company created successfully',
            'data' => $company
        ], 201);
    }

    /**
     * Update company
     */
    public function update(Request $request, $id)
    {
        $company = Company::findOrFail($id);

        $validated = $request->validate([
            'name' => 'sometimes|string|max:255|unique:companies,name,' . $id,
            'description' => 'nullable|string',
            'location' => 'nullable|string',
            'website' => 'nullable|url',
            'industry' => 'nullable|string',
        ]);

        $company->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Company updated successfully',
            'data' => $company
        ]);
    }

    /**
     * Delete company
     */
    public function destroy($id)
    {
        $company = Company::findOrFail($id);
        $company->delete();

        return response()->json([
            'success' => true,
            'message' => 'Company deleted successfully'
        ]);
    }
}
