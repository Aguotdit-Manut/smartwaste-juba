<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Register | SmartWaste Juba Connect</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-slate-950">

<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-slate-950 via-green-950 to-emerald-950 px-5 py-10">

    <div class="w-full max-w-2xl">

        <div class="mb-7 text-center text-white">
            <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-2xl bg-emerald-500 text-lg font-black shadow-lg shadow-emerald-500/20">
                SW
            </div>

            <h1 class="text-3xl font-black">
                Create your SmartWaste account
            </h1>

            <p class="mt-2 text-sm text-emerald-100">
                Join SmartWaste Juba Connect
            </p>
        </div>

        <div class="rounded-3xl bg-white p-7 shadow-2xl shadow-black/20 sm:p-10">

            <div class="mb-7">
                <h2 class="text-2xl font-black text-slate-900">
                    Resident registration
                </h2>

                <p class="mt-2 text-sm text-slate-500">
                    New public registrations are created as resident accounts.
                </p>
            </div>

            @if ($errors->any())
                <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">
                    <ul class="space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register.submit') }}" class="grid gap-5 sm:grid-cols-2">
                @csrf

                <div class="sm:col-span-2">
                    <label for="name" class="mb-2 block text-sm font-semibold text-slate-700">
                        Full name
                    </label>

                    <input
                        id="name"
                        name="name"
                        type="text"
                        value="{{ old('name') }}"
                        required
                        class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3.5 outline-none transition focus:border-emerald-500 focus:bg-white focus:ring-4 focus:ring-emerald-500/10"
                        placeholder="Enter your full name"
                    >
                </div>

                <div>
                    <label for="phone" class="mb-2 block text-sm font-semibold text-slate-700">
                        Phone number
                    </label>

                    <input
                        id="phone"
                        name="phone"
                        type="text"
                        value="{{ old('phone') }}"
                        required
                        class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3.5 outline-none transition focus:border-emerald-500 focus:bg-white focus:ring-4 focus:ring-emerald-500/10"
                        placeholder="+211 ..."
                    >
                </div>

                <div>
                    <label for="email" class="mb-2 block text-sm font-semibold text-slate-700">
                        Email address
                    </label>

                    <input
                        id="email"
                        name="email"
                        type="email"
                        value="{{ old('email') }}"
                        required
                        class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3.5 outline-none transition focus:border-emerald-500 focus:bg-white focus:ring-4 focus:ring-emerald-500/10"
                        placeholder="you@example.com"
                    >
                </div>

                <div>
                    <label for="password" class="mb-2 block text-sm font-semibold text-slate-700">
                        Password
                    </label>

                    <input
                        id="password"
                        name="password"
                        type="password"
                        required
                        class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3.5 outline-none transition focus:border-emerald-500 focus:bg-white focus:ring-4 focus:ring-emerald-500/10"
                        placeholder="Minimum 8 characters"
                    >
                </div>

                <div>
                    <label for="password_confirmation" class="mb-2 block text-sm font-semibold text-slate-700">
                        Confirm password
                    </label>

                    <input
                        id="password_confirmation"
                        name="password_confirmation"
                        type="password"
                        required
                        class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3.5 outline-none transition focus:border-emerald-500 focus:bg-white focus:ring-4 focus:ring-emerald-500/10"
                        placeholder="Repeat your password"
                    >
                </div>

                <div class="sm:col-span-2 rounded-2xl bg-emerald-50 p-4 text-sm text-emerald-800">
                    Your account will be registered as a <strong>Resident</strong>. Collector, Recycling Hub and Administrator accounts will be controlled separately.
                </div>

                <div class="sm:col-span-2">
                    <button
                        type="submit"
                        class="w-full rounded-2xl bg-emerald-600 px-5 py-3.5 font-bold text-white shadow-lg shadow-emerald-600/20 transition hover:bg-emerald-700 hover:-translate-y-0.5"
                    >
                        Create Account
                    </button>
                </div>
            </form>

            <p class="mt-7 text-center text-sm text-slate-500">
                Already have an account?
                <a href="{{ route('login') }}" class="font-bold text-emerald-600 hover:text-emerald-700">
                    Sign in
                </a>
            </p>

        </div>

    </div>

</div>

</body>
</html>