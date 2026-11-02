<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ ucfirst($role) }} Dashboard - HireDDesk</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100 min-h-screen flex flex-col">

    <!-- Top Navigation Header -->
    <header class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700 sticky top-0 z-50">
        <div class="max-w-6xl mx-auto px-4 h-16 flex items-center justify-between">
            <a href="{{ route('home') }}" class="text-2xl font-black text-indigo-600 dark:text-indigo-400">
                Hire<span class="text-gray-900 dark:text-white">D</span>Desk
            </a>

            <div class="flex items-center gap-4">
                <a href="{{ route('home') }}" class="text-sm font-semibold text-gray-600 dark:text-gray-300 hover:text-indigo-600">
                    Browse Jobs
                </a>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="text-sm text-red-500 font-semibold hover:underline">
                        Log Out
                    </button>
                </form>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-6xl mx-auto px-4 py-10 flex-1 w-full">

        <!-- Flash Messages -->
        @if(session('success'))
        <div class="mb-6 p-4 rounded-xl bg-emerald-100 text-emerald-800 dark:bg-emerald-900/50 dark:text-emerald-300 text-sm font-semibold">
            ✅ {{ session('success') }}
        </div>
        @endif
        @if(session('error'))
        <div class="mb-6 p-4 rounded-xl bg-red-100 text-red-800 dark:bg-red-900/50 dark:text-red-300 text-sm font-semibold">
            ⚠️ {{ session('error') }}
        </div>
        @endif

        <!-- Welcome Banner -->
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-8">
            <div>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900 dark:text-white">
                    Hello, {{ Auth::user()->name }}! 👋
                </h1>
                <p class="text-sm text-gray-500 mt-1">
                    Logged in as: <span class="px-2.5 py-0.5 rounded-full text-xs font-bold uppercase tracking-wider {{ $role === 'employer' ? 'bg-purple-100 text-purple-700 dark:bg-purple-900/50 dark:text-purple-300' : 'bg-blue-100 text-blue-700 dark:bg-blue-900/50 dark:text-blue-300' }}">{{ $role }}</span>
                </p>
            </div>

            <!-- Role-based Action Button -->
            @if($role === 'employer')
            <a href="{{ route('jobs.create') }}" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-sm rounded-xl shadow transition">
                + Post a New Job
            </a>
            @else
            <a href="{{ route('home') }}" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-sm rounded-xl shadow transition">
                🔍 Explore More Jobs
            </a>
            @endif
        </div>

        {{-- ========================================== --}}
        {{-- 1. EMPLOYER DASHBOARD VIEW                 --}}
        {{-- ========================================== --}}
        @if($role === 'employer')
        <div class="bg-white dark:bg-gray-800 rounded-3xl p-6 sm:p-8 border border-gray-100 dark:border-gray-700 shadow-sm">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="text-lg font-bold text-gray-900 dark:text-white">Your Job Listings</h2>
                    <p class="text-xs text-gray-400">Manage active openings and review applicants</p>
                </div>
                <span class="text-xs font-bold text-indigo-600 bg-indigo-50 dark:bg-indigo-950/60 px-3 py-1 rounded-full">
                    Total Jobs: {{ count($myJobs) }}
                </span>
            </div>

            @if(count($myJobs) > 0)
            <div class="divide-y divide-gray-100 dark:divide-gray-700">
                @foreach($myJobs as $job)
                <div class="py-5 flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <!-- Job Info Section -->
                    <div class="space-y-1">
                        <div class="flex items-center gap-2 flex-wrap">
                            <!-- Status Badge -->
                            <span class="px-2 py-0.5 rounded-full text-xs font-semibold {{ $job->status === 'active' ? 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/40 dark:text-emerald-300' : 'bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300' }}">
                                ● {{ ucfirst($job->status) }}
                            </span>

                            @if($job->is_featured)
                            <span class="px-2 py-0.5 rounded-full text-xs font-semibold bg-amber-100 text-amber-800 dark:bg-amber-900/40 dark:text-amber-300">
                                ⭐ Featured
                            </span>
                            @endif
                        </div>

                        <!-- Job Title -->
                        <h3 class="font-bold text-lg text-gray-900 dark:text-white hover:text-indigo-600 transition">
                            <a href="{{ route('jobs.show', $job->slug) }}">
                                {{ $job->title }}
                            </a>
                        </h3>

                        <!-- Meta Info -->
                        <p class="text-xs text-gray-500 dark:text-gray-400">
                            📍 {{ $job->location }} &bull; 💼 {{ $job->type }}
                            @if($job->salary_min && $job->salary_max)
                            &bull; 💰 ${{ number_format($job->salary_min) }} - ${{ number_format($job->salary_max) }}/yr
                            @endif
                            &bull; Posted {{ $job->created_at->diffForHumans() }}
                        </p>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-center gap-2.5 shrink-0 self-start md:self-center">
                        <a href="{{ route('employer.applications', $job->slug) }}" class="px-3.5 py-2 bg-indigo-50 hover:bg-indigo-100 dark:bg-indigo-950/60 dark:hover:bg-indigo-900 text-indigo-700 dark:text-indigo-300 font-bold text-xs rounded-xl transition inline-flex items-center gap-1.5">
                            👥 Applicants ({{ $job->applications_count }})
                        </a>

                        <a href="{{ route('jobs.edit', $job->slug) }}" class="px-3.5 py-2 border border-gray-200 dark:border-gray-700 hover:border-indigo-500 text-gray-700 dark:text-gray-300 font-semibold text-xs rounded-xl transition inline-flex items-center gap-1">
                            ✏️ Edit
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="text-center py-10">
                <p class="text-gray-500 text-sm">Your company hasn't posted any jobs yet.</p>
                <a href="{{ route('jobs.create') }}" class="inline-block mt-3 text-indigo-600 font-semibold text-sm hover:underline">
                    Create your first job post &rarr;
                </a>
            </div>
            @endif
        </div>

        {{-- ========================================== --}}
        {{-- 2. CANDIDATE DASHBOARD VIEW                --}}
        {{-- ========================================== --}}
        @else
        <div class="bg-white dark:bg-gray-800 rounded-3xl p-6 sm:p-8 border border-gray-100 dark:border-gray-700 shadow-sm">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="text-lg font-bold text-gray-900 dark:text-white">My Job Applications</h2>
                    <p class="text-xs text-gray-400">Track the status of the remote jobs you applied for</p>
                </div>
                <span class="text-xs font-bold text-indigo-600 bg-indigo-50 dark:bg-indigo-950/60 px-3 py-1 rounded-full">
                    Applied: {{ count($myApplications) }}
                </span>
            </div>

            @if(count($myApplications) > 0)
            <div class="divide-y divide-gray-100 dark:divide-gray-700">
                @foreach($myApplications as $app)
                <div class="py-4 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <span class="text-xs font-semibold text-indigo-600 dark:text-indigo-400">
                            {{ $app->jobListing->company->name }}
                        </span>
                        <h3 class="font-bold text-gray-900 dark:text-white text-base mt-0.5">
                            <a href="{{ route('jobs.show', $app->jobListing->slug) }}" class="hover:underline">
                                {{ $app->jobListing->title }}
                            </a>
                        </h3>
                        <p class="text-xs text-gray-400 mt-1">
                            📍 {{ $app->jobListing->location }} &bull;
                            Applied on {{ $app->created_at->format('M d, Y') }} ({{ $app->created_at->diffForHumans() }})
                        </p>
                    </div>

                    <div class="flex items-center gap-3">
                        <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider 
                                        {{ $app->status === 'applied' ? 'bg-amber-100 text-amber-800 dark:bg-amber-900/40 dark:text-amber-300' : '' }}
                                        {{ $app->status === 'reviewed' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900/40 dark:text-blue-300' : '' }}
                                        {{ $app->status === 'shortlisted' ? 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/40 dark:text-emerald-300' : '' }}
                                        {{ $app->status === 'rejected' ? 'bg-red-100 text-red-800 dark:bg-red-900/40 dark:text-red-300' : '' }}">
                            ● {{ $app->status }}
                        </span>

                        <a href="{{ asset('storage/' . $app->resume_path) }}" target="_blank" class="text-xs text-gray-500 hover:text-indigo-600 underline">
                            View CV
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="text-center py-12">
                <div class="w-16 h-16 rounded-full bg-indigo-50 dark:bg-indigo-950/60 text-indigo-600 mx-auto flex items-center justify-center text-2xl mb-3">
                    💼
                </div>
                <p class="text-gray-600 dark:text-gray-300 font-medium">You haven't applied to any jobs yet!</p>
                <p class="text-gray-400 text-xs mt-1">Find your next remote career from top global companies.</p>
                <a href="{{ route('home') }}" class="inline-block mt-4 px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-xs rounded-xl shadow transition">
                    Explore Remote Jobs &rarr;
                </a>
            </div>
            @endif
        </div>
        @endif

    </main>

</body>

</html>