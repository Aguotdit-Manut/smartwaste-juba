<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Resident Dashboard | SmartWaste Juba Connect</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        html { scroll-behavior: smooth; }
        body { font-family: 'Manrope', ui-sans-serif, system-ui, sans-serif; }
        .forest-shell {
            position: relative;
            isolation: isolate;
            min-height: 100vh;
            background:
                linear-gradient(180deg, rgba(247,252,249,.96) 0%, rgba(238,248,242,.92) 48%, rgba(226,243,233,.96) 100%);
        }
        .forest-shell::before {
            content: '';
            position: fixed;
            inset: 0;
            z-index: -3;
            background-image: url('/images/smartwaste-forest-bg.svg');
            background-size: cover;
            background-position: center bottom;
            opacity: .58;
            filter: blur(1.5px) saturate(.92);
            transform: scale(1.03);
            pointer-events: none;
        }
        .forest-shell::after {
            content: '';
            position: fixed;
            inset: 0;
            z-index: -2;
            background: radial-gradient(circle at 50% 18%, rgba(255,255,255,.94), rgba(255,255,255,.60) 42%, rgba(221,241,229,.72) 100%);
            pointer-events: none;
        }
        .glass-panel {
            background: rgba(255,255,255,.78);
            border: 1px solid rgba(255,255,255,.72);
            box-shadow: 0 20px 60px rgba(5,65,45,.08);
            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);
        }
        .premium-shadow { box-shadow: 0 18px 55px rgba(4,63,43,.12); }
        .soft-green { box-shadow: inset 0 1px 0 rgba(255,255,255,.45), 0 18px 45px rgba(5,84,55,.13); }
    </style>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen text-slate-900 antialiased">

