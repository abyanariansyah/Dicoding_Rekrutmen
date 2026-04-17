<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\JobController;
use App\Http\Controllers\API\ApplicationController;
use App\Http\Controllers\API\CompanyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Public API Routes
Route::prefix('v1')->group(function () {
    
    // Auth Routes (Public)
    Route::post('/auth/register', [AuthController::class, 'register']);
    Route::post('/auth/login', [AuthController::class, 'login']);
    
    // Jobs Routes (Public - Read only)
    Route::get('/jobs', [JobController::class, 'index']);
    Route::get('/jobs/{id}', [JobController::class, 'show']);
    
    // Companies Routes (Public - Read only)
    Route::get('/companies', [CompanyController::class, 'index']);
    Route::get('/companies/{id}', [CompanyController::class, 'show']);
    
    // Protected Routes (Requires Authentication)
    Route::middleware('auth:sanctum')->group(function () {
        
        // Auth Routes
        Route::get('/auth/me', [AuthController::class, 'me']);
        Route::post('/auth/logout', [AuthController::class, 'logout']);
        
        // Applications Routes
        Route::post('/applications', [ApplicationController::class, 'store']);
        Route::get('/applications', [ApplicationController::class, 'index']);
        Route::get('/applications/{id}', [ApplicationController::class, 'show']);
        Route::delete('/applications/{id}', [ApplicationController::class, 'destroy']);
        
        // Admin Routes
        Route::middleware('admin')->group(function () {
            // Jobs Management
            Route::post('/jobs', [JobController::class, 'store']);
            Route::put('/jobs/{id}', [JobController::class, 'update']);
            Route::delete('/jobs/{id}', [JobController::class, 'destroy']);
            
            // Applications Management
            Route::put('/applications/{id}/status', [ApplicationController::class, 'updateStatus']);
            
            // Companies Management
            Route::post('/companies', [CompanyController::class, 'store']);
            Route::put('/companies/{id}', [CompanyController::class, 'update']);
            Route::delete('/companies/{id}', [CompanyController::class, 'destroy']);
        });
    });
});
