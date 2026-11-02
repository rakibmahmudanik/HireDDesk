<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Applicants for {{ $jobListing->title }} - HireDDesk</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100 min-h-screen py-10 px-4">

    <div class="max-w-5xl mx-auto">
        <div class="flex items-center justify-between mb-8">
            <a href="{{ route('dashboard') }}" class="text-sm font-semibold text-indigo-600 dark:text-indigo-400 hover:underline">
                &larr; Back to Dashboard
            </a>
            <span class="text-xs font-bold uppercase tracking-wider text-gray-500">Recruiter Desk</span>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-3xl p-8 border border-gray-100 dark:border-gray-700 shadow-sm mb-6">
            <span class="text-xs font-bold text-indigo-600 dark:text-indigo-400 uppercase tracking-wider">{{ $jobListing->company->name }}</span>
            <h1 class="text-2xl font-black text-gray-900 dark:text-white mt-1">
                Applicants for "{{ $jobListing->title }}"
            </h1>
            <p class="text-sm text-gray-500 mt-1">Total Applications: {{ $applications->count() }}</p>
        </div>

        <!-- Applicants Table / List -->
        <div class="bg-white dark:bg-gray-800 rounded-3xl border border-gray-100 dark:border-gray-700 shadow-sm overflow-hidden">
            @forelse($applications as $app)
                <div class="p-6 border-b border-gray-100 dark:border-gray-700 last:border-0 flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div class="space-y-1">
                        <div class="flex items-center gap-3">
                            <span class="font-bold text-gray-900 dark:text-white text-base">
                                {{ $app->user->name }}
                            </span>
                            <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-blue-50 text-blue-700 dark:bg-blue-900/40 dark:text-blue-300 capitalize">
                                {{ $app->status }}
                            </span>
                        </div>
                        <p class="text-xs text-gray-500">
                            Email: <span class="font-medium text-gray-700 dark:text-gray-300">{{ $app->user->email }}</span> &bull; 
                            Applied {{ $app->created_at->diffForHumans() }}
                        </p>
                        @if($app->cover_letter)
                            <p class="text-xs text-gray-600 dark:text-gray-400 bg-gray-50 dark:bg-gray-700/50 p-3 rounded-xl mt-2 italic">
                                "{{ $app->cover_letter }}"
                            </p>
                        @endif
                    </div>

                    <div class="shrink-0">
                        <a href="{{ asset('storage/' . $app->resume_path) }}" target="_blank" download
                            class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-xs rounded-xl shadow transition inline-flex items-center gap-1.5">
                            📄 Download Resume (PDF)
                        </a>
                    </div>
                </div>
            @empty
                <div class="text-center py-12">
                    <p class="text-gray-500 text-sm">No applications received for this job yet.</p>
                </div>
            @endforelse
        </div>
    </div>

</body>
</html>