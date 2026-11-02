<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>HireDDesk - Find Remote Work Worldwide</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100 antialiased font-sans min-h-screen flex flex-col">

    <!-- Top Navigation Bar -->
    <header class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700 sticky top-0 z-50">
        <div class="max-w-6xl mx-auto px-4 h-16 flex items-center justify-between">
            <a href="{{ route('home') }}" class="text-2xl font-black tracking-tight text-indigo-600 dark:text-indigo-400">
                Hire<span class="text-gray-900 dark:text-white">D</span>Desk
            </a>

            <div class="flex items-center gap-4">
                @auth
                    <a href="{{ url('/dashboard') }}" class="text-sm font-semibold text-gray-700 dark:text-gray-200 hover:text-indigo-600">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="text-sm font-semibold text-gray-700 dark:text-gray-200 hover:text-indigo-600">
                        Log in
                    </a>
                    <a href="{{ route('register') }}" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl transition">
                        Register
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="bg-gradient-to-b from-indigo-50/50 dark:from-indigo-950/20 to-transparent py-16 px-4 text-center">
        <div class="max-w-3xl mx-auto">
            <span class="px-3 py-1 bg-indigo-100 dark:bg-indigo-900/50 text-indigo-700 dark:text-indigo-300 rounded-full text-xs font-bold uppercase tracking-wider">
                Remote-first hiring platform
            </span>
            <h1 class="text-4xl sm:text-5xl font-extrabold text-gray-900 dark:text-white mt-4 tracking-tight leading-tight">
                Find your dream remote desk anywhere in the world.
            </h1>
            <p class="text-lg text-gray-600 dark:text-gray-300 mt-4">
                Explore high-paying tech, design, and engineering roles from top companies worldwide.
            </p>
        </div>
    </section>

    <!-- Main Content: Job Listings -->
    <main class="max-w-5xl mx-auto px-4 py-8 flex-1 w-full">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white">
                Latest Remote Openings ({{ $jobs->total() }})
            </h2>
        </div>

        <!-- Loop through jobs using Blade component -->
        <div class="space-y-4">
            @forelse($jobs as $job)
                <x-job-card :job="$job" />
            @empty
                <div class="text-center py-12 bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700">
                    <p class="text-gray-500">No jobs posted yet. Check back soon!</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $jobs->links() }}
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white dark:bg-gray-800 border-t border-gray-100 dark:border-gray-700 py-6 text-center text-sm text-gray-500">
        <p>&copy; {{ date('Y') }} HireDDesk. Built with Laravel & Blade.</p>
    </footer>

</body>
</html>