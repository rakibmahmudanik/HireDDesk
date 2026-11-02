<?php

namespace App\Http\Controllers;

use App\Models\JobListing;
use App\Models\JobApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class JobApplicationController extends Controller
{
    /**
     * Handle candidate job application submission.
     */
    public function store(Request $request, JobListing $jobListing): RedirectResponse
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // 1. Prevent the job poster from applying to their own job
        if ($jobListing->company->user_id === $user->id) {
            return back()->with('error', 'You cannot apply to your own job listing!');
        }

        // 2. Only candidates should be able to submit applications
        if ($user->role !== 'candidate') {
            return back()->with('error', 'Only job seekers (candidates) can apply for jobs!');
        }

        // 3. Check if candidate has already applied
        $alreadyApplied = JobApplication::where('job_listing_id', $jobListing->id)
            ->where('user_id', $user->id)
            ->exists();

        if ($alreadyApplied) {
            return back()->with('error', 'You have already applied for this position!');
        }

        // 4. Validate uploaded file and inputs
        $request->validate([
            'resume' => 'required|file|mimes:pdf,doc,docx|max:5120', // Max 5MB
            'cover_letter' => 'nullable|string|max:2000',
        ]);

        // 5. Store uploaded resume file
        $resumePath = $request->file('resume')->store('resumes', 'public');

        // 6. Save job application in database
        JobApplication::create([
            'job_listing_id' => $jobListing->id,
            'user_id' => $user->id,
            'resume_path' => $resumePath,
            'cover_letter' => $request->string('cover_letter')->trim(),
            'status' => 'applied',
        ]);

        return back()->with('success', 'Your application has been submitted successfully!');
    }
}
