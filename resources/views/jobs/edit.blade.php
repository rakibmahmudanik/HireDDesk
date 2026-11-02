<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Edit Job: {{ $job->title }} - HireDDesk</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100 min-h-screen py-10 px-4">

  <div class="max-w-2xl mx-auto">
    <div class="flex items-center justify-between mb-8">
      <a href="{{ route('dashboard') }}" class="text-sm font-semibold text-indigo-600 dark:text-indigo-400 hover:underline">
        &larr; Back to Dashboard
      </a>
      <span class="text-xs font-bold uppercase tracking-wider text-gray-500">Edit Listing</span>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-3xl p-8 border border-gray-100 dark:border-gray-700 shadow-xl">
      <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Edit Job Posting</h1>
      <p class="text-sm text-gray-500 mb-6">Update the role details, requirements, or listing status.</p>

      <form action="{{ route('jobs.update', $job->slug) }}" method="POST" class="space-y-5">
        @csrf
        @method('PUT')

        <!-- Title -->
        <div>
          <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Job Title</label>
          <input type="text" name="title" value="{{ old('title', $job->title) }}" required
            class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 text-sm focus:border-indigo-500 focus:ring-indigo-500" />
          @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <!-- Location -->
          <div>
            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Location / Remote Policy</label>
            <input type="text" name="location" value="{{ old('location', $job->location) }}" required
              class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 text-sm focus:border-indigo-500 focus:ring-indigo-500" />
          </div>

          <!-- Job Type -->
          <div>
            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Job Type</label>
            <select name="type" class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 text-sm focus:border-indigo-500 focus:ring-indigo-500">
              <option value="Full-time" {{ old('type', $job->type) === 'Full-time' ? 'selected' : '' }}>Full-time</option>
              <option value="Part-time" {{ old('type', $job->type) === 'Part-time' ? 'selected' : '' }}>Part-time</option>
              <option value="Contract" {{ old('type', $job->type) === 'Contract' ? 'selected' : '' }}>Contract</option>
              <option value="Internship" {{ old('type', $job->type) === 'Internship' ? 'selected' : '' }}>Internship</option>
            </select>
          </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <!-- Min Salary -->
          <div>
            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Min Salary ($/yr)</label>
            <input type="number" name="salary_min" value="{{ old('salary_min', $job->salary_min) }}"
              class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 text-sm focus:border-indigo-500 focus:ring-indigo-500" />
          </div>

          <!-- Max Salary -->
          <div>
            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Max Salary ($/yr)</label>
            <input type="number" name="salary_max" value="{{ old('salary_max', $job->salary_max) }}"
              class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 text-sm focus:border-indigo-500 focus:ring-indigo-500" />
          </div>
        </div>

        <!-- Status (Active / Closed) -->
        <div>
          <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Listing Status</label>
          <select name="status" class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 text-sm focus:border-indigo-500 focus:ring-indigo-500">
            <option value="active" {{ old('status', $job->status) === 'active' ? 'selected' : '' }}>🟢 Active (Accepting Applicants)</option>
            <option value="closed" {{ old('status', $job->status) === 'closed' ? 'selected' : '' }}>🔴 Closed (Hide from Public Search)</option>
          </select>
        </div>

        <!-- Description -->
        <div>
          <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Job Description</label>
          <textarea name="description" rows="6" required
            class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 text-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('description', $job->description) }}</textarea>
          @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- Featured Toggle -->
        <div class="flex items-center">
          <input id="is_featured" type="checkbox" name="is_featured" value="1" {{ old('is_featured', $job->is_featured) ? 'checked' : '' }}
            class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" />
          <label for="is_featured" class="ms-2 text-sm text-gray-600 dark:text-gray-400">
            ⭐ Highlight this job as Featured on the homepage
          </label>
        </div>

        <div class="flex items-center justify-between gap-4 pt-2">
          <a href="{{ route('dashboard') }}" class="px-5 py-3 border border-gray-300 dark:border-gray-600 rounded-xl text-sm font-semibold hover:bg-gray-100 dark:hover:bg-gray-700 transition">
            Cancel
          </a>
          <button type="submit" class="flex-1 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl shadow transition">
            Save Changes &rarr;
          </button>
        </div>
      </form>
    </div>
  </div>

</body>

</html>