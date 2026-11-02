@props(['job'])

<div class="p-6 bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 hover:shadow-lg hover:border-indigo-200 dark:hover:border-indigo-500 transition duration-200 flex flex-col md:flex-row md:items-center justify-between gap-4 {{ $job->is_featured ? 'ring-2 ring-indigo-500/20 bg-indigo-50/20 dark:bg-indigo-950/20' : '' }}">
    <div class="flex items-start gap-4">
        <!-- Company Logo / Initials Placeholder -->
        <div class="w-12 h-12 rounded-xl bg-indigo-600 text-white font-bold flex items-center justify-center text-lg shadow-sm shrink-0">
            {{ strtoupper(substr($job->company->name, 0, 1)) }}
        </div>

        <div>
            <div class="flex items-center gap-2 flex-wrap">
                <span class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                    {{ $job->company->name }}
                </span>

                @if($job->is_featured)
                    <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800 dark:bg-amber-900/40 dark:text-amber-300">
                        ⭐ Featured
                    </span>
                @endif
            </div>

            <h3 class="text-lg font-bold text-gray-900 dark:text-white mt-1 hover:text-indigo-600 dark:hover:text-indigo-400 transition">
                <a href="{{ route('jobs.show', $job->slug) }}">
                    {{ $job->title }}
                </a>
            </h3>

            <div class="flex items-center gap-4 mt-2 text-sm text-gray-500 dark:text-gray-400 flex-wrap">
                <span class="flex items-center gap-1">
                    📍 {{ $job->location }}
                </span>
                <span class="flex items-center gap-1">
                    💼 {{ $job->type }}
                </span>
                @if($job->salary_min && $job->salary_max)
                    <span class="flex items-center gap-1 text-emerald-600 dark:text-emerald-400 font-medium">
                        💰 ${{ number_format($job->salary_min) }} - ${{ number_format($job->salary_max) }}/yr
                    </span>
                @endif
            </div>
        </div>
    </div>

    <div class="flex items-center gap-3 self-end md:self-center">
        <a href="{{ route('jobs.show', $job->slug) }}" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl shadow-sm transition">
            Apply Now
        </a>
    </div>
</div>