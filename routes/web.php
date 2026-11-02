<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\JobListingController;
use App\Http\Controllers\JobApplicationController;
use App\Http\Controllers\EmployerController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 1. Public Homepage
Route::get('/', [JobListingController::class, 'index'])->name('home');

// 2. Authenticated Routes (Candidate & Employer)
Route::middleware(['auth', 'verified'])->group(function () {

    // Role-based Dashboard
    Route::get('/dashboard', function () {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($user->role === 'employer') {
            // Retrieve all jobs posted by this employer along with total applicant count
            $myJobs = $user->company
                ? $user->company->jobListings()->withCount('applications')->latest()->get()
                : [];

            return view('dashboard', [
                'role' => 'employer',
                'myJobs' => $myJobs,
            ]);
        } else {
            // Retrieve all applications submitted by this candidate
            $myApplications = $user->applications()
                ->with('jobListing.company')
                ->latest()
                ->get();

            return view('dashboard', [
                'role' => 'candidate',
                'myApplications' => $myApplications,
            ]);
        }
    })->name('dashboard');

    // Post a New Job (Must be defined BEFORE the wildcard /jobs/{jobListing:slug} route)
    Route::get('/jobs/create', [JobListingController::class, 'create'])->name('jobs.create');
    Route::post('/jobs', [JobListingController::class, 'store'])->name('jobs.store');

    // Submit Job Application
    Route::post('/jobs/{jobListing:slug}/apply', [JobApplicationController::class, 'store'])->name('jobs.apply');

    // View Job Applicants (Employer only)
    Route::get('/employer/jobs/{jobListing:slug}/applications', [EmployerController::class, 'applications'])->name('employer.applications');

    // Profile Management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// 3. Single Job Details (Wildcard parameter route placed at the end)
Route::get('/jobs/{jobListing:slug}', [JobListingController::class, 'show'])->name('jobs.show');
// Edit & Update Job Listings (Employer only)
Route::get('/jobs/{jobListing:slug}/edit', [JobListingController::class, 'edit'])->name('jobs.edit');
Route::put('/jobs/{jobListing:slug}', [JobListingController::class, 'update'])->name('jobs.update');

// Breeze Authentication Routes
require __DIR__ . '/auth.php';
