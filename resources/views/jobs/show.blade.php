<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $job->title }} at {{ $job->company->name }} - HireDDesk</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100 antialiased font-sans min-h-screen flex flex-col">

    <!-- Top Navigation -->
    <header class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700 sticky top-0 z-50">
        <div class="max-w-5xl mx-auto px-4 h-16 flex items-center justify-between">
            <a href="{{ route('home') }}" class="text-2xl font-black tracking-tight text-indigo-600 dark:text-indigo-400">
                Hire<span class="text-gray-900 dark:text-white">D</span>Desk
            </a>

            <div class="flex items-center gap-4">
                <a href="{{ route('home') }}" class="text-sm font-semibold text-gray-600 dark:text-gray-300 hover:text-indigo-600">
                    &larr; Back to all jobs
                </a>
                @auth
                <a href="{{ url('/dashboard') }}" class="text-sm font-semibold text-gray-700 dark:text-gray-200">
                    Dashboard
                </a>
                @else
                <a href="{{ route('login') }}" class="text-sm font-semibold text-gray-700 dark:text-gray-200">
                    Log in
                </a>
                @endauth
            </div>
        </div>
    </header>

    <!-- Job Header Section -->
    <main class="max-w-4xl mx-auto px-4 py-10 flex-1 w-full">
        <div class="bg-white dark:bg-gray-800 rounded-3xl p-8 border border-gray-100 dark:border-gray-700 shadow-sm">

            <div class="flex items-center gap-4 mb-6">
                <div class="w-16 h-16 rounded-2xl bg-indigo-600 text-white font-extrabold flex items-center justify-center text-2xl shadow-sm shrink-0">
                    {{ strtoupper(substr($job->company->name, 0, 1)) }}
                </div>
                <div>
                    <h2 class="text-base font-semibold text-indigo-600 dark:text-indigo-400">
                        {{ $job->company->name }}
                    </h2>
                    <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900 dark:text-white mt-1">
                        {{ $job->title }}
                    </h1>
                </div>
            </div>

            <!-- Tags & Meta -->
            <div class="flex flex-wrap items-center gap-3 py-4 border-y border-gray-100 dark:border-gray-700 text-sm">
                <span class="px-3 py-1 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-full font-medium">
                    📍 {{ $job->location }}
                </span>
                <span class="px-3 py-1 bg-blue-50 dark:bg-blue-900/40 text-blue-700 dark:text-blue-300 rounded-full font-medium">
                    💼 {{ $job->type }}
                </span>
                @if($job->salary_min && $job->salary_max)
                <span class="px-3 py-1 bg-emerald-50 dark:bg-emerald-900/40 text-emerald-700 dark:text-emerald-300 rounded-full font-medium">
                    💰 ${{ number_format($job->salary_min) }} - ${{ number_format($job->salary_max) }} / year
                </span>
                @endif
                <span class="text-gray-400 text-xs ml-auto">
                    Posted {{ $job->created_at->diffForHumans() }}
                </span>
            </div>

            <!-- Job Description -->
            <div class="mt-8">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-3">About the Role</h3>
                <div class="text-gray-700 dark:text-gray-300 leading-relaxed space-y-4">
                    <p>{{ $job->description }}</p>
                </div>
            </div>

            <!-- About Company -->
            @if($job->company->about)
            <div class="mt-10 p-6 bg-gray-50 dark:bg-gray-700/50 rounded-2xl">
                <h3 class="text-base font-bold text-gray-900 dark:text-white mb-2">About {{ $job->company->name }}</h3>
                <p class="text-sm text-gray-600 dark:text-gray-300 leading-relaxed">
                    {{ $job->company->about }}
                </p>
                @if($job->company->website)
                <a href="{{ $job->company->website }}" target="_blank" class="inline-block mt-3 text-sm text-indigo-600 dark:text-indigo-400 font-semibold hover:underline">
                    Visit Website &rarr;
                </a>
                @endif
            </div>
            @endif

            <!-- Application Section -->
            <div id="apply" class="mt-10 p-8 bg-indigo-50 dark:bg-indigo-950/40 rounded-3xl border border-indigo-100 dark:border-indigo-900">
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Apply for this Position</h3>
                <p class="text-sm text-gray-600 dark:text-gray-300 mb-6">Upload your resume and submit your details to {{ $job->company->name }}.</p>

                <!-- Flash Messages -->
                @if(session('success'))
                <div class="p-4 mb-6 rounded-xl bg-emerald-100 text-emerald-800 dark:bg-emerald-900/50 dark:text-emerald-300 text-sm font-semibold">
                    ✅ {{ session('success') }}
                </div>
                @endif

                @if(session('error'))
                <div class="p-4 mb-6 rounded-xl bg-amber-100 text-amber-800 dark:bg-amber-900/50 dark:text-amber-300 text-sm font-semibold">
                    ⚠️ {{ session('error') }}
                </div>
                @endif

                @auth
                {{-- 1. If current user is the owner of this job --}}
                @if($job->company->user_id === Auth::id())
                <div class="mt-4 flex items-center justify-center gap-3">
                    <a href="{{ route('employer.applications', $job->slug) }}" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-xs rounded-xl shadow transition">
                        👥 View Candidates &rarr;
                    </a>
                    <a href="{{ route('jobs.edit', $job->slug) }}" class="px-4 py-2.5 border border-gray-300 dark:border-gray-600 hover:border-indigo-500 font-semibold text-xs rounded-xl transition">
                        ✏️ Edit Job
                    </a>
                </div>

                {{-- 2. If current user is an employer (not candidate) --}}
                @elseif(Auth::user()->role !== 'candidate')
                <div class="text-center py-6 bg-amber-50 dark:bg-amber-950/40 rounded-2xl border border-amber-200 dark:border-amber-800 p-4">
                    <p class="text-sm font-semibold text-amber-800 dark:text-amber-300">
                        ⚠️ You are logged in with an Employer account. Only candidates can submit applications.
                    </p>
                </div>

                {{-- 3. If candidate has already applied --}}
                @elseif($hasApplied)
                <div class="text-center py-6 bg-emerald-50 dark:bg-emerald-950/40 rounded-2xl border border-emerald-200 dark:border-emerald-800 p-6">
                    <span class="text-2xl">🎉</span>
                    <h4 class="font-bold text-emerald-900 dark:text-emerald-200 mt-2">You have already applied for this job!</h4>
                    <p class="text-xs text-emerald-700 dark:text-emerald-400 mt-1">Head over to your dashboard to track your application status.</p>
                    <a href="{{ route('dashboard') }}" class="inline-block mt-4 px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-xs rounded-xl shadow transition">
                        Go to My Applications &rarr;
                    </a>
                </div>

                {{-- 4. Normal Candidate Application Form --}}
                @else
                <form action="{{ route('jobs.apply', $job->slug) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                    @csrf

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-1">
                            Resume / CV (PDF, DOC, DOCX - max 5MB) <span class="text-red-500">*</span>
                        </label>
                        <input type="file" name="resume" required accept=".pdf,.doc,.docx"
                            class="w-full text-sm text-gray-600 dark:text-gray-300 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-indigo-600 file:text-white hover:file:bg-indigo-700 cursor-pointer border border-gray-300 dark:border-gray-600 rounded-xl p-2 bg-white dark:bg-gray-800" />
                        @error('resume')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-1">
                            Cover Letter / Note (Optional)
                        </label>
                        <textarea name="cover_letter" rows="4" placeholder="Briefly introduce yourself and why you're a great fit for this remote role..."
                            class="w-full rounded-2xl border-gray-300 dark:border-gray-600 dark:bg-gray-800 text-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('cover_letter') }}</textarea>
                        @error('cover_letter')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-sm rounded-xl shadow transition">
                        Submit Application &rarr;
                    </button>
                </form>
                @endif

                @else
                {{-- Guest User Prompt --}}
                <div class="text-center py-6 bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700">
                    <p class="text-gray-600 dark:text-gray-300 mb-4 text-sm">You must be logged in to apply for this job.</p>
                    <a href="{{ route('login') }}" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl">
                        Log in to Apply
                    </a>
                </div>
                @endauth
            </div>

        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white dark:bg-gray-800 border-t border-gray-100 dark:border-gray-700 py-6 text-center text-sm text-gray-500">
        <p>&copy; {{ date('Y') }} HireDDesk.</p>
    </footer>

</body>

</html>