<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Log In - HireDDesk</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100 min-h-screen flex flex-col justify-center items-center py-12 px-4">

    <!-- Logo -->
    <div class="mb-6 text-center">
        <a href="{{ route('home') }}" class="text-3xl font-black text-indigo-600 dark:text-indigo-400">
            Hire<span class="text-gray-900 dark:text-white">D</span>Desk
        </a>
        <p class="text-sm text-gray-500 mt-2">Welcome back to your remote workspace</p>
    </div>

    <!-- Login Card -->
    <div class="w-full max-w-md bg-white dark:bg-gray-800 rounded-3xl p-8 border border-gray-100 dark:border-gray-700 shadow-xl">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Log in to Account</h2>

        <!-- Session Status (যেমন: পাসওয়ার্ড রিসেট লিংক পাঠানো হলে) -->
        @if (session('status'))
            <div class="mb-4 text-sm font-medium text-emerald-600 dark:text-emerald-400">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf

            <!-- Email Address -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Email Address</label>
                <input type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                    class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 text-sm focus:border-indigo-500 focus:ring-indigo-500" />
                @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div>
                <div class="flex items-center justify-between mb-1">
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">Password</label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-xs text-indigo-600 dark:text-indigo-400 hover:underline">
                            Forgot password?
                        </a>
                    @endif
                </div>
                <input type="password" name="password" required autocomplete="current-password"
                    class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 text-sm focus:border-indigo-500 focus:ring-indigo-500" />
                @error('password')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Remember Me -->
            <div class="flex items-center">
                <input id="remember_me" type="checkbox" name="remember"
                    class="rounded border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-offset-gray-800" />
                <label for="remember_me" class="ms-2 text-sm text-gray-600 dark:text-gray-400">Remember me</label>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="w-full py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl shadow transition mt-2">
                Log In &rarr;
            </button>

            <!-- Register Link -->
            <div class="text-center mt-6">
                <p class="text-sm text-gray-500">
                    Don't have an account yet? 
                    <a href="{{ route('register') }}" class="text-indigo-600 dark:text-indigo-400 font-semibold hover:underline">Create one</a>
                </p>
            </div>
        </form>
    </div>

</body>
</html>