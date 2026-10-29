<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $roleTitle }} | SmartWaste Juba Connect</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-slate-100">

<div class="min-h-screen lg:flex">

    <aside class="hidden w-72 flex-col bg-slate-950 text-white lg:flex">
        <div class="border-b border-white/10 p-6">
            <div class="flex items-center gap-3">
                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-emerald-500 font-black">
                    SW
                </div>

                <div>
                    <p class="font-bold">SmartWaste Juba</p>
                    <p class="text-xs text-emerald-300">Connect</p>
                </div>
            </div>
        </div>

        <nav class="flex-1 p-4">
            <div class="rounded-2xl bg-white/10 px-4 py-3 text-sm font-semibold text-emerald-300">
                Dashboard
            </div>

            <div class="mt-2 space-y-1 text-sm text-slate-400">
                <div class="rounded-2xl px-4 py-3">Requests</div>
                <div class="rounded-2xl px-4 py-3">Schedule</div>
                <div class="rounded-2xl px-4 py-3">Payments</div>
                <div class="rounded-2xl px-4 py-3">Support</div>
            </div>
        </nav>

        <div class="border-t border-white/10 p-4">
            <div class="mb-3 px-3">
                <p class="text-sm font-semibold">{{ auth()->user()->name }}</p>
                <p class="text-xs capitalize text-slate-400">{{ $role }}</p>
            </div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <button
                    type="submit"
                    class="w-full rounded-2xl bg-white/10 px-4 py-3 text-sm font-semibold transition hover:bg-red-500/20 hover:text-red-300"
                >
                    Sign Out
                </button>
            </form>
        </div>
    </aside>

    <main class="flex-1">

        <header class="border-b border-slate-200 bg-white px-5 py-5 sm:px-8">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <p class="text-sm font-semibold text-emerald-600">
                        SmartWaste Juba Connect
                    </p>

                    <h1 class="mt-1 text-2xl font-black text-slate-900 sm:text-3xl">
                        {{ $roleTitle }}
                    </h1>
                </div>

                <div class="hidden rounded-2xl bg-slate-100 px-4 py-3 sm:block">
                    <p class="text-xs text-slate-500">Signed in as</p>
                    <p class="text-sm font-bold capitalize text-slate-800">
                        {{ $role }}
                    </p>
                </div>
            </div>
        </header>

        <section class="p-5 sm:p-8">

            <div class="rounded-3xl bg-gradient-to-r from-emerald-900 via-green-800 to-emerald-700 p-6 text-white shadow-xl shadow-emerald-900/10 sm:p-8">
                <p class="text-sm font-semibold text-emerald-200">
                    Welcome, {{ auth()->user()->name }}
                </p>

                <h2 class="mt-2 text-3xl font-black">
                    Your SmartWaste workspace is ready.
                </h2>

                <p class="mt-3 max-w-2xl text-sm leading-6 text-emerald-50/80">
                    Authentication and role-based access are now connected to your Laravel and MySQL backend.
                </p>
            </div>

            <div class="mt-6 grid gap-5 sm:grid-cols-2 xl:grid-cols-4">

                @if ($role === 'resident')
                    <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
                        <p class="text-sm font-semibold text-slate-500">Pickup</p>
                        <p class="mt-2 text-xl font-black text-slate-900">Request Waste Pickup</p>
                    </div>

                    <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
                        <p class="text-sm font-semibold text-slate-500">Schedule</p>
                        <p class="mt-2 text-xl font-black text-slate-900">Manage Collection</p>
                    </div>

                    <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
                        <p class="text-sm font-semibold text-slate-500">Payments</p>
                        <p class="mt-2 text-xl font-black text-slate-900">Mobile Money</p>
                    </div>

                    <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
                        <p class="text-sm font-semibold text-slate-500">Impact</p>
                        <p class="mt-2 text-xl font-black text-slate-900">Go Green & Earn</p>
                    </div>

                @elseif ($role === 'collector')
                    <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
                        <p class="text-sm font-semibold text-slate-500">Jobs</p>
                        <p class="mt-2 text-xl font-black text-slate-900">Pickup Requests</p>
                    </div>

                    <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
                        <p class="text-sm font-semibold text-slate-500">Routing</p>
                        <p class="mt-2 text-xl font-black text-slate-900">AI Route Planning</p>
                    </div>

                    <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
                        <p class="text-sm font-semibold text-slate-500">Location</p>
                        <p class="mt-2 text-xl font-black text-slate-900">Live Tracking</p>
                    </div>

                    <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
                        <p class="text-sm font-semibold text-slate-500">Earnings</p>
                        <p class="mt-2 text-xl font-black text-slate-900">Collector Earnings</p>
                    </div>

                @elseif ($role === 'hub')
                    <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
                        <p class="text-sm font-semibold text-slate-500">Intake</p>
                        <p class="mt-2 text-xl font-black text-slate-900">Waste Receiving</p>
                    </div>

                    <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
                        <p class="text-sm font-semibold text-slate-500">Sorting</p>
                        <p class="mt-2 text-xl font-black text-slate-900">Material Sorting</p>
                    </div>

                    <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
                        <p class="text-sm font-semibold text-slate-500">Inventory</p>
                        <p class="mt-2 text-xl font-black text-slate-900">Recyclable Materials</p>
                    </div>

                    <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
                        <p class="text-sm font-semibold text-slate-500">Compost</p>
                        <p class="mt-2 text-xl font-black text-slate-900">Organic Processing</p>
                    </div>

                @else
                    <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
                        <p class="text-sm font-semibold text-slate-500">Users</p>
                        <p class="mt-2 text-xl font-black text-slate-900">User Management</p>
                    </div>

                    <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
                        <p class="text-sm font-semibold text-slate-500">Operations</p>
                        <p class="mt-2 text-xl font-black text-slate-900">Pickup Management</p>
                    </div>

                    <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
                        <p class="text-sm font-semibold text-slate-500">Finance</p>
                        <p class="mt-2 text-xl font-black text-slate-900">Payments & Reports</p>
                    </div>

                    <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
                        <p class="text-sm font-semibold text-slate-500">Analytics</p>
                        <p class="mt-2 text-xl font-black text-slate-900">Environmental Impact</p>
                    </div>
                @endif

            </div>

        </section>
    </main>

</div>

</body>
</html>