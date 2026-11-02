<?php

namespace App\Http\Controllers;

use App\Models\JobListing;
use App\Models\Company;
use App\Models\JobApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class JobListingController extends Controller
{
    /**
     * Display a paginated list of active jobs on the homepage.
     */
    public function index(): View
    {
        $jobs = JobListing::with('company')
            ->where('status', 'active')
            ->latest()
            ->paginate(10);

        return view('welcome', compact('jobs'));
    }

    /**
     * Display the specified job details page.
     */
    public function show(JobListing $jobListing): View
    {
        $jobListing->load('company');

        // Check if the currently authenticated user has already applied
        $hasApplied = false;
        if (Auth::check()) {
            $hasApplied = JobApplication::where('job_listing_id', $jobListing->id)
                ->where('user_id', Auth::id())
                ->exists();
        }

        return view('jobs.show', [
            'job' => $jobListing,
            'hasApplied' => $hasApplied,
        ]);
    }

    /**
     * Show the form for creating a new job opening (Employers only).
     */
    public function create(): View|RedirectResponse
    {
        // Prevent candidates from posting jobs
        if (Auth::user()->role !== 'employer') {
            return redirect()->route('dashboard')->with('error', 'Only employers can post new jobs!');
        }

        return view('jobs.create');
    }

    /**
     * Store a newly created job listing and associate it with a company.
     */
    public function store(Request $request): RedirectResponse
    {
        // Authorize action
        if (Auth::user()->role !== 'employer') {
            return redirect()->route('dashboard')->with('error', 'Unauthorized action.');
        }

        // Validate and capture sanitized input data
        $validated = $request->validate([
            'company_name' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'type' => 'required|string|in:Full-time,Part-time,Contract,Internship',
            'salary_min' => 'nullable|numeric|min:0',
            'salary_max' => 'nullable|numeric|gte:salary_min',
            'description' => 'required|string',
            'is_featured' => 'nullable|boolean',
        ]);

        $user = Auth::user();

        // 1. Retrieve existing company or create a new one for this employer
        $company = $user->company ?? Company::create([
            'user_id' => $user->id,
            'name' => $validated['company_name'],
            'slug' => Str::slug($validated['company_name'] . '-' . Str::random(5)),
            'location' => $validated['location'],
        ]);

        // 2. Create the job listing using type-safe validated values
        JobListing::create([
            'company_id' => $company->id,
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title'] . '-' . Str::random(6)),
            'location' => $validated['location'],
            'type' => $validated['type'],
            'salary_min' => $validated['salary_min'] ?? null,
            'salary_max' => $validated['salary_max'] ?? null,
            'description' => $validated['description'],
            'is_featured' => $request->boolean('is_featured'),
            'status' => 'active',
        ]);

        return redirect()->route('dashboard')->with('success', 'Job posted successfully!');
    }
    /**
     * Show the form for editing an existing job listing.
     */
    public function edit(JobListing $jobListing): View
    {
        // Authorize: Only the owner of the job can edit it
        if ($jobListing->company->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action. You do not own this listing.');
        }

        return view('jobs.edit', [
            'job' => $jobListing
        ]);
    }

    /**
     * Update the specified job listing in storage.
     */
    public function update(Request $request, JobListing $jobListing): RedirectResponse
    {
        // Authorize: Only the owner of the job can update it
        if ($jobListing->company->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Validate updated inputs
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'type' => 'required|string|in:Full-time,Part-time,Contract,Internship',
            'salary_min' => 'nullable|numeric|min:0',
            'salary_max' => 'nullable|numeric|gte:salary_min',
            'description' => 'required|string',
            'status' => 'required|in:active,closed',
            'is_featured' => 'nullable|boolean',
        ]);

        // Update the job listing
        $jobListing->update([
            'title' => $validated['title'],
            'location' => $validated['location'],
            'type' => $validated['type'],
            'salary_min' => $validated['salary_min'] ?? null,
            'salary_max' => $validated['salary_max'] ?? null,
            'description' => $validated['description'],
            'status' => $validated['status'],
            'is_featured' => $request->boolean('is_featured'),
        ]);

        return redirect()->route('dashboard')->with('success', 'Job listing updated successfully!');
    }
}