<div class="forest-shell min-h-screen">
<div class="relative min-h-screen lg:flex">

    {{-- Desktop Sidebar --}}
    <aside class="hidden w-72 shrink-0 flex-col bg-[#062e24]/95 text-white backdrop-blur-xl lg:flex">

        {{-- Brand --}}
        <div class="border-b border-white/10 px-6 py-6">
            <div class="flex items-center gap-3">
                <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-emerald-400 text-sm font-black text-[#062e24] shadow-lg shadow-emerald-400/20">
                    SW
                </div>

                <div>
                    <p class="font-bold tracking-tight">
                        SmartWaste Juba
                    </p>

                    <p class="text-xs text-emerald-300">
                        Connect
                    </p>
                </div>
            </div>
        </div>

        {{-- Navigation --}}
        <nav class="flex-1 px-4 py-6">

            <p class="mb-3 px-3 text-[11px] font-bold uppercase tracking-[0.18em] text-emerald-300/60">
                Main menu
            </p>

            <a href="{{ route('resident.dashboard') }}"
               class="mb-1 flex items-center gap-3 rounded-2xl bg-emerald-400 px-4 py-3.5 text-sm font-bold text-[#062e24] shadow-lg shadow-emerald-900/10">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l9-9 9 9v8a1 1 0 01-1 1h-5v-6H9v6H4a1 1 0 01-1-1v-8z"/>
                </svg>
                Dashboard
            </a>

            <div class="mb-1 flex items-center gap-3 rounded-2xl px-4 py-3.5 text-sm font-medium text-white/60">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5h10M9 9h10M9 13h10M9 17h6M5 5h.01M5 9h.01M5 13h.01M5 17h.01"/>
                </svg>
                My Requests
            </div>

            <div class="mb-1 flex items-center gap-3 rounded-2xl px-4 py-3.5 text-sm font-medium text-white/60">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <rect x="3" y="4" width="18" height="17" rx="2"/>
                    <path stroke-linecap="round" d="M8 2v4M16 2v4M3 10h18"/>
                </svg>
                Schedule
            </div>

            <div class="mb-1 flex items-center gap-3 rounded-2xl px-4 py-3.5 text-sm font-medium text-white/60">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <rect x="3" y="5" width="18" height="14" rx="2"/>
                    <path stroke-linecap="round" d="M7 15h.01M11 15h6M7 9h10"/>
                </svg>
                Payments
            </div>

            <div class="mb-1 flex items-center gap-3 rounded-2xl px-4 py-3.5 text-sm font-medium text-white/60">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 3l1.8 5.4L19 10l-5.2 1.6L12 17l-1.8-5.4L5 10l5.2-1.6L12 3z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 16l.8 2.2L22 19l-2.2.8L19 22l-.8-2.2L16 19l2.2-.8L19 16z"/>
                </svg>
                Rewards
            </div>

            <p class="mb-3 mt-8 px-3 text-[11px] font-bold uppercase tracking-[0.18em] text-emerald-300/60">
                Account
            </p>

            <div class="mb-1 flex items-center gap-3 rounded-2xl px-4 py-3.5 text-sm font-medium text-white/60">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <circle cx="12" cy="8" r="3"/>
                    <path stroke-linecap="round" d="M5 21a7 7 0 0114 0"/>
                </svg>
                Profile
            </div>

            <div class="mb-1 flex items-center gap-3 rounded-2xl px-4 py-3.5 text-sm font-medium text-white/60">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M18 8a6 6 0 00-12 0c0 7-3 7-3 9h18c0-2-3-2-3-9M10 21h4"/>
                </svg>
                Notifications
            </div>

            <div class="mb-1 flex items-center gap-3 rounded-2xl px-4 py-3.5 text-sm font-medium text-white/60">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="9"/>
                    <path stroke-linecap="round" d="M12 8v4l2.5 2.5"/>
                </svg>
                Support
            </div>
        </nav>

        {{-- User --}}
        <div class="border-t border-white/10 p-4">

            <div class="mb-4 flex items-center gap-3 rounded-2xl bg-white/5 p-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-300 font-black text-[#062e24]">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>

                <div class="min-w-0 flex-1">
                    <p class="truncate text-sm font-bold">
                        {{ $user->name }}
                    </p>

                    <p class="text-xs capitalize text-emerald-200/60">
                        {{ $user->role }}
                    </p>
                </div>
            </div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <button type="submit"
                    class="flex w-full items-center justify-center gap-2 rounded-2xl border border-white/10 px-4 py-3 text-sm font-semibold text-white/70 transition hover:bg-white/10 hover:text-white">

                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 17l5-5-5-5M15 12H3"/>
                        <path stroke-linecap="round" d="M14 5h5a2 2 0 012 2v10a2 2 0 01-2 2h-5"/>
                    </svg>

                    Sign out
                </button>
            </form>
        </div>

    </aside>


    {{-- Main --}}
    <main class="min-w-0 flex-1 pb-24 lg:pb-0">

        {{-- Mobile Header --}}
        <header class="sticky top-0 z-30 border-b border-white/70 bg-white/70 px-5 py-4 backdrop-blur-xl lg:px-8">

            <div class="flex items-center justify-between gap-4">

                <div class="flex items-center gap-3 lg:hidden">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#0b6b4e] text-sm font-black text-white">
                        SW
                    </div>

                    <div>
                        <p class="text-sm font-black text-slate-900">
                            SmartWaste
                        </p>

                        <p class="text-[11px] font-medium text-emerald-600">
                            Juba Connect
                        </p>
                    </div>
                </div>

                <div class="hidden lg:block">
                    <p class="text-sm font-semibold text-emerald-600">
                        SmartWaste Juba Connect
                    </p>

                    <h1 class="mt-0.5 text-2xl font-black tracking-tight text-slate-900">
                        Resident Dashboard
                    </h1>
                </div>

                <button type="button"
                    class="relative flex h-11 w-11 items-center justify-center rounded-2xl border border-white/80 bg-white/80 text-slate-600 shadow-sm backdrop-blur">

                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M18 8a6 6 0 00-12 0c0 7-3 7-3 9h18c0-2-3-2-3-9M10 21h4"/>
                    </svg>

                    <span class="absolute right-2 top-2 h-2 w-2 rounded-full bg-emerald-500 ring-2 ring-white"></span>
                </button>

            </div>
        </header>


        <section class="mx-auto max-w-7xl space-y-6 px-5 py-6 sm:px-8 lg:px-10 lg:py-8">

            {{-- Welcome Hero --}}
            <section class="relative overflow-hidden rounded-[2.2rem] bg-gradient-to-br from-[#063c2d]/95 via-[#08734f]/94 to-[#18a16f]/88 px-6 py-8 text-white premium-shadow sm:px-8 sm:py-10">

                <div class="absolute -right-16 -top-24 h-64 w-64 rounded-full bg-emerald-300/15 blur-3xl"></div>
                <div class="absolute -bottom-24 left-1/3 h-72 w-72 rounded-full bg-lime-300/10 blur-3xl"></div>

                <div class="relative z-10 max-w-3xl">

                    <div class="mb-4 inline-flex items-center gap-2 rounded-full border border-white/10 bg-white/10 px-3.5 py-2 text-xs font-semibold text-emerald-50 backdrop-blur">
                        <span class="h-2 w-2 rounded-full bg-lime-300"></span>
                        Keep Juba Clean, Green & Healthy
                    </div>

                    <h2 class="text-3xl font-black tracking-tight sm:text-4xl">
                        Hello, {{ $user->name }}
                    </h2>

                    <p class="mt-3 max-w-2xl text-sm leading-6 text-emerald-50/80 sm:text-base">
                        Request waste collection, track your pickups and help build cleaner neighborhoods across Juba.
                    </p>

                    <div class="mt-6 flex flex-col gap-3 sm:flex-row">

                        <a href="#pickup"
                           class="inline-flex items-center justify-center gap-2 rounded-2xl bg-white px-5 py-3.5 text-sm font-black text-[#07553e] shadow-xl shadow-black/10 transition hover:-translate-y-0.5">

                            <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" d="M12 5v14M5 12h14"/>
                            </svg>

                            Request Waste Pickup
                        </a>

                        <a href="#requests"
                           class="inline-flex items-center justify-center gap-2 rounded-2xl border border-white/15 bg-white/10 px-5 py-3.5 text-sm font-bold text-white backdrop-blur transition hover:bg-white/15">

                            View My Requests

                            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>

                    </div>
                </div>

            </section>


            {{-- Stats --}}
            <section class="grid grid-cols-2 gap-4 xl:grid-cols-4">

                <div class="rounded-3xl border border-white/80 bg-white/75 p-5 shadow-sm backdrop-blur-xl">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">
                                Total Requests
                            </p>

                            <p class="mt-2 text-3xl font-black text-slate-900">
                                {{ $totalRequests }}
                            </p>
                        </div>

                        <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-600">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                <path stroke-linecap="round" d="M9 5h10M9 9h10M9 13h10M9 17h6M5 5h.01M5 9h.01M5 13h.01M5 17h.01"/>
                            </svg>
                        </div>
                    </div>
                </div>


                <div class="rounded-3xl border border-white/80 bg-white/75 p-5 shadow-sm backdrop-blur-xl">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">
                                Active
                            </p>

                            <p class="mt-2 text-3xl font-black text-slate-900">
                                {{ $activeRequests }}
                            </p>
                        </div>

                        <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-amber-50 text-amber-600">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="8"/>
                                <path stroke-linecap="round" d="M12 8v4l2.5 2.5"/>
                            </svg>
                        </div>
                    </div>
                </div>


                <div class="rounded-3xl border border-white/80 bg-white/75 p-5 shadow-sm backdrop-blur-xl">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">
                                Completed
                            </p>

                            <p class="mt-2 text-3xl font-black text-slate-900">
                                {{ $completedRequests }}
                            </p>
                        </div>

                        <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-blue-50 text-blue-600">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 12l4 4L19 6"/>
                            </svg>
                        </div>
                    </div>
                </div>


                <div class="rounded-3xl border border-white/80 bg-white/75 p-5 shadow-sm backdrop-blur-xl">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">
                                Eco Points
                            </p>

                            <p class="mt-2 text-3xl font-black text-slate-900">
                                {{ number_format($ecoPoints) }}
                            </p>
                        </div>

                        <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-lime-50 text-lime-700">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 21c4-2 7-5.5 7-10V5l-7-3-7 3v6c0 4.5 3 8 7 10z"/>
                                <path stroke-linecap="round" d="M9 12l2 2 4-4"/>
                            </svg>
                        </div>
                    </div>
                </div>

            </section>


            {{-- Main grid --}}
            <div class="grid gap-6 xl:grid-cols-3">

                {{-- Request Pickup Card --}}
                <section id="pickup" class="xl:col-span-2">

                    <div class="relative overflow-hidden rounded-[2.2rem] border border-emerald-100/80 bg-emerald-50/78 p-6 shadow-[0_18px_55px_rgba(5,84,55,.10)] backdrop-blur-xl sm:p-8">

                        <div class="absolute -right-12 -top-12 h-40 w-40 rounded-full bg-emerald-200/40 blur-2xl"></div>

                        <div class="relative z-10">

                            <div class="flex items-start justify-between gap-5">

                                <div>
                                    <span class="inline-flex rounded-full bg-emerald-600/10 px-3 py-1 text-xs font-bold text-emerald-700">
                                        Easy • Fast • Reliable
                                    </span>

                                    <h3 class="mt-3 text-2xl font-black tracking-tight text-slate-900 sm:text-3xl">
                                        Request Waste Pickup
                                    </h3>

                                    <p class="mt-2 max-w-xl text-sm leading-6 text-slate-600">
                                        Get your household waste collected by a registered SmartWaste collector.
                                    </p>
                                </div>

                                <div class="hidden h-16 w-16 items-center justify-center rounded-3xl bg-white text-emerald-600 shadow-sm sm:flex">
                                    <svg class="h-8 w-8" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.5-9h7L20 16"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 16v2a2 2 0 002 2h8a2 2 0 002-2v-2"/>
                                        <circle cx="8" cy="16" r="1.5"/>
                                        <circle cx="16" cy="16" r="1.5"/>
                                    </svg>
                                </div>

                            </div>


                            <div class="mt-7 grid gap-3 sm:grid-cols-3">

                                <div class="rounded-2xl bg-white p-4 shadow-sm">
                                    <p class="text-xs font-bold uppercase tracking-wider text-slate-400">
                                        Step 01
                                    </p>

                                    <p class="mt-1 font-bold text-slate-900">
                                        Choose waste
                                    </p>

                                    <p class="mt-1 text-xs text-slate-500">
                                        Select your waste type.
                                    </p>
                                </div>

                                <div class="rounded-2xl bg-white p-4 shadow-sm">
                                    <p class="text-xs font-bold uppercase tracking-wider text-slate-400">
                                        Step 02
                                    </p>

                                    <p class="mt-1 font-bold text-slate-900">
                                        Set collection
                                    </p>

                                    <p class="mt-1 text-xs text-slate-500">
                                        Choose location and time.
                                    </p>
                                </div>

                                <div class="rounded-2xl bg-white p-4 shadow-sm">
                                    <p class="text-xs font-bold uppercase tracking-wider text-slate-400">
                                        Step 03
                                    </p>

                                    <p class="mt-1 font-bold text-slate-900">
                                        Confirm
                                    </p>

                                    <p class="mt-1 text-xs text-slate-500">
                                        Pay and track collection.
                                    </p>
                                </div>

                            </div>


                            <button type="button"
                                class="mt-6 inline-flex w-full items-center justify-center gap-2 rounded-2xl bg-[#0b6b4e] px-5 py-4 text-sm font-black text-white shadow-lg shadow-emerald-900/10 transition hover:-translate-y-0.5 hover:bg-[#095a42] sm:w-auto">

                                <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" d="M12 5v14M5 12h14"/>
                                </svg>

                                Request Now
                            </button>

                        </div>
                    </div>

                </section>


                {{-- Rewards --}}
                <section>

                    <div class="h-full rounded-[2rem] bg-gradient-to-br from-[#0b6b4e] to-[#083d2f] p-6 text-white shadow-xl shadow-emerald-950/10">

                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs font-bold uppercase tracking-[0.16em] text-emerald-200">
                                    Sustainability
                                </p>

                                <h3 class="mt-2 text-2xl font-black">
                                    Go Green,<br>
                                    Earn Rewards!
                                </h3>
                            </div>

                            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-white/10">
                                <svg class="h-6 w-6 text-lime-300" fill="none" stroke="currentColor" stroke-width="1.7" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 21c4-2 7-5.5 7-10V5l-7-3-7 3v6c0 4.5 3 8 7 10z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4"/>
                                </svg>
                            </div>
                        </div>

                        <div class="mt-8 rounded-2xl bg-white/10 p-4">
                            <p class="text-xs text-emerald-100/60">
                                Current eco points
                            </p>

                            <p class="mt-1 text-3xl font-black">
                                {{ number_format($ecoPoints) }}
                            </p>

                            <div class="mt-3 h-2 overflow-hidden rounded-full bg-white/10">
                                <div class="h-full w-[8%] rounded-full bg-lime-300"></div>
                            </div>

                            <p class="mt-3 text-xs text-emerald-100/60">
                                Rewards will grow as your recycling participation is recorded.
                            </p>
                        </div>

                    </div>

                </section>


                {{-- My Requests --}}
                <section id="requests" class="xl:col-span-2">

                    <div class="rounded-[2rem] border border-white/80 bg-white/78 p-6 shadow-sm backdrop-blur-xl sm:p-7">

                        <div class="flex items-center justify-between gap-4">

                            <div>
                                <p class="text-xs font-bold uppercase tracking-wider text-emerald-600">
                                    Activity
                                </p>

                                <h3 class="mt-1 text-2xl font-black tracking-tight text-slate-900">
                                    My Requests
                                </h3>
                            </div>

                            <span class="rounded-full bg-slate-100 px-3 py-1.5 text-xs font-bold text-slate-500">
                                {{ $totalRequests }} total
                            </span>

                        </div>


                        <div class="mt-6 space-y-3">

                            @forelse ($latestRequests as $request)

                                <div class="flex flex-col gap-4 rounded-2xl border border-slate-100 bg-slate-50 p-4 sm:flex-row sm:items-center sm:justify-between">

                                    <div class="flex min-w-0 items-center gap-4">

                                        <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-white text-emerald-600 shadow-sm">
                                            <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" d="M6 7h12M6 12h12M6 17h7"/>
                                            </svg>
                                        </div>

                                        <div class="min-w-0">
                                            <p class="font-bold text-slate-900">
                                                Waste Pickup #{{ $request->id }}
                                            </p>

                                            <p class="mt-1 truncate text-xs text-slate-500">
                                                {{ $request->address?->address_line ?? 'No address added yet' }}
                                            </p>

                                            <p class="mt-1 text-xs text-slate-400">
                                                {{ $request->created_at->format('d M Y, h:i A') }}
                                            </p>
                                        </div>

                                    </div>


                                    <div>
                                        @php
                                            $statusClasses = match ($request->status) {
                                                'completed' => 'bg-emerald-100 text-emerald-700',
                                                'pending' => 'bg-amber-100 text-amber-700',
                                                'assigned', 'on_the_way', 'arrived', 'collecting' => 'bg-blue-100 text-blue-700',
                                                default => 'bg-slate-100 text-slate-600',
                                            };
                                        @endphp

                                        <span class="inline-flex rounded-full px-3 py-1.5 text-xs font-bold capitalize {{ $statusClasses }}">
                                            {{ str_replace('_', ' ', $request->status) }}
                                        </span>
                                    </div>

                                </div>

                            @empty

                                <div class="rounded-3xl border border-dashed border-slate-200 bg-slate-50 p-8 text-center">

                                    <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-white text-emerald-500 shadow-sm">
                                        <svg class="h-7 w-7" fill="none" stroke="currentColor" stroke-width="1.7" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" d="M6 7h12M6 12h12M6 17h7"/>
                                        </svg>
                                    </div>

                                    <h4 class="mt-4 font-black text-slate-900">
                                        No pickup requests yet
                                    </h4>

                                    <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-slate-500">
                                        Your collection requests will appear here after you schedule your first pickup.
                                    </p>

                                </div>

                            @endforelse

                        </div>

                    </div>

                </section>


                {{-- Live Collector --}}
                <section>

                    <div class="h-full rounded-[2rem] border border-white/80 bg-white/78 p-6 shadow-sm backdrop-blur-xl sm:p-7">

                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs font-bold uppercase tracking-wider text-emerald-600">
                                    Live Tracking
                                </p>

                                <h3 class="mt-1 text-2xl font-black tracking-tight text-slate-900">
                                    Collector Nearby
                                </h3>
                            </div>

                            <span class="flex items-center gap-1.5 rounded-full bg-slate-100 px-3 py-1.5 text-xs font-bold text-slate-500">
                                <span class="h-1.5 w-1.5 rounded-full bg-slate-400"></span>
                                Offline
                            </span>
                        </div>


                        <div class="mt-6 overflow-hidden rounded-3xl bg-slate-100">

                            <div class="flex min-h-44 items-center justify-center bg-gradient-to-br from-slate-100 to-emerald-50/70">

                                <div class="text-center px-5">

                                    <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-white text-emerald-600 shadow-sm">
                                        <svg class="h-7 w-7" fill="none" stroke="currentColor" stroke-width="1.7" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 21s7-6.2 7-12a7 7 0 10-14 0c0 5.8 7 12 7 12z"/>
                                            <circle cx="12" cy="9" r="2.5"/>
                                        </svg>
                                    </div>

                                    <p class="mt-4 font-black text-slate-900">
                                        No active collector
                                    </p>

                                    <p class="mt-1 text-xs leading-5 text-slate-500">
                                        Live collector location will appear here after a request is assigned.
                                    </p>

                                </div>

                            </div>

                        </div>

                    </div>

                </section>


                {{-- Quick actions --}}
                <section class="xl:col-span-3">

                    <div class="rounded-[2rem] border border-white/80 bg-white/78 p-6 shadow-sm backdrop-blur-xl sm:p-7">

                        <div>
                            <p class="text-xs font-bold uppercase tracking-wider text-emerald-600">
                                Quick Access
                            </p>

                            <h3 class="mt-1 text-2xl font-black tracking-tight text-slate-900">
                                Everything you need
                            </h3>
                        </div>


                        <div class="mt-6 grid gap-3 sm:grid-cols-2 xl:grid-cols-4">

                            <div class="rounded-2xl border border-slate-100 bg-slate-50 p-5">
                                <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-blue-50 text-blue-600">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                        <rect x="3" y="4" width="18" height="17" rx="2"/>
                                        <path stroke-linecap="round" d="M8 2v4M16 2v4M3 10h18"/>
                                    </svg>
                                </div>

                                <p class="mt-4 font-black text-slate-900">
                                    Schedule
                                </p>

                                <p class="mt-1 text-xs leading-5 text-slate-500">
                                    Manage one-time and recurring collection times.
                                </p>
                            </div>


                            <div class="rounded-2xl border border-slate-100 bg-slate-50 p-5">
                                <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-violet-50 text-violet-600">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                        <rect x="3" y="5" width="18" height="14" rx="2"/>
                                        <path stroke-linecap="round" d="M7 15h.01M11 15h6M7 9h10"/>
                                    </svg>
                                </div>

                                <p class="mt-4 font-black text-slate-900">
                                    Payments
                                </p>

                                <p class="mt-1 text-xs leading-5 text-slate-500">
                                    View collection charges and payment history.
                                </p>
                            </div>


                            <div class="rounded-2xl border border-slate-100 bg-slate-50 p-5">
                                <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-lime-50 text-lime-700">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" d="M12 3v18M5 8h14M5 16h14"/>
                                    </svg>
                                </div>

                                <p class="mt-4 font-black text-slate-900">
                                    Recycling
                                </p>

                                <p class="mt-1 text-xs leading-5 text-slate-500">
                                    See how your waste contributes to recovery and recycling.
                                </p>
                            </div>


                            <div class="rounded-2xl border border-slate-100 bg-slate-50 p-5">
                                <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-amber-50 text-amber-600">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                        <circle cx="12" cy="12" r="9"/>
                                        <path stroke-linecap="round" d="M12 8v4M12 16h.01"/>
                                    </svg>
                                </div>

                                <p class="mt-4 font-black text-slate-900">
                                    Support
                                </p>

                                <p class="mt-1 text-xs leading-5 text-slate-500">
                                    Get help with pickups, payments and your account.
                                </p>
                            </div>

                        </div>

                    </div>

                </section>


                {{-- Address --}}
                <section class="xl:col-span-3">

                    <div class="flex flex-col gap-5 rounded-[2rem] border border-white/80 bg-white/78 p-6 shadow-sm backdrop-blur-xl sm:flex-row sm:items-center sm:justify-between sm:p-7">

                        <div class="flex items-center gap-4">

                            <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-600">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.7" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 21s7-6.2 7-12a7 7 0 10-14 0c0 5.8 7 12 7 12z"/>
                                    <circle cx="12" cy="9" r="2.5"/>
                                </svg>
                            </div>

                            <div>
                                <p class="text-xs font-bold uppercase tracking-wider text-slate-400">
                                    Collection address
                                </p>

                                <p class="mt-1 font-bold text-slate-900">
                                    {{ $defaultAddress?->address_line ?? 'No pickup address added yet' }}
                                </p>

                                <p class="mt-1 text-xs text-slate-500">
                                    {{ $defaultAddress?->area ?? 'Add your area when creating your first pickup.' }}
                                </p>
                            </div>

                        </div>

                        <span class="inline-flex w-fit rounded-full bg-emerald-50 px-3 py-1.5 text-xs font-bold text-emerald-700">
                            {{ $defaultAddress ? 'Ready for pickup' : 'Address needed' }}
                        </span>

                    </div>

                </section>

            </div>

        </section>

    </main>


    {{-- Mobile Bottom Navigation --}}
    <nav class="fixed inset-x-0 bottom-0 z-40 border-t border-white/80 bg-white/78 px-3 pb-[env(safe-area-inset-bottom)] pt-2 backdrop-blur lg:hidden">

        <div class="mx-auto flex max-w-lg items-end justify-around">

            <a href="{{ route('resident.dashboard') }}"
               class="flex w-16 flex-col items-center gap-1.5 py-1.5 text-emerald-600">

                <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l9-9 9 9v8a1 1 0 01-1 1h-5v-6H9v6H4a1 1 0 01-1-1v-8z"/>
                </svg>

                <span class="text-[10px] font-bold">
                    Home
                </span>
            </a>


            <a href="#requests"
               class="flex w-16 flex-col items-center gap-1.5 py-1.5 text-slate-400">

                <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" d="M9 5h10M9 9h10M9 13h10M9 17h6M5 5h.01M5 9h.01M5 13h.01M5 17h.01"/>
                </svg>

                <span class="text-[10px] font-bold">
                    Requests
                </span>
            </a>


            <a href="#pickup"
               class="-mt-7 flex h-14 w-14 items-center justify-center rounded-2xl bg-[#0b6b4e] text-white shadow-xl shadow-emerald-900/20 ring-4 ring-white">

                <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" d="M12 5v14M5 12h14"/>
                </svg>
            </a>


            <a href="#requests"
               class="flex w-16 flex-col items-center gap-1.5 py-1.5 text-slate-400">

                <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 4h12v16H6z"/>
                    <path stroke-linecap="round" d="M9 8h6M9 12h6M9 16h4"/>
                </svg>

                <span class="text-[10px] font-bold">
                    History
                </span>
            </a>


            <button type="button"
                    class="flex w-16 flex-col items-center gap-1.5 py-1.5 text-slate-400">

                <div class="flex h-5 w-5 items-center justify-center rounded-full bg-slate-200 text-[10px] font-black text-slate-500">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>

                <span class="text-[10px] font-bold">
                    Profile
                </span>
            </button>

        </div>

    </nav>

</div>
</div>

</body>
</html>