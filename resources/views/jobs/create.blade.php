<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Post a New Remote Job - HireDDesk</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100 min-h-screen py-10 px-4">

    <div class="max-w-2xl mx-auto">
        <div class="flex items-center justify-between mb-8">
            <a href="{{ route('dashboard') }}" class="text-sm font-semibold text-indigo-600 dark:text-indigo-400 hover:underline">
                &larr; Back to Dashboard
            </a>
            <span class="text-xs font-bold uppercase tracking-wider text-gray-500">Employer Portal</span>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-3xl p-8 border border-gray-100 dark:border-gray-700 shadow-xl">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Post a New Job Opening</h1>
            <p class="text-sm text-gray-500 mb-6">Reach thousands of remote developers, designers, and managers.</p>

            <form action="{{ route('jobs.store') }}" method="POST" class="space-y-5">
                @csrf

                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Company Name</label>
                    <input type="text" name="company_name" value="{{ Auth::user()->company->name ?? old('company_name') }}" required
                        class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 text-sm focus:border-indigo-500 focus:ring-indigo-500" />
                    @error('company_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Job Title</label>
                    <input type="text" name="title" placeholder="e.g. Senior Laravel Engineer" value="{{ old('title') }}" required
                        class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 text-sm focus:border-indigo-500 focus:ring-indigo-500" />
                    @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Location / Remote Policy</label>
                        <input type="text" name="location" placeholder="e.g. Remote (Worldwide)" value="{{ old('location', 'Remote (Worldwide)') }}" required
                            class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 text-sm focus:border-indigo-500 focus:ring-indigo-500" />
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Job Type</label>
                        <select name="type" class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="Full-time">Full-time</option>
                            <option value="Part-time">Part-time</option>
                            <option value="Contract">Contract</option>
                            <option value="Internship">Internship</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Min Salary ($/yr)</label>
                        <input type="number" name="salary_min" placeholder="50000" value="{{ old('salary_min') }}"
                            class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 text-sm focus:border-indigo-500 focus:ring-indigo-500" />
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Max Salary ($/yr)</label>
                        <input type="number" name="salary_max" placeholder="80000" value="{{ old('salary_max') }}"
                            class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 text-sm focus:border-indigo-500 focus:ring-indigo-500" />
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Job Description & Requirements</label>
                    <textarea name="description" rows="5" required placeholder="Describe responsibilities, stack, perks..."
                        class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 text-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('description') }}</textarea>
                    @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="flex items-center">
                    <input id="is_featured" type="checkbox" name="is_featured" value="1"
                        class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" />
                    <label for="is_featured" class="ms-2 text-sm text-gray-600 dark:text-gray-400">
                        ⭐ Highlight this job as Featured on the homepage
                    </label>
                </div>

                <button type="submit" class="w-full py-3.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl shadow transition">
                    Publish Job Listing &rarr;
                </button>
            </form>
        </div>
    </div>

</body>
</html>