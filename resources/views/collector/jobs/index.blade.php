<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Pickup Jobs | SmartWaste Juba Connect</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        emeraldx: '#10b981',
                        darkx: '#07140f'
                    }
                }
            }
        }
    </script>
</head>

<body class="min-h-screen bg-slate-950 text-white">

    <nav class="border-b border-white/10 bg-slate-950/90 backdrop-blur">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-5 py-4">

            <a href="{{ route('collector.dashboard') }}" class="flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-500 font-black text-slate-950">
                    SW
                </div>

                <div>
                    <div class="font-black tracking-tight">
                        SmartWaste Juba
                    </div>

                    <div class="text-xs text-emerald-400">
                        CONNECT
                    </div>
                </div>
            </a>

            <a
                href="{{ route('collector.dashboard') }}"
                class="rounded-xl border border-white/10 px-4 py-2 text-sm text-slate-300 hover:bg-white/5"
            >
                ← Dashboard
            </a>

        </div>
    </nav>


    <main class="mx-auto max-w-7xl px-5 py-8">

        <div class="mb-8">
            <p class="text-sm font-semibold uppercase tracking-[0.2em] text-emerald-400">
                Collector Workspace
            </p>

            <h1 class="mt-2 text-3xl font-black tracking-tight sm:text-4xl">
                My Pickup Jobs
            </h1>

            <p class="mt-2 max-w-2xl text-slate-400">
                Manage your assigned waste collection jobs and update their progress.
            </p>
        </div>


        @if(session('success'))
            <div class="mb-6 rounded-2xl border border-emerald-400/20 bg-emerald-400/10 px-5 py-4 text-sm text-emerald-300">
                {{ session('success') }}
            </div>
        @endif


        @if(session('error'))
            <div class="mb-6 rounded-2xl border border-red-400/20 bg-red-400/10 px-5 py-4 text-sm text-red-300">
                {{ session('error') }}
            </div>
        @endif


        <div class="space-y-4">

            @forelse($jobs as $job)

                @php
                    $status = strtolower($job->status ?? 'pending');

                    $statusClasses = match ($status) {
                        'completed', 'complete' => 'bg-emerald-400/10 text-emerald-300 border-emerald-400/20',
                        'accepted', 'on_the_way', 'in_progress', 'collected' => 'bg-blue-400/10 text-blue-300 border-blue-400/20',
                        'rejected', 'cancelled', 'canceled' => 'bg-red-400/10 text-red-300 border-red-400/20',
                        default => 'bg-amber-400/10 text-amber-300 border-amber-400/20',
                    };

                    $wasteTypes = $job->items
                        ->map(fn($item) => $item->wasteCategory?->name)
                        ->filter()
                        ->implode(', ');

                    $quantity = $job->items->sum('quantity');
                @endphp


                <div class="rounded-3xl border border-white/10 bg-white/[0.04] p-5 shadow-2xl">

                    <div class="flex flex-col gap-5 lg:flex-row lg:items-center lg:justify-between">

                        <div class="min-w-0 flex-1">

                            <div class="flex flex-wrap items-center gap-3">

                                <span class="rounded-full border px-3 py-1 text-xs font-bold {{ $statusClasses }}">
                                    {{ str_replace('_', ' ', ucfirst($status)) }}
                                </span>

                                <span class="text-xs text-slate-500">
                                    #SWJ-{{ str_pad($job->id, 5, '0', STR_PAD_LEFT) }}
                                </span>

                            </div>


                            <h2 class="mt-4 text-xl font-black">
                                {{ $wasteTypes ?: 'Waste Pickup' }}
                            </h2>


                            <div class="mt-3 grid gap-3 text-sm text-slate-400 sm:grid-cols-2 lg:grid-cols-4">

                                <div>
                                    <div class="text-xs text-slate-500">Resident</div>
                                    <div class="mt-1 font-semibold text-slate-200">
                                        {{ $job->resident?->name ?? 'Resident' }}
                                    </div>
                                </div>

                                <div>
                                    <div class="text-xs text-slate-500">Quantity</div>
                                    <div class="mt-1 font-semibold text-slate-200">
                                        {{ number_format($quantity, 2) }} kg
                                    </div>
                                </div>

                                <div>
                                    <div class="text-xs text-slate-500">Pickup Date</div>
                                    <div class="mt-1 font-semibold text-slate-200">
                                        {{ $job->scheduled_at?->format('d M Y') ?? 'Not scheduled' }}
                                    </div>
                                </div>

                                <div>
                                    <div class="text-xs text-slate-500">Time</div>
                                    <div class="mt-1 font-semibold text-slate-200">
                                        {{ $job->scheduled_at?->format('h:i A') ?? '--' }}
                                    </div>
                                </div>

                            </div>


                            <div class="mt-4 flex items-start gap-3 rounded-2xl bg-black/20 p-4">

                                <div class="mt-0.5 text-emerald-400">
                                    📍
                                </div>

                                <div>
                                    <div class="text-xs text-slate-500">
                                        Pickup Location
                                    </div>

                                    <div class="mt-1 font-semibold text-slate-200">
                                        {{ $job->address?->area ?? 'Juba' }}
                                    </div>

                                    <div class="mt-1 text-sm text-slate-400">
                                        {{ $job->address?->address_line ?? 'Address not available' }}
                                    </div>
                                </div>

                            </div>

                        </div>


                        <div class="flex shrink-0 flex-col gap-2 sm:flex-row lg:flex-col">

                            <a
                                href="{{ route('collector.jobs.show', $job) }}"
                                class="rounded-xl bg-emerald-500 px-5 py-3 text-center text-sm font-black text-slate-950 hover:bg-emerald-400"
                            >
                                View Job
                            </a>

                            @if(in_array($status, ['pending', 'assigned']))

                                <form method="POST" action="{{ route('collector.jobs.accept', $job) }}">
                                    @csrf

                                    <button
                                        type="submit"
                                        class="w-full rounded-xl border border-emerald-400/20 bg-emerald-400/10 px-5 py-3 text-sm font-bold text-emerald-300 hover:bg-emerald-400/20"
                                    >
                                        Accept
                                    </button>
                                </form>

                                <form method="POST" action="{{ route('collector.jobs.reject', $job) }}">
                                    @csrf

                                    <button
                                        type="submit"
                                        class="w-full rounded-xl border border-red-400/20 bg-red-400/10 px-5 py-3 text-sm font-bold text-red-300 hover:bg-red-400/20"
                                    >
                                        Reject
                                    </button>
                                </form>

                            @elseif($status === 'accepted')

                                <form method="POST" action="{{ route('collector.jobs.start', $job) }}">
                                    @csrf

                                    <button
                                        type="submit"
                                        class="w-full rounded-xl border border-blue-400/20 bg-blue-400/10 px-5 py-3 text-sm font-bold text-blue-300 hover:bg-blue-400/20"
                                    >
                                        Start Job
                                    </button>
                                </form>

                            @elseif($status === 'on_the_way')

                                <form method="POST" action="{{ route('collector.jobs.collect', $job) }}">
                                    @csrf

                                    <button
                                        type="submit"
                                        class="w-full rounded-xl border border-blue-400/20 bg-blue-400/10 px-5 py-3 text-sm font-bold text-blue-300 hover:bg-blue-400/20"
                                    >
                                        Mark Collected
                                    </button>
                                </form>

                            @elseif($status === 'collected')

                                <form method="POST" action="{{ route('collector.jobs.complete', $job) }}">
                                    @csrf

                                    <button
                                        type="submit"
                                        class="w-full rounded-xl border border-emerald-400/20 bg-emerald-400/10 px-5 py-3 text-sm font-bold text-emerald-300 hover:bg-emerald-400/20"
                                    >
                                        Complete Job
                                    </button>
                                </form>

                            @endif

                        </div>

                    </div>

                </div>

            @empty

                <div class="rounded-3xl border border-dashed border-white/10 bg-white/[0.03] px-6 py-16 text-center">

                    <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-emerald-400/10 text-3xl">
                        🚛
                    </div>

                    <h2 class="mt-5 text-xl font-black">
                        No pickup jobs yet
                    </h2>

                    <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-slate-400">
                        Assigned pickup requests will appear here when jobs are allocated to your collector account.
                    </p>

                    <a
                        href="{{ route('collector.dashboard') }}"
                        class="mt-6 inline-flex rounded-xl bg-emerald-500 px-5 py-3 text-sm font-black text-slate-950 hover:bg-emerald-400"
                    >
                        Back to Dashboard
                    </a>

                </div>

            @endforelse

        </div>


        @if($jobs->hasPages())

            <div class="mt-8">
                {{ $jobs->links() }}
            </div>

        @endif

    </main>

</body>
</html>