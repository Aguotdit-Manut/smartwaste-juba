<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>My Requests | SmartWaste Juba Connect</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'ui-sans-serif', 'system-ui'],
                    },
                }
            }
        }
    </script>
</head>

<body class="min-h-screen bg-slate-950 text-white">

    <!-- Background -->
    <div class="fixed inset-0 -z-10 overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-emerald-950 via-slate-950 to-slate-950"></div>

        <div class="absolute -top-32 -left-32 h-96 w-96 rounded-full bg-emerald-500/10 blur-3xl"></div>
        <div class="absolute top-1/3 -right-32 h-96 w-96 rounded-full bg-cyan-500/10 blur-3xl"></div>
    </div>

    <!-- Navigation -->
    <nav class="border-b border-white/10 bg-slate-950/70 backdrop-blur-xl">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-5 py-4 lg:px-8">

            <a href="{{ route('resident.dashboard') }}" class="flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-2xl bg-emerald-500 shadow-lg shadow-emerald-500/20">
                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" stroke-width="2"
                         viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M12 3c3.5 3.2 6 6.5 6 10a6 6 0 01-12 0c0-3.5 2.5-6.8 6-10z"/>
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M9 15c1.5.5 3 .5 6 0"/>
                    </svg>
                </div>

                <div>
                    <h1 class="text-base font-bold tracking-tight">
                        SmartWaste Juba
                    </h1>

                    <p class="text-[11px] font-medium text-emerald-400">
                        CONNECT
                    </p>
                </div>
            </a>

            <div class="flex items-center gap-3">

                <a href="{{ route('resident.dashboard') }}"
                   class="hidden rounded-xl px-4 py-2 text-sm font-medium text-slate-300 transition hover:bg-white/5 hover:text-white sm:block">
                    Dashboard
                </a>

                <a href="{{ route('resident.pickups.create') }}"
                   class="rounded-xl bg-emerald-500 px-4 py-2.5 text-sm font-semibold text-white shadow-lg shadow-emerald-500/20 transition hover:bg-emerald-400">
                    + New Request
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <button type="submit"
                            class="hidden rounded-xl border border-white/10 px-4 py-2.5 text-sm font-medium text-slate-300 transition hover:bg-white/5 hover:text-white md:block">
                        Logout
                    </button>
                </form>

            </div>
        </div>
    </nav>


    <!-- Main -->
    <main class="mx-auto max-w-7xl px-5 py-8 lg:px-8 lg:py-10">

        <!-- Header -->
        <div class="mb-8 flex flex-col justify-between gap-5 md:flex-row md:items-end">

            <div>
                <div class="mb-3 inline-flex items-center gap-2 rounded-full border border-emerald-400/20 bg-emerald-400/10 px-3 py-1.5 text-xs font-medium text-emerald-300">
                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-400"></span>
                    Waste Collection Requests
                </div>

                <h2 class="text-3xl font-bold tracking-tight sm:text-4xl">
                    My Requests
                </h2>

                <p class="mt-2 max-w-2xl text-sm leading-6 text-slate-400">
                    View and manage your waste collection requests, schedules,
                    pickup locations and request status.
                </p>
            </div>

            <a href="{{ route('resident.pickups.create') }}"
               class="inline-flex items-center justify-center gap-2 rounded-2xl bg-white px-5 py-3 text-sm font-bold text-slate-900 shadow-xl transition hover:bg-emerald-50">

                <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2"
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M12 4v16m8-8H4"/>
                </svg>

                Request Pickup
            </a>

        </div>


        <!-- Success message -->
        @if(session('success'))
            <div class="mb-6 rounded-2xl border border-emerald-400/20 bg-emerald-400/10 px-5 py-4 text-sm text-emerald-300">
                <div class="flex items-center gap-3">
                    <div class="flex h-8 w-8 items-center justify-center rounded-full bg-emerald-400/20">
                        ✓
                    </div>

                    <span>{{ session('success') }}</span>
                </div>
            </div>
        @endif


        <!-- Requests -->
        @if($requests->count())

            <div class="grid gap-5">

                @foreach($requests as $request)

                    @php
                        $status = strtolower($request->status ?? 'pending');

                        $statusClasses = match($status) {
                            'completed', 'complete' =>
                                'border-emerald-400/20 bg-emerald-400/10 text-emerald-300',

                            'accepted', 'assigned', 'confirmed' =>
                                'border-cyan-400/20 bg-cyan-400/10 text-cyan-300',

                            'in_progress', 'on_the_way', 'collected' =>
                                'border-blue-400/20 bg-blue-400/10 text-blue-300',

                            'cancelled', 'canceled', 'rejected' =>
                                'border-red-400/20 bg-red-400/10 text-red-300',

                            default =>
                                'border-amber-400/20 bg-amber-400/10 text-amber-300',
                        };

                        $paymentStatus = strtolower($request->payment_status ?? 'pending');

                        $paymentClasses = match($paymentStatus) {
                            'paid', 'completed' =>
                                'text-emerald-300 bg-emerald-400/10 border-emerald-400/20',

                            'failed', 'cancelled', 'canceled' =>
                                'text-red-300 bg-red-400/10 border-red-400/20',

                            default =>
                                'text-amber-300 bg-amber-400/10 border-amber-400/20',
                        };

                        $firstItem = $request->items->first();
                    @endphp


                    <article class="group overflow-hidden rounded-3xl border border-white/10 bg-white/[0.045] shadow-2xl shadow-black/20 backdrop-blur-xl transition duration-300 hover:border-emerald-400/20 hover:bg-white/[0.06]">

                        <div class="p-5 sm:p-6 lg:p-7">

                            <!-- Top row -->
                            <div class="flex flex-col gap-5 lg:flex-row lg:items-start lg:justify-between">

                                <div class="flex gap-4">

                                    <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-emerald-500/10 ring-1 ring-emerald-400/10">
                                        <svg class="h-7 w-7 text-emerald-400" fill="none" stroke="currentColor"
                                             stroke-width="1.8" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M6 7h12M8 7l1 13h6l1-13M9 7l1-3h4l1 3M10 11v5M14 11v5"/>
                                        </svg>
                                    </div>

                                    <div>
                                        <div class="flex flex-wrap items-center gap-2">

                                            <h3 class="font-bold text-white">
                                                Request #SWJ-{{ str_pad($request->id, 5, '0', STR_PAD_LEFT) }}
                                            </h3>

                                            <span class="rounded-full border px-2.5 py-1 text-[11px] font-semibold uppercase tracking-wide {{ $statusClasses }}">
                                                {{ str_replace('_', ' ', $request->status ?? 'pending') }}
                                            </span>

                                        </div>

                                        <p class="mt-1 text-sm text-slate-400">
                                            Submitted {{ $request->created_at?->format('d M Y, h:i A') }}
                                        </p>
                                    </div>

                                </div>


                                <!-- Total -->
                                <div class="lg:text-right">
                                    <p class="text-xs font-medium uppercase tracking-wider text-slate-500">
                                        Estimated Fee
                                    </p>

                                    <p class="mt-1 text-xl font-bold text-white">
                                        SSP {{ number_format((float) $request->total_amount, 0) }}
                                    </p>
                                </div>

                            </div>


                            <!-- Details -->
                            <div class="mt-6 grid gap-3 sm:grid-cols-2 lg:grid-cols-4">

                                <!-- Waste -->
                                <div class="rounded-2xl border border-white/5 bg-black/10 p-4">
                                    <p class="text-[11px] font-semibold uppercase tracking-wider text-slate-500">
                                        Waste Type
                                    </p>

                                    <p class="mt-2 font-semibold text-slate-100">
                                        {{ $firstItem?->wasteCategory?->name ?? 'Not specified' }}
                                    </p>
                                </div>


                                <!-- Quantity -->
                                <div class="rounded-2xl border border-white/5 bg-black/10 p-4">
                                    <p class="text-[11px] font-semibold uppercase tracking-wider text-slate-500">
                                        Quantity
                                    </p>

                                    <p class="mt-2 font-semibold text-slate-100">
                                        {{ $firstItem?->quantity ?? '0' }}
                                        {{ strtoupper($firstItem?->unit ?? 'kg') }}
                                    </p>
                                </div>


                                <!-- Location -->
                                <div class="rounded-2xl border border-white/5 bg-black/10 p-4">
                                    <p class="text-[11px] font-semibold uppercase tracking-wider text-slate-500">
                                        Pickup Area
                                    </p>

                                    <p class="mt-2 font-semibold text-slate-100">
                                        {{ $request->address?->area ?? 'Juba' }}
                                    </p>
                                </div>


                                <!-- Schedule -->
                                <div class="rounded-2xl border border-white/5 bg-black/10 p-4">
                                    <p class="text-[11px] font-semibold uppercase tracking-wider text-slate-500">
                                        Pickup Schedule
                                    </p>

                                    <p class="mt-2 font-semibold text-slate-100">
                                        {{ $request->scheduled_at?->format('d M Y') }}
                                    </p>

                                    <p class="mt-1 text-xs text-slate-400">
                                        {{ $request->scheduled_at?->format('h:i A') }}
                                    </p>
                                </div>

                            </div>


                            <!-- Bottom -->
                            <div class="mt-5 flex flex-col gap-4 border-t border-white/10 pt-5 sm:flex-row sm:items-center sm:justify-between">

                                <div class="flex flex-wrap items-center gap-3">

                                    <span class="inline-flex items-center gap-2 rounded-full border px-3 py-1.5 text-xs font-semibold {{ $paymentClasses }}">
                                        <span class="h-1.5 w-1.5 rounded-full bg-current"></span>
                                        Payment:
                                        {{ str_replace('_', ' ', $request->payment_status ?? 'pending') }}
                                    </span>

                                    @if($request->request_type === 'recurring')

                                        <span class="inline-flex items-center gap-2 rounded-full border border-purple-400/20 bg-purple-400/10 px-3 py-1.5 text-xs font-semibold text-purple-300">
                                            ↻
                                            {{ ucfirst($request->recurrence_frequency ?? 'Recurring') }}
                                        </span>

                                    @else

                                        <span class="inline-flex items-center gap-2 rounded-full border border-white/10 bg-white/5 px-3 py-1.5 text-xs font-medium text-slate-400">
                                            One-time pickup
                                        </span>

                                    @endif

                                </div>


                                <a href="{{ route('resident.requests.show', $request) }}"
                                   class="inline-flex items-center justify-center gap-2 rounded-xl border border-emerald-400/20 bg-emerald-400/10 px-4 py-2.5 text-sm font-semibold text-emerald-300 transition hover:bg-emerald-400/20 hover:text-emerald-200">

                                    View Details

                                    <svg class="h-4 w-4 transition-transform group-hover:translate-x-0.5"
                                         fill="none" stroke="currentColor" stroke-width="2"
                                         viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M5 12h14M13 6l6 6-6 6"/>
                                    </svg>

                                </a>

                            </div>

                        </div>

                    </article>

                @endforeach

            </div>


            <!-- Pagination -->
            @if($requests->hasPages())

                <div class="mt-8 rounded-2xl border border-white/10 bg-white/[0.04] p-4">
                    {{ $requests->links() }}
                </div>

            @endif


        @else

            <!-- Empty state -->
            <div class="rounded-3xl border border-white/10 bg-white/[0.045] px-6 py-16 text-center shadow-2xl backdrop-blur-xl">

                <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-3xl bg-emerald-500/10 ring-1 ring-emerald-400/10">

                    <svg class="h-10 w-10 text-emerald-400" fill="none" stroke="currentColor"
                         stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M6 7h12M8 7l1 13h6l1-13M9 7l1-3h4l1 3"/>
                    </svg>

                </div>

                <h3 class="mt-6 text-xl font-bold">
                    No pickup requests yet
                </h3>

                <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-slate-400">
                    You haven't submitted a waste collection request yet.
                    Create your first request and let SmartWaste Juba Connect
                    help keep your community clean.
                </p>

                <a href="{{ route('resident.pickups.create') }}"
                   class="mt-7 inline-flex items-center gap-2 rounded-2xl bg-emerald-500 px-5 py-3 text-sm font-bold text-white shadow-lg shadow-emerald-500/20 transition hover:bg-emerald-400">

                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2"
                         viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M12 4v16m8-8H4"/>
                    </svg>

                    Create Pickup Request
                </a>

            </div>

        @endif

    </main>

</body>
</html>