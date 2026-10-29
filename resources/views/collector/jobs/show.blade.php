<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        Job #SWJ-{{ str_pad($pickupRequest->id, 5, '0', STR_PAD_LEFT) }}
        | SmartWaste Juba Connect
    </title>

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

    <!-- Navigation -->
    <nav class="border-b border-white/10 bg-slate-950/95 backdrop-blur">

        <div class="mx-auto flex max-w-7xl items-center justify-between px-5 py-4">

            <a href="{{ route('collector.dashboard') }}"
               class="flex items-center gap-3">

                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-500 font-black text-slate-950">
                    SW
                </div>

                <div>
                    <div class="font-black tracking-tight">
                        SmartWaste Juba
                    </div>

                    <div class="text-xs font-semibold tracking-[0.18em] text-emerald-400">
                        CONNECT
                    </div>
                </div>

            </a>


            <a
                href="{{ route('collector.jobs.index') }}"
                class="rounded-xl border border-white/10 px-4 py-2 text-sm font-semibold text-slate-300 transition hover:bg-white/5"
            >
                ← My Jobs
            </a>

        </div>

    </nav>


    <main class="mx-auto max-w-7xl px-5 py-8">

        <!-- Header -->
        <div class="mb-8">

            <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">

                <div>

                    <div class="text-sm font-semibold uppercase tracking-[0.2em] text-emerald-400">
                        Collector Job Details
                    </div>

                    <h1 class="mt-2 text-3xl font-black tracking-tight sm:text-4xl">
                        Pickup #SWJ-{{ str_pad($pickupRequest->id, 5, '0', STR_PAD_LEFT) }}
                    </h1>

                    <p class="mt-2 text-slate-400">
                        Review the pickup information and manage the collection process.
                    </p>

                </div>


                @php
                    $status = strtolower($pickupRequest->status ?? 'pending');

                    $statusClasses = match ($status) {
                        'completed', 'complete' =>
                            'bg-emerald-400/10 text-emerald-300 border-emerald-400/20',

                        'accepted', 'on_the_way', 'in_progress', 'collected' =>
                            'bg-blue-400/10 text-blue-300 border-blue-400/20',

                        'rejected', 'cancelled', 'canceled' =>
                            'bg-red-400/10 text-red-300 border-red-400/20',

                        default =>
                            'bg-amber-400/10 text-amber-300 border-amber-400/20',
                    };
                @endphp


                <div class="self-start rounded-full border px-4 py-2 text-sm font-bold {{ $statusClasses }}">
                    {{ str_replace('_', ' ', ucfirst($status)) }}
                </div>

            </div>

        </div>


        @if(session('success'))

            <div class="mb-6 rounded-2xl border border-emerald-400/20 bg-emerald-400/10 px-5 py-4 text-sm font-semibold text-emerald-300">
                {{ session('success') }}
            </div>

        @endif


        @if(session('error'))

            <div class="mb-6 rounded-2xl border border-red-400/20 bg-red-400/10 px-5 py-4 text-sm font-semibold text-red-300">
                {{ session('error') }}
            </div>

        @endif


        <div class="grid gap-6 lg:grid-cols-3">


            <!-- Main information -->
            <div class="space-y-6 lg:col-span-2">


                <!-- Pickup Schedule -->
                <section class="rounded-3xl border border-white/10 bg-white/[0.04] p-6">

                    <div class="mb-6 flex items-center gap-3">

                        <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-blue-400/10 text-xl">
                            📅
                        </div>

                        <div>
                            <h2 class="font-black">
                                Pickup Schedule
                            </h2>

                            <p class="text-sm text-slate-500">
                                When the collection should take place
                            </p>
                        </div>

                    </div>


                    <div class="grid gap-4 sm:grid-cols-2">

                        <div class="rounded-2xl bg-black/20 p-4">

                            <div class="text-xs font-semibold uppercase tracking-wider text-slate-500">
                                Pickup Date
                            </div>

                            <div class="mt-2 text-lg font-bold">
                                {{ $pickupRequest->scheduled_at?->format('d M Y') ?? 'Not scheduled' }}
                            </div>

                        </div>


                        <div class="rounded-2xl bg-black/20 p-4">

                            <div class="text-xs font-semibold uppercase tracking-wider text-slate-500">
                                Pickup Time
                            </div>

                            <div class="mt-2 text-lg font-bold">
                                {{ $pickupRequest->scheduled_at?->format('h:i A') ?? '--' }}
                            </div>

                        </div>


                        <div class="rounded-2xl bg-black/20 p-4">

                            <div class="text-xs font-semibold uppercase tracking-wider text-slate-500">
                                Request Type
                            </div>

                            <div class="mt-2 font-bold">
                                {{ str_replace('_', ' ', ucfirst($pickupRequest->request_type ?? 'One Time')) }}
                            </div>

                        </div>


                        <div class="rounded-2xl bg-black/20 p-4">

                            <div class="text-xs font-semibold uppercase tracking-wider text-slate-500">
                                Payment Status
                            </div>

                            <div class="mt-2 font-bold capitalize">
                                {{ str_replace('_', ' ', $pickupRequest->payment_status ?? 'Pending') }}
                            </div>

                        </div>

                    </div>

                </section>


                <!-- Resident -->
                <section class="rounded-3xl border border-white/10 bg-white/[0.04] p-6">

                    <div class="mb-6 flex items-center gap-3">

                        <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-emerald-400/10 text-xl">
                            👤
                        </div>

                        <div>
                            <h2 class="font-black">
                                Resident Information
                            </h2>

                            <p class="text-sm text-slate-500">
                                Customer details for this pickup
                            </p>
                        </div>

                    </div>


                    <div class="grid gap-4 sm:grid-cols-2">

                        <div>
                            <div class="text-xs uppercase tracking-wider text-slate-500">
                                Name
                            </div>

                            <div class="mt-1 font-semibold text-slate-200">
                                {{ $pickupRequest->resident?->name ?? 'Resident' }}
                            </div>
                        </div>


                        <div>
                            <div class="text-xs uppercase tracking-wider text-slate-500">
                                Phone
                            </div>

                            <div class="mt-1 font-semibold text-slate-200">
                                {{ $pickupRequest->resident?->phone ?? 'Not provided' }}
                            </div>
                        </div>


                        <div>
                            <div class="text-xs uppercase tracking-wider text-slate-500">
                                Email
                            </div>

                            <div class="mt-1 break-all font-semibold text-slate-200">
                                {{ $pickupRequest->resident?->email ?? 'Not provided' }}
                            </div>
                        </div>

                    </div>

                </section>


                <!-- Waste Information -->
                <section class="rounded-3xl border border-white/10 bg-white/[0.04] p-6">

                    <div class="mb-6 flex items-center gap-3">

                        <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-amber-400/10 text-xl">
                            ♻️
                        </div>

                        <div>
                            <h2 class="font-black">
                                Waste Information
                            </h2>

                            <p class="text-sm text-slate-500">
                                Materials scheduled for collection
                            </p>
                        </div>

                    </div>


                    <div class="space-y-3">

                        @forelse($pickupRequest->items as $item)

                            <div class="flex items-center justify-between rounded-2xl bg-black/20 p-4">

                                <div>

                                    <div class="font-bold text-slate-200">
                                        {{ $item->wasteCategory?->name ?? 'Waste' }}
                                    </div>

                                    <div class="mt-1 text-xs text-slate-500">
                                        Waste category
                                    </div>

                                </div>


                                <div class="text-right">

                                    <div class="text-lg font-black text-emerald-300">
                                        {{ number_format($item->quantity, 2) }}
                                        {{ $item->unit ?? 'kg' }}
                                    </div>

                                    <div class="text-xs text-slate-500">
                                        Estimated quantity
                                    </div>

                                </div>

                            </div>

                        @empty

                            <div class="rounded-2xl bg-black/20 p-5 text-sm text-slate-400">
                                No waste items were recorded for this pickup.
                            </div>

                        @endforelse

                    </div>

                </section>


                <!-- Pickup Location -->
                <section class="rounded-3xl border border-white/10 bg-white/[0.04] p-6">

                    <div class="mb-6 flex items-center gap-3">

                        <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-red-400/10 text-xl">
                            📍
                        </div>

                        <div>
                            <h2 class="font-black">
                                Pickup Location
                            </h2>

                            <p class="text-sm text-slate-500">
                                Navigate to the resident's collection point
                            </p>
                        </div>

                    </div>


                    <div class="space-y-4">

                        <div class="rounded-2xl bg-black/20 p-5">

                            <div class="text-xs uppercase tracking-wider text-slate-500">
                                Area
                            </div>

                            <div class="mt-1 text-lg font-black">
                                {{ $pickupRequest->address?->area ?? 'Juba' }}
                            </div>

                        </div>


                        <div class="grid gap-4 sm:grid-cols-2">

                            <div>

                                <div class="text-xs uppercase tracking-wider text-slate-500">
                                    Building / Road / House
                                </div>

                                <div class="mt-1 font-semibold text-slate-200">
                                    {{ $pickupRequest->address?->address_line ?? 'Not provided' }}
                                </div>

                            </div>


                            <div>

                                <div class="text-xs uppercase tracking-wider text-slate-500">
                                    Landmark
                                </div>

                                <div class="mt-1 font-semibold text-slate-200">
                                    {{ $pickupRequest->address?->landmark ?? 'Not provided' }}
                                </div>

                            </div>

                        </div>


                        @if($pickupRequest->address?->directions)

                            <div class="rounded-2xl border border-white/10 bg-white/[0.03] p-4">

                                <div class="text-xs uppercase tracking-wider text-slate-500">
                                    Directions
                                </div>

                                <div class="mt-2 leading-6 text-slate-300">
                                    {{ $pickupRequest->address->directions }}
                                </div>

                            </div>

                        @endif


                        <div class="rounded-2xl border border-emerald-400/10 bg-emerald-400/5 p-4">

                            <div class="flex gap-3">

                                <div class="text-xl">
                                    🗺️
                                </div>

                                <div>

                                    <div class="font-bold text-emerald-300">
                                        GPS Navigation
                                    </div>

                                    <p class="mt-1 text-sm leading-6 text-slate-400">
                                        Live navigation and collector location tracking will be enabled in the next SmartWaste Juba module.
                                    </p>

                                </div>

                            </div>

                        </div>

                    </div>

                </section>


                <!-- Notes -->
                @if($pickupRequest->notes)

                    <section class="rounded-3xl border border-white/10 bg-white/[0.04] p-6">

                        <div class="mb-4 flex items-center gap-3">

                            <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-purple-400/10 text-xl">
                                📝
                            </div>

                            <div>
                                <h2 class="font-black">
                                    Resident Notes
                                </h2>

                                <p class="text-sm text-slate-500">
                                    Additional instructions
                                </p>
                            </div>

                        </div>


                        <div class="rounded-2xl bg-black/20 p-5 leading-7 text-slate-300">
                            {{ $pickupRequest->notes }}
                        </div>

                    </section>

                @endif


                <!-- Waste Photo -->
                @if($pickupRequest->photo_path)

                    <section class="rounded-3xl border border-white/10 bg-white/[0.04] p-6">

                        <div class="mb-5 flex items-center gap-3">

                            <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-cyan-400/10 text-xl">
                                📷
                            </div>

                            <div>
                                <h2 class="font-black">
                                    Waste Photo
                                </h2>

                                <p class="text-sm text-slate-500">
                                    Photo uploaded by the resident
                                </p>
                            </div>

                        </div>


                        <img
                            src="{{ asset('storage/' . $pickupRequest->photo_path) }}"
                            alt="Waste photo"
                            class="max-h-[500px] w-full rounded-2xl object-cover"
                        >

                    </section>

                @endif

            </div>


            <!-- Right column -->
            <aside class="space-y-6">


                <!-- Job Summary -->
                <section class="rounded-3xl border border-white/10 bg-white/[0.04] p-6">

                    <h2 class="font-black">
                        Job Summary
                    </h2>

                    <div class="mt-5 space-y-4">

                        <div class="flex items-center justify-between gap-4">

                            <span class="text-sm text-slate-500">
                                Request
                            </span>

                            <span class="text-sm font-bold">
                                #SWJ-{{ str_pad($pickupRequest->id, 5, '0', STR_PAD_LEFT) }}
                            </span>

                        </div>


                        <div class="flex items-center justify-between gap-4">

                            <span class="text-sm text-slate-500">
                                Total Fee
                            </span>

                            <span class="text-lg font-black text-emerald-300">
                                {{ number_format($pickupRequest->total_amount ?? 0, 0) }}
                                SSP
                            </span>

                        </div>


                        <div class="flex items-center justify-between gap-4">

                            <span class="text-sm text-slate-500">
                                Payment
                            </span>

                            <span class="text-sm font-bold capitalize">
                                {{ $pickupRequest->payment_status ?? 'pending' }}
                            </span>

                        </div>

                    </div>

                </section>


                <!-- Job Status -->
                <section class="rounded-3xl border border-white/10 bg-white/[0.04] p-6">

                    <h2 class="font-black">
                        Job Progress
                    </h2>


                    <div class="mt-6 space-y-5">

                        @php
                            $steps = [
                                'assigned' => 'Assigned',
                                'accepted' => 'Accepted',
                                'on_the_way' => 'On the Way',
                                'collected' => 'Collected',
                                'completed' => 'Completed',
                            ];

                            $statusOrder = [
                                'assigned' => 1,
                                'accepted' => 2,
                                'on_the_way' => 3,
                                'collected' => 4,
                                'completed' => 5,
                            ];

                            $currentStep = $statusOrder[$status] ?? 0;
                        @endphp


                        @foreach($steps as $step => $label)

                            @php
                                $stepNumber = $statusOrder[$step];
                                $done = $currentStep >= $stepNumber;
                                $current = $status === $step;
                            @endphp

                            <div class="flex items-start gap-3">

                                <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full
                                    {{ $done ? 'bg-emerald-500 text-slate-950' : 'bg-white/10 text-slate-500' }}
                                    {{ $current ? 'ring-4 ring-emerald-500/20' : '' }}
                                ">
                                    @if($done)
                                        ✓
                                    @else
                                        {{ $stepNumber }}
                                    @endif
                                </div>

                                <div class="pt-1">

                                    <div class="text-sm font-bold {{ $done ? 'text-white' : 'text-slate-500' }}">
                                        {{ $label }}
                                    </div>

                                    @if($current)

                                        <div class="mt-1 text-xs text-emerald-400">
                                            Current status
                                        </div>

                                    @endif

                                </div>

                            </div>

                        @endforeach

                    </div>

                </section>


                <!-- Actions -->
                <section class="rounded-3xl border border-white/10 bg-white/[0.04] p-6">

                    <h2 class="font-black">
                        Job Actions
                    </h2>

                    <div class="mt-5 space-y-3">


                        @if(in_array($status, ['pending', 'assigned']))

                            <form method="POST" action="{{ route('collector.jobs.accept', $pickupRequest) }}">
                                @csrf

                                <button
                                    type="submit"
                                    class="w-full rounded-xl bg-emerald-500 px-5 py-3 font-black text-slate-950 transition hover:bg-emerald-400"
                                >
                                    ✓ Accept Job
                                </button>
                            </form>


                            <form method="POST" action="{{ route('collector.jobs.reject', $pickupRequest) }}">
                                @csrf

                                <button
                                    type="submit"
                                    class="w-full rounded-xl border border-red-400/20 bg-red-400/10 px-5 py-3 font-bold text-red-300 transition hover:bg-red-400/20"
                                >
                                    Reject Job
                                </button>
                            </form>


                        @elseif($status === 'accepted')

                            <form method="POST" action="{{ route('collector.jobs.start', $pickupRequest) }}">
                                @csrf

                                <button
                                    type="submit"
                                    class="w-full rounded-xl bg-blue-500 px-5 py-3 font-black text-white transition hover:bg-blue-400"
                                >
                                    🚛 Start Job
                                </button>
                            </form>


                        @elseif($status === 'on_the_way')

                            <form method="POST" action="{{ route('collector.jobs.collect', $pickupRequest) }}">
                                @csrf

                                <button
                                    type="submit"
                                    class="w-full rounded-xl bg-blue-500 px-5 py-3 font-black text-white transition hover:bg-blue-400"
                                >
                                    ♻ Mark Collected
                                </button>
                            </form>


                        @elseif($status === 'collected')

                            <form method="POST" action="{{ route('collector.jobs.complete', $pickupRequest) }}">
                                @csrf

                                <button
                                    type="submit"
                                    class="w-full rounded-xl bg-emerald-500 px-5 py-3 font-black text-slate-950 transition hover:bg-emerald-400"
                                >
                                    ✓ Complete Job
                                </button>
                            </form>


                        @elseif(in_array($status, ['completed', 'complete']))

                            <div class="rounded-xl border border-emerald-400/20 bg-emerald-400/10 px-4 py-4 text-center text-sm font-bold text-emerald-300">
                                ✓ This pickup has been completed.
                            </div>

                        @endif


                        <a
                            href="{{ route('collector.jobs.index') }}"
                            class="block w-full rounded-xl border border-white/10 px-5 py-3 text-center text-sm font-bold text-slate-300 transition hover:bg-white/5"
                        >
                            ← Back to My Jobs
                        </a>

                    </div>

                </section>


            </aside>

        </div>

    </main>

</body>
</html>