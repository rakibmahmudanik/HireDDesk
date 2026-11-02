<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Create your Account - HireDDesk</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100 min-h-screen flex flex-col justify-center items-center py-12 px-4">

    <div class="mb-6 text-center">
        <a href="{{ route('home') }}" class="text-3xl font-black text-indigo-600 dark:text-indigo-400">
            Hire<span class="text-gray-900 dark:text-white">D</span>Desk
        </a>
        <p class="text-sm text-gray-500 mt-2">Join the next-generation remote hiring platform</p>
    </div>

    <div class="w-full max-w-md bg-white dark:bg-gray-800 rounded-3xl p-8 border border-gray-100 dark:border-gray-700 shadow-xl">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Create Account</h2>

        <form method="POST" action="{{ route('register') }}" class="space-y-4">
            @csrf

            <!-- Role Selection -->
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400 mb-2">
                    I want to
                </label>
                <div class="grid grid-cols-2 gap-3">
                    <label class="cursor-pointer">
                        <input type="radio" name="role" value="candidate" class="peer sr-only" checked />
                        <div class="p-3 text-center rounded-xl border border-gray-200 dark:border-gray-700 peer-checked:border-indigo-600 peer-checked:bg-indigo-50/50 dark:peer-checked:bg-indigo-950/40 peer-checked:text-indigo-600 dark:peer-checked:text-indigo-400 font-semibold text-sm transition">
                            💼 Find a Job
                        </div>
                    </label>
                    <label class="cursor-pointer">
                        <input type="radio" name="role" value="employer" class="peer sr-only" {{ old('role') === 'employer' ? 'checked' : '' }} />
                        <div class="p-3 text-center rounded-xl border border-gray-200 dark:border-gray-700 peer-checked:border-indigo-600 peer-checked:bg-indigo-50/50 dark:peer-checked:bg-indigo-950/40 peer-checked:text-indigo-600 dark:peer-checked:text-indigo-400 font-semibold text-sm transition">
                            🏢 Hire Talent
                        </div>
                    </label>
                </div>
            </div>

            <!-- Full Name -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Full Name</label>
                <input type="text" name="name" value="{{ old('name') }}" required autofocus
                    class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 text-sm focus:border-indigo-500 focus:ring-indigo-500" />
                @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Email Address</label>
                <input type="email" name="email" value="{{ old('email') }}" required
                    class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 text-sm focus:border-indigo-500 focus:ring-indigo-500" />
                @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Password</label>
                <input type="password" name="password" required
                    class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 text-sm focus:border-indigo-500 focus:ring-indigo-500" />
                @error('password')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Confirm Password</label>
                <input type="password" name="password_confirmation" required
                    class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 text-sm focus:border-indigo-500 focus:ring-indigo-500" />
            </div>

            <button type="submit" class="w-full py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl shadow transition mt-2">
                Create Account &rarr;
            </button>

            <div class="text-center mt-4">
                <p class="text-sm text-gray-500">
                    Already have an account? 
                    <a href="{{ route('login') }}" class="text-indigo-600 dark:text-indigo-400 font-semibold hover:underline">Log in</a>
                </p>
            </div>
        </form>
    </div>

</body>
</html>