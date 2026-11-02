<?php

namespace App\Http\Controllers;

use App\Models\JobListing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployerController extends Controller
{
    // কোনো জবে আবেদনকারীদের তালিকা দেখা
    public function applications(JobListing $jobListing)
    {
        // সিকিউরিটি: শুধু এই জবের মালিক (কোম্পানি) আবেদনকারীদের দেখতে পারবে
        if ($jobListing->company->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access.');
        }

        $applications = $jobListing->applications()->with('user')->latest()->get();

        return view('employer.applications', compact('jobListing', 'applications'));
    }
}