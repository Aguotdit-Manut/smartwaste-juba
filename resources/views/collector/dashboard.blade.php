<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Collector Dashboard | SmartWaste Juba Connect</title>

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
    };
</script>

<script>
    let currentlyOnline = @json((bool) $collector->is_online);
    let gpsWatchId = null;

    async function toggleAvailability() {

        const button = document.getElementById('availabilityButton');

        button.disabled = true;

        try {

            if (!currentlyOnline) {

                if (!navigator.geolocation) {
                    throw new Error(
                        'GPS location is not supported by this browser.'
                    );
                }

                showAvailabilityMessage(
                    'Requesting your location...',
                    true
                );

                const position = await getCurrentLocation();

                const availabilityResponse = await fetch(
                    '{{ route('collector.location.availability') }}',
                    {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            online: true
                        })
                    }
                );

                const availabilityData =
                    await availabilityResponse.json();

                if (
                    !availabilityResponse.ok ||
                    !availabilityData.success
                ) {
                    throw new Error(
                        availabilityData.message ||
                        'Unable to update availability.'
                    );
                }

                await sendLocation(position);

                currentlyOnline = true;

                updateAvailabilityUI(
                    true,
                    availabilityData.last_seen_at
                );

                showAvailabilityMessage(
                    'You are now online and your location has been shared.',
                    true
                );

                startLocationTracking();

            } else {

                stopLocationTracking();

                const response = await fetch(
                    '{{ route('collector.location.availability') }}',
                    {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            online: false
                        })
                    }
                );

                const data = await response.json();

                if (!response.ok || !data.success) {
                    throw new Error(
                        data.message ||
                        'Unable to update availability.'
                    );
                }

                currentlyOnline = false;

                updateAvailabilityUI(
                    false,
                    data.last_seen_at
                );

                showAvailabilityMessage(
                    'You are now offline.',
                    true
                );
            }

        } catch (error) {

            console.error('Availability error:', error);

            showAvailabilityMessage(
                error.message ||
                'Unable to update your availability.',
                false
            );

        } finally {

            button.disabled = false;
        }
    }


    function getCurrentLocation() {

        return new Promise((resolve, reject) => {

            navigator.geolocation.getCurrentPosition(
                resolve,
                reject,
                {
                    enableHighAccuracy: true,
                    timeout: 15000,
                    maximumAge: 0
                }
            );

        }).catch(error => {

            if (error.code === 1) {
                throw new Error(
                    'Location permission was denied. Please allow location access.'
                );
            }

            if (error.code === 2) {
                throw new Error(
                    'Your location could not be determined.'
                );
            }

            if (error.code === 3) {
                throw new Error(
                    'Location request timed out. Please try again.'
                );
            }

            throw new Error(
                'Unable to get your location.'
            );
        });
    }


    async function sendLocation(position) {

        const response = await fetch(
            '{{ route('collector.location.store') }}',
            {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    latitude: position.coords.latitude,
                    longitude: position.coords.longitude,
                    accuracy: position.coords.accuracy
                })
            }
        );

        const data = await response.json();

        if (!response.ok || !data.success) {
            throw new Error(
                data.message ||
                'Unable to save your GPS location.'
            );
        }

        console.log(
            'GPS location saved:',
            data.location
        );

        return data;
    }


    function startLocationTracking() {

        if (!navigator.geolocation) {
            return;
        }

        if (gpsWatchId !== null) {
            return;
        }

        gpsWatchId = navigator.geolocation.watchPosition(

            async position => {

                try {

                    await sendLocation(position);

                    console.log(
                        'GPS location updated:',
                        position.coords.latitude,
                        position.coords.longitude
                    );

                } catch (error) {

                    console.error(
                        'GPS update failed:',
                        error
                    );
                }
            },

            error => {

                console.error(
                    'GPS tracking error:',
                    error
                );
            },

            {
                enableHighAccuracy: true,
                maximumAge: 10000,
                timeout: 15000
            }
        );
    }


    function stopLocationTracking() {

        if (gpsWatchId !== null) {

            navigator.geolocation.clearWatch(
                gpsWatchId
            );

            gpsWatchId = null;
        }
    }



function updateAvailabilityUI(isOnline, lastSeen) {
    const dot = document.getElementById('availabilityDot');
    const ping = document.getElementById('availabilityPing');
    const title = document.getElementById('availabilityTitle');
    const description = document.getElementById('availabilityDescription');
    const button = document.getElementById('availabilityButton');
    const lastSeenElement = document.getElementById('lastSeen');

    if (isOnline) {
        dot.className =
            'relative inline-flex h-3 w-3 rounded-full bg-emerald-400';

        ping.className =
            'absolute inline-flex h-full w-full animate-ping rounded-full bg-emerald-400 opacity-60';

        title.textContent = 'You are Online';
        title.className = 'text-sm text-emerald-300';

        description.textContent =
            'You are available to receive pickup jobs.';

        button.textContent = 'Go Offline';
        button.className =
            'rounded-xl px-5 py-3 text-sm font-semibold text-white shadow-sm transition bg-slate-700 hover:bg-slate-600';
    } else {
        dot.className =
            'relative inline-flex h-3 w-3 rounded-full bg-slate-500';

        ping.className = 'hidden';

        title.textContent = 'You are Offline';
        title.className = 'text-sm text-slate-300';

        description.textContent =
            'Go online to receive pickup jobs.';

        button.textContent = 'Go Online';
        button.className =
            'rounded-xl px-5 py-3 text-sm font-semibold text-white shadow-sm transition bg-emerald-600 hover:bg-emerald-500';
    }

    if (lastSeenElement) {
        lastSeenElement.textContent = lastSeen
            ? new Date(lastSeen).toLocaleString()
            : 'Not recorded yet';
    }
}


    function showAvailabilityMessage(message, success) {

        const element =
            document.getElementById('availabilityMessage');

        element.textContent =
            message;

        element.classList.remove(
            'hidden',
            'text-emerald-600',
            'text-red-600'
        );

        element.classList.add(
            success
                ? 'text-emerald-600'
                : 'text-red-600'
        );

        setTimeout(() => {

            element.classList.add('hidden');

        }, 4000);
    }
</script>

</head>


<body class="min-h-screen bg-slate-950 text-white">


    <!-- Background -->
    <div class="fixed inset-0 -z-10 overflow-hidden">

        <div class="absolute inset-0 bg-gradient-to-br from-emerald-950 via-slate-950 to-slate-950"></div>

        <div class="absolute -left-40 -top-40 h-[30rem] w-[30rem] rounded-full bg-emerald-500/10 blur-3xl"></div>

        <div class="absolute -right-40 top-1/3 h-[30rem] w-[30rem] rounded-full bg-cyan-500/10 blur-3xl"></div>

    </div>


    <!-- Navigation -->
    <nav class="border-b border-white/10 bg-slate-950/70 backdrop-blur-xl">

        <div class="mx-auto flex max-w-7xl items-center justify-between px-5 py-4 lg:px-8">

            <!-- Brand -->
            <a href="{{ route('collector.dashboard') }}"
               class="flex items-center gap-3">

                <div class="flex h-10 w-10 items-center justify-center rounded-2xl bg-emerald-500 shadow-lg shadow-emerald-500/20">

                    <svg class="h-6 w-6 text-white"
                         fill="none"
                         stroke="currentColor"
                         stroke-width="2"
                         viewBox="0 0 24 24">

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M12 3c3.5 3.2 6 6.5 6 10a6 6 0 01-12 0c0-3.5 2.5-6.8 6-10z"/>

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M9 15c1.5.5 3 .5 6 0"/>

                    </svg>

                </div>


                <div>

                    <h1 class="text-base font-bold tracking-tight">
                        SmartWaste Juba
                    </h1>

                    <p class="text-[11px] font-medium text-emerald-400">
                        CONNECT • COLLECTOR
                    </p>

                </div>

            </a>


            <!-- Navigation -->
            <div class="flex items-center gap-3">

                <span class="hidden text-sm text-slate-400 sm:block">
                    {{ $collector->name }}
                </span>


                <form method="POST" action="{{ route('logout') }}">

                    @csrf

                    <button type="submit"
                            class="rounded-xl border border-white/10 px-4 py-2.5 text-sm font-medium text-slate-300 transition hover:bg-white/5 hover:text-white">

                        Logout

                    </button>

                </form>

            </div>

        </div>

    </nav>


    <!-- Main -->
    <main class="mx-auto max-w-7xl px-5 py-8 lg:px-8 lg:py-10">

        <!-- Header -->
        <div class="mb-8">

            <div class="mb-3 inline-flex items-center gap-2 rounded-full border border-emerald-400/20 bg-emerald-400/10 px-3 py-1.5 text-xs font-medium text-emerald-300">

                <span class="h-1.5 w-1.5 rounded-full bg-emerald-400"></span>

                Collector Workspace

            </div>


            <h2 class="text-3xl font-bold tracking-tight sm:text-4xl">

                Welcome, {{ $collector->name }}

            </h2>


            <p class="mt-2 max-w-2xl text-sm leading-6 text-slate-400">

                Manage your assigned waste collection jobs, track today's
                pickups and monitor your collection activity.

            </p>

        </div>


<!-- Availability -->
<div class="mb-6 rounded-3xl border border-white/10 bg-white/[0.045] p-5 backdrop-blur-xl">

    <div class="flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between">

        <!-- Status Information -->
        <div class="flex items-center gap-4">

            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-emerald-400/10">

                <span class="relative flex h-3 w-3">

                    <span
                        id="availabilityPing"
                        class="{{ $collector->is_online ? 'absolute inline-flex h-full w-full animate-ping rounded-full bg-emerald-400 opacity-60' : 'hidden' }}">
                    </span>

                    <span
                        id="availabilityDot"
                        class="relative inline-flex h-3 w-3 rounded-full
                        {{ $collector->is_online ? 'bg-emerald-400' : 'bg-slate-500' }}">
                    </span>

                </span>

            </div>

            <div>

                <p class="font-semibold text-white">
                    Collector Status
                </p>

                <p
                    id="availabilityTitle"
                    class="text-sm {{ $collector->is_online ? 'text-emerald-300' : 'text-slate-400' }}">
                    {{ $collector->is_online ? 'You are Online' : 'You are Offline' }}
                </p>

                <p
                    id="availabilityDescription"
                    class="mt-1 text-xs text-slate-500">
                    {{ $collector->is_online
                        ? 'You are available to receive pickup jobs.'
                        : 'You are not currently accepting pickup jobs.' }}
                </p>

                <p class="mt-1 text-xs text-slate-600">

                    Last seen:

                    <span id="lastSeen">

                        {{ $collector->last_seen_at
                            ? $collector->last_seen_at->format('d M Y, h:i A')
                            : 'Not available yet' }}

                    </span>

                </p>

            </div>

        </div>


        <!-- Availability Button -->
        <button
            type="button"
            id="availabilityButton"
            onclick="toggleAvailability()"
            class="rounded-xl px-5 py-3 text-sm font-semibold text-white shadow-sm transition
            {{ $collector->is_online
                ? 'bg-slate-700 hover:bg-slate-600'
                : 'bg-emerald-600 hover:bg-emerald-500' }}">

            {{ $collector->is_online ? 'Go Offline' : 'Go Online' }}

        </button>

    </div>


    <!-- Message -->
    <p
        id="availabilityMessage"
        class="mt-3 hidden text-sm">
    </p>

</div>


        <!-- Statistics -->
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-5">


            <!-- Today -->
            <div class="rounded-3xl border border-white/10 bg-white/[0.045] p-5 backdrop-blur-xl">

                <div class="flex items-center justify-between">

                    <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">
                        Today
                    </p>

                    <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-cyan-400/10">

                        <svg class="h-5 w-5 text-cyan-300"
                             fill="none"
                             stroke="currentColor"
                             stroke-width="1.8"
                             viewBox="0 0 24 24">

                            <rect x="3" y="4" width="18" height="17" rx="2"/>

                            <path stroke-linecap="round"
                                  d="M16 2v4M8 2v4M3 10h18"/>

                        </svg>

                    </div>

                </div>

                <p class="mt-4 text-3xl font-bold">
                    {{ $todayJobs }}
                </p>

                <p class="mt-1 text-xs text-slate-500">
                    Scheduled pickups
                </p>

            </div>


            <!-- Pending -->
            <div class="rounded-3xl border border-white/10 bg-white/[0.045] p-5 backdrop-blur-xl">

                <div class="flex items-center justify-between">

                    <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">
                        Pending
                    </p>

                    <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-amber-400/10">

                        <svg class="h-5 w-5 text-amber-300"
                             fill="none"
                             stroke="currentColor"
                             stroke-width="1.8"
                             viewBox="0 0 24 24">

                            <circle cx="12" cy="12" r="9"/>

                            <path stroke-linecap="round"
                                  d="M12 7v5l3 2"/>

                        </svg>

                    </div>

                </div>

                <p class="mt-4 text-3xl font-bold">
                    {{ $pendingJobs }}
                </p>

                <p class="mt-1 text-xs text-slate-500">
                    Awaiting action
                </p>

            </div>


            <!-- Active -->
            <div class="rounded-3xl border border-white/10 bg-white/[0.045] p-5 backdrop-blur-xl">

                <div class="flex items-center justify-between">

                    <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">
                        Active
                    </p>

                    <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-blue-400/10">

                        <svg class="h-5 w-5 text-blue-300"
                             fill="none"
                             stroke="currentColor"
                             stroke-width="1.8"
                             viewBox="0 0 24 24">

                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  d="M5 12h14M13 6l6 6-6 6"/>

                        </svg>

                    </div>

                </div>

                <p class="mt-4 text-3xl font-bold">
                    {{ $activeJobs }}
                </p>

                <p class="mt-1 text-xs text-slate-500">
                    Jobs in progress
                </p>

            </div>


            <!-- Completed -->
            <div class="rounded-3xl border border-white/10 bg-white/[0.045] p-5 backdrop-blur-xl">

                <div class="flex items-center justify-between">

                    <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">
                        Completed
                    </p>

                    <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-emerald-400/10">

                        <svg class="h-5 w-5 text-emerald-300"
                             fill="none"
                             stroke="currentColor"
                             stroke-width="1.8"
                             viewBox="0 0 24 24">

                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  d="M5 13l4 4L19 7"/>

                        </svg>

                    </div>

                </div>

                <p class="mt-4 text-3xl font-bold">
                    {{ $completedJobs }}
                </p>

                <p class="mt-1 text-xs text-slate-500">
                    Finished pickups
                </p>

            </div>


            <!-- Earnings -->
            <div class="rounded-3xl border border-white/10 bg-white/[0.045] p-5 backdrop-blur-xl">

                <div class="flex items-center justify-between">

                    <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">
                        Earnings
                    </p>

                    <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-purple-400/10">

                        <svg class="h-5 w-5 text-purple-300"
                             fill="none"
                             stroke="currentColor"
                             stroke-width="1.8"
                             viewBox="0 0 24 24">

                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  d="M12 3v18M17 7.5c0-2-2-3.5-5-3.5s-5 1.5-5 3.5 2 3 5 4 5 2 5 4-2 3.5-5 3.5-5-1.5-5-3.5"/>

                        </svg>

                    </div>

                </div>

                <p class="mt-4 text-2xl font-bold">

                    SSP {{ number_format((float) $totalEarnings, 0) }}

                </p>

                <p class="mt-1 text-xs text-slate-500">
                    Completed jobs
                </p>

            </div>

        </div>


        <!-- Main content -->
        <div class="mt-6 grid gap-6 lg:grid-cols-3">


            <!-- Upcoming jobs -->
            <section class="overflow-hidden rounded-3xl border border-white/10 bg-white/[0.045] shadow-2xl shadow-black/20 backdrop-blur-xl lg:col-span-2">


                <div class="flex items-center justify-between border-b border-white/10 px-6 py-5">

                    <div>

                        <h3 class="font-bold">
                            Upcoming Pickups
                        </h3>

                        <p class="mt-1 text-sm text-slate-400">
                            Your next assigned collection jobs.
                        </p>

                    </div>


                    <span class="rounded-full border border-white/10 bg-white/5 px-3 py-1.5 text-xs font-semibold text-slate-400">

                        {{ $upcomingJobs->count() }} jobs

                    </span>

                </div>


                @if($upcomingJobs->count())

                    <div class="divide-y divide-white/10">

                        @foreach($upcomingJobs as $job)

                            @php
                                $jobItem = $job->items->first();
                            @endphp

                            <div class="p-6 transition hover:bg-white/[0.025]">

                                <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

                                    <div class="flex gap-4">

                                        <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-emerald-400/10">

                                            <svg class="h-5 w-5 text-emerald-300"
                                                 fill="none"
                                                 stroke="currentColor"
                                                 stroke-width="1.8"
                                                 viewBox="0 0 24 24">

                                                <path stroke-linecap="round"
                                                      stroke-linejoin="round"
                                                      d="M6 7h12M8 7l1 13h6l1-13M9 7l1-3h4l1 3"/>

                                            </svg>

                                        </div>


                                        <div>

                                            <p class="font-semibold text-white">

                                                #SWJ-{{ str_pad($job->id, 5, '0', STR_PAD_LEFT) }}

                                            </p>


                                            <p class="mt-1 text-sm text-slate-300">

                                                {{ $jobItem?->wasteCategory?->name ?? 'Waste pickup' }}

                                                @if($jobItem)
                                                    • {{ $jobItem->quantity }} {{ strtoupper($jobItem->unit ?? 'kg') }}
                                                @endif

                                            </p>


                                            <p class="mt-1 text-xs text-slate-500">

                                                {{ $job->address?->area ?? 'Juba' }}

                                            </p>

                                        </div>

                                    </div>


                                    <div class="sm:text-right">

                                        <p class="font-semibold text-white">

                                            {{ $job->scheduled_at?->format('d M Y') }}

                                        </p>

                                        <p class="mt-1 text-xs text-slate-400">

                                            {{ $job->scheduled_at?->format('h:i A') }}

                                        </p>

                                    </div>

                                </div>


                                <div class="mt-4 flex flex-wrap gap-2">

                                    <span class="rounded-full border border-amber-400/20 bg-amber-400/10 px-3 py-1.5 text-xs font-semibold capitalize text-amber-300">

                                        {{ str_replace('_', ' ', $job->status ?? 'pending') }}

                                    </span>


                                    <span class="rounded-full border border-white/10 bg-white/5 px-3 py-1.5 text-xs text-slate-400">

                                        SSP {{ number_format((float) $job->total_amount, 0) }}

                                    </span>

                                </div>

                            </div>

                        @endforeach

                    </div>

                @else

                    <div class="px-6 py-14 text-center">

                        <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-white/5">

                            <svg class="h-8 w-8 text-slate-500"
                                 fill="none"
                                 stroke="currentColor"
                                 stroke-width="1.5"
                                 viewBox="0 0 24 24">

                                <rect x="3" y="4" width="18" height="17" rx="2"/>

                                <path stroke-linecap="round"
                                      d="M16 2v4M8 2v4M3 10h18"/>

                            </svg>

                        </div>

                        <h4 class="mt-5 font-semibold text-white">
                            No upcoming pickups
                        </h4>

                        <p class="mt-2 text-sm text-slate-500">
                            Assigned collection jobs will appear here.
                        </p>

                    </div>

                @endif

            </section>


            <!-- Quick actions -->
            <section class="rounded-3xl border border-white/10 bg-white/[0.045] p-6 shadow-2xl shadow-black/20 backdrop-blur-xl">

                <h3 class="font-bold">
                    Collector Tools
                </h3>

                <p class="mt-1 text-sm text-slate-400">
                    Quick access to your collection workspace.
                </p>


                <div class="mt-5 space-y-3">


                    <button type="button"
                            class="flex w-full items-center gap-4 rounded-2xl border border-white/10 bg-white/5 p-4 text-left transition hover:border-emerald-400/20 hover:bg-emerald-400/5">

                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-emerald-400/10">

                            <svg class="h-5 w-5 text-emerald-300"
                                 fill="none"
                                 stroke="currentColor"
                                 stroke-width="1.8"
                                 viewBox="0 0 24 24">

                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="M5 12h14M13 6l6 6-6 6"/>

                            </svg>

                        </div>

                        <div>

                            <p class="font-semibold">
                                My Jobs
                            </p>

                            <p class="text-xs text-slate-500">
                                View assigned pickups
                            </p>

                        </div>

                    </button>


                    <button type="button"
                            class="flex w-full items-center gap-4 rounded-2xl border border-white/10 bg-white/5 p-4 text-left transition hover:border-cyan-400/20 hover:bg-cyan-400/5">

                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-cyan-400/10">

                            <svg class="h-5 w-5 text-cyan-300"
                                 fill="none"
                                 stroke="currentColor"
                                 stroke-width="1.8"
                                 viewBox="0 0 24 24">

                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="M12 21s7-5.1 7-12a7 7 0 10-14 0c0 6.9 7 12 7 12z"/>

                                <circle cx="12" cy="9" r="2.5"/>

                            </svg>

                        </div>

                        <div>

                            <p class="font-semibold">
                                Route & Map
                            </p>

                            <p class="text-xs text-slate-500">
                                GPS and optimized routes
                            </p>

                        </div>

                    </button>


                    <button type="button"
                            class="flex w-full items-center gap-4 rounded-2xl border border-white/10 bg-white/5 p-4 text-left transition hover:border-purple-400/20 hover:bg-purple-400/5">

                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-purple-400/10">

                            <svg class="h-5 w-5 text-purple-300"
                                 fill="none"
                                 stroke="currentColor"
                                 stroke-width="1.8"
                                 viewBox="0 0 24 24">

                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="M12 3v18M17 7.5c0-2-2-3.5-5-3.5s-5 1.5-5 3.5 2 3 5 4 5 2 5 4-2 3.5-5 3.5-5-1.5-5-3.5"/>

                            </svg>

                        </div>

                        <div>

                            <p class="font-semibold">
                                Earnings
                            </p>

                            <p class="text-xs text-slate-500">
                                Collection earnings
                            </p>

                        </div>

                    </button>


                    <button type="button"
                            class="flex w-full items-center gap-4 rounded-2xl border border-white/10 bg-white/5 p-4 text-left transition hover:border-amber-400/20 hover:bg-amber-400/5">

                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-amber-400/10">

                            <svg class="h-5 w-5 text-amber-300"
                                 fill="none"
                                 stroke="currentColor"
                                 stroke-width="1.8"
                                 viewBox="0 0 24 24">

                                <circle cx="12" cy="12" r="8"/>

                                <path stroke-linecap="round"
                                      d="M12 8v4l2.5 2"/>

                            </svg>

                        </div>

                        <div>

                            <p class="font-semibold">
                                Availability
                            </p>

                            <p class="text-xs text-slate-500">
                                Manage working status
                            </p>

                        </div>

                    </button>

                </div>

            </section>

        </div>


        <!-- Recent completed -->
        <section class="mt-6 overflow-hidden rounded-3xl border border-white/10 bg-white/[0.045] shadow-2xl shadow-black/20 backdrop-blur-xl">

            <div class="border-b border-white/10 px-6 py-5">

                <h3 class="font-bold">
                    Recently Completed
                </h3>

                <p class="mt-1 text-sm text-slate-400">
                    Your latest completed collection jobs.
                </p>

            </div>


            @if($recentCompletedJobs->count())

                <div class="overflow-x-auto">

                    <table class="w-full min-w-[700px] text-left">

                        <thead class="border-b border-white/10 bg-white/[0.025]">

                            <tr>

                                <th class="px-6 py-4 text-xs font-semibold uppercase tracking-wider text-slate-500">
                                    Request
                                </th>

                                <th class="px-6 py-4 text-xs font-semibold uppercase tracking-wider text-slate-500">
                                    Waste
                                </th>

                                <th class="px-6 py-4 text-xs font-semibold uppercase tracking-wider text-slate-500">
                                    Area
                                </th>

                                <th class="px-6 py-4 text-xs font-semibold uppercase tracking-wider text-slate-500">
                                    Completed
                                </th>

                                <th class="px-6 py-4 text-xs font-semibold uppercase tracking-wider text-slate-500">
                                    Amount
                                </th>

                            </tr>

                        </thead>


                        <tbody class="divide-y divide-white/10">

                            @foreach($recentCompletedJobs as $job)

                                @php
                                    $jobItem = $job->items->first();
                                @endphp

                                <tr class="transition hover:bg-white/[0.025]">

                                    <td class="px-6 py-4">

                                        <span class="font-semibold text-white">

                                            #SWJ-{{ str_pad($job->id, 5, '0', STR_PAD_LEFT) }}

                                        </span>

                                    </td>


                                    <td class="px-6 py-4 text-sm text-slate-300">

                                        {{ $jobItem?->wasteCategory?->name ?? 'Waste pickup' }}

                                    </td>


                                    <td class="px-6 py-4 text-sm text-slate-400">

                                        {{ $job->address?->area ?? 'Juba' }}

                                    </td>


                                    <td class="px-6 py-4 text-sm text-slate-400">

                                        {{ $job->updated_at?->format('d M Y') }}

                                    </td>


                                    <td class="px-6 py-4">

                                        <span class="font-semibold text-emerald-300">

                                            SSP {{ number_format((float) $job->total_amount, 0) }}

                                        </span>

                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            @else

                <div class="px-6 py-12 text-center">

                    <p class="text-sm text-slate-500">
                        No completed jobs yet.
                    </p>

                </div>

            @endif

        </section>


    </main>

</body>

</html>