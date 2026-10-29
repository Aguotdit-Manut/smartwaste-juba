<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login | SmartWaste Juba Connect</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-slate-950">

<div class="min-h-screen lg:grid lg:grid-cols-2">

    <section class="hidden lg:flex relative overflow-hidden bg-gradient-to-br from-emerald-950 via-green-900 to-slate-950 p-12 text-white">
        <div class="absolute -right-20 -top-20 h-72 w-72 rounded-full bg-emerald-400/20 blur-3xl"></div>
        <div class="absolute -bottom-20 -left-20 h-72 w-72 rounded-full bg-lime-300/10 blur-3xl"></div>

        <div class="relative z-10 flex max-w-xl flex-col justify-between">
            <div>
                <div class="mb-10 flex items-center gap-3">
                    <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-white/10 ring-1 ring-white/20">
                        <span class="text-xl font-black text-emerald-300">SW</span>
                    </div>

                    <div>
                        <p class="font-bold tracking-wide">SmartWaste</p>
                        <p class="text-sm text-emerald-200">Juba Connect</p>
                    </div>
                </div>

                <p class="mb-5 inline-flex rounded-full bg-white/10 px-4 py-2 text-sm text-emerald-100 ring-1 ring-white/10">
                    Keep Juba Clean, Green & Healthy
                </p>

                <h1 class="text-5xl font-black leading-tight">
                    Request. Collect.
                    <span class="text-emerald-300">Recycle.</span>
                    Sustain.
                </h1>

                <p class="mt-6 max-w-lg text-lg leading-8 text-slate-300">
                    A connected waste collection and recycling platform for cleaner neighborhoods and more efficient waste services in Juba.
                </p>
            </div>

            <div class="grid grid-cols-3 gap-4">
                <div class="rounded-2xl bg-white/10 p-4 ring-1 ring-white/10">
                    <p class="text-2xl font-black">01</p>
                    <p class="mt-1 text-sm text-slate-300">Easy Pickup</p>
                </div>

                <div class="rounded-2xl bg-white/10 p-4 ring-1 ring-white/10">
                    <p class="text-2xl font-black">02</p>
                    <p class="mt-1 text-sm text-slate-300">Smart Routing</p>
                </div>

                <div class="rounded-2xl bg-white/10 p-4 ring-1 ring-white/10">
                    <p class="text-2xl font-black">03</p>
                    <p class="mt-1 text-sm text-slate-300">Recycling</p>
                </div>
            </div>
        </div>
    </section>

    <section class="flex min-h-screen items-center justify-center bg-slate-100 px-5 py-10 sm:px-8">
        <div class="w-full max-w-md">

            <div class="mb-8 lg:hidden">
                <div class="flex items-center gap-3">
                    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-emerald-600 text-sm font-black text-white">
                        SW
                    </div>

                    <div>
                        <p class="font-bold text-slate-900">SmartWaste Juba</p>
                        <p class="text-xs text-slate-500">Connect</p>
                    </div>
                </div>
            </div>

            <div class="rounded-3xl bg-white p-7 shadow-xl shadow-slate-200/60 ring-1 ring-slate-200 sm:p-9">

                <div class="mb-8">
                    <p class="text-sm font-semibold text-emerald-600">Welcome back</p>

                    <h2 class="mt-2 text-3xl font-black text-slate-900">
                        Sign in to your account
                    </h2>

                    <p class="mt-2 text-sm text-slate-500">
                        Access your SmartWaste Juba Connect dashboard.
                    </p>
                </div>

                @if ($errors->any())
                    <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login.submit') }}" class="space-y-5">
                    @csrf

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
                            autofocus
                            class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3.5 text-slate-900 outline-none transition focus:border-emerald-500 focus:bg-white focus:ring-4 focus:ring-emerald-500/10"
                            placeholder="you@example.com"
                        >
                    </div>

                    <div>
                        <div class="mb-2 flex items-center justify-between">
                            <label for="password" class="block text-sm font-semibold text-slate-700">
                                Password
                            </label>

                            <span class="text-xs text-slate-400">
                                Secure login
                            </span>
                        </div>

                        <input
                            id="password"
                            name="password"
                            type="password"
                            required
                            class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3.5 text-slate-900 outline-none transition focus:border-emerald-500 focus:bg-white focus:ring-4 focus:ring-emerald-500/10"
                            placeholder="••••••••"
                        >
                    </div>

                    <label class="flex items-center gap-3 text-sm text-slate-600">
                        <input
                            type="checkbox"
                            name="remember"
                            value="1"
                            class="h-4 w-4 rounded border-slate-300 text-emerald-600 focus:ring-emerald-500"
                        >
                        Remember me
                    </label>

                    <button
                        type="submit"
                        class="w-full rounded-2xl bg-emerald-600 px-5 py-3.5 font-bold text-white shadow-lg shadow-emerald-600/20 transition hover:bg-emerald-700 hover:-translate-y-0.5"
                    >
                        Sign In
                    </button>
                </form>

                <div class="my-7 flex items-center gap-4">
                    <div class="h-px flex-1 bg-slate-200"></div>
                    <span class="text-xs text-slate-400">OR</span>
                    <div class="h-px flex-1 bg-slate-200"></div>
                </div>

                <p class="text-center text-sm text-slate-500">
                    Don't have an account?
                    <a href="{{ route('register') }}" class="font-bold text-emerald-600 hover:text-emerald-700">
                        Create one
                    </a>
                </p>

            </div>

            <p class="mt-6 text-center text-xs text-slate-400">
                SmartWaste Juba Connect • Local Development
            </p>

        </div>
    </section>

</div>

</body>
</html>