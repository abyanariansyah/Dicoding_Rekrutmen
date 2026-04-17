<?php

use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JobController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth')->name('dashboard');

Route::get('/jobs', [ApplicationController::class, 'jobs'])->name('jobs.index');
Route::get('/jobs/{job}/apply', [ApplicationController::class, 'create'])->middleware('auth')->name('jobs.apply');
Route::post('/jobs/{job}/apply', [ApplicationController::class, 'store'])->middleware('auth')->name('jobs.apply.store');
Route::get('/applications', [ApplicationController::class, 'mine'])->middleware('auth')->name('applications.mine');

Route::get('/company/setup', [CompanyController::class, 'create'])->name('company.create');
Route::post('/company/setup', [CompanyController::class, 'store'])->name('company.store');

Route::get('/admin/jobs', [JobController::class, 'index'])->name('admin.jobs.index');
Route::get('/admin/jobs/create', [JobController::class, 'create'])->name('admin.jobs.create');
Route::post('/admin/jobs', [JobController::class, 'store'])->name('admin.jobs.store');
Route::get('/admin/jobs/{job}/edit', [JobController::class, 'edit'])->name('admin.jobs.edit');
Route::put('/admin/jobs/{job}', [JobController::class, 'update'])->name('admin.jobs.update');
Route::delete('/admin/jobs/{job}', [JobController::class, 'destroy'])->name('admin.jobs.destroy');

Route::get('/admin/applications', [ApplicationController::class, 'adminIndex'])->name('admin.applications.index');
Route::post('/admin/applications/{application}/status', [ApplicationController::class, 'updateStatus'])->name('admin.applications.status');
