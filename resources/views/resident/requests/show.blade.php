<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        Request #SWJ-{{ str_pad($pickupRequest->id, 5, '0', STR_PAD_LEFT) }}
        | SmartWaste Juba Connect
    </title>

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

    <!-- Leaflet map styles -->
<link
    rel="stylesheet"
    href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
    integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
    crossorigin=""
/>
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

            <a href="{{ route('resident.dashboard') }}"
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
                        CONNECT
                    </p>

                </div>

            </a>


            <div class="flex items-center gap-3">

                <a href="{{ route('resident.requests.index') }}"
                   class="rounded-xl border border-white/10 px-4 py-2.5 text-sm font-medium text-slate-300 transition hover:bg-white/5 hover:text-white">

                    My Requests

                </a>

                <a href="{{ route('resident.pickups.create') }}"
                   class="hidden rounded-xl bg-emerald-500 px-4 py-2.5 text-sm font-semibold text-white shadow-lg shadow-emerald-500/20 transition hover:bg-emerald-400 sm:block">

                    + New Request

                </a>

            </div>

        </div>

    </nav>


    <!-- Main -->
    <main class="mx-auto max-w-6xl px-5 py-8 lg:px-8 lg:py-10">


        <!-- Back -->
        <div class="mb-6">

            <a href="{{ route('resident.requests.index') }}"
               class="inline-flex items-center gap-2 text-sm font-medium text-slate-400 transition hover:text-emerald-300">

                <svg class="h-4 w-4"
                     fill="none"
                     stroke="currentColor"
                     stroke-width="2"
                     viewBox="0 0 24 24">

                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M19 12H5M12 19l-7-7 7-7"/>

                </svg>

                Back to My Requests

            </a>

        </div>


        <!-- Header -->
        <div class="mb-8 flex flex-col justify-between gap-5 md:flex-row md:items-end">

            <div>

                <div class="mb-3 inline-flex items-center gap-2 rounded-full border border-emerald-400/20 bg-emerald-400/10 px-3 py-1.5 text-xs font-medium text-emerald-300">

                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-400"></span>

                    Pickup Request

                </div>

                <h2 class="text-3xl font-bold tracking-tight sm:text-4xl">

                    Request #SWJ-{{ str_pad($pickupRequest->id, 5, '0', STR_PAD_LEFT) }}

                </h2>

                <p class="mt-2 text-sm text-slate-400">

                    Submitted
                    {{ $pickupRequest->created_at?->format('d M Y, h:i A') }}

                </p>

            </div>


            @php

                $status = strtolower($pickupRequest->status ?? 'pending');

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

                $paymentStatus = strtolower($pickupRequest->payment_status ?? 'pending');

                $paymentClasses = match($paymentStatus) {

                    'paid', 'completed' =>
                        'border-emerald-400/20 bg-emerald-400/10 text-emerald-300',

                    'failed', 'cancelled', 'canceled' =>
                        'border-red-400/20 bg-red-400/10 text-red-300',

                    default =>
                        'border-amber-400/20 bg-amber-400/10 text-amber-300',
                };

            @endphp


            <div class="flex flex-wrap gap-2">

                <span class="rounded-full border px-4 py-2 text-xs font-bold uppercase tracking-wide {{ $statusClasses }}">

                    {{ str_replace('_', ' ', $pickupRequest->status ?? 'pending') }}

                </span>

                <span class="rounded-full border px-4 py-2 text-xs font-bold uppercase tracking-wide {{ $paymentClasses }}">

                    Payment:
                    {{ str_replace('_', ' ', $pickupRequest->payment_status ?? 'pending') }}

                </span>

            </div>

        </div>


        <!-- Main grid -->
        <div class="grid gap-6 lg:grid-cols-3">


            <!-- Left / Main content -->
            <div class="space-y-6 lg:col-span-2">


                <!-- Pickup summary -->
                <section class="overflow-hidden rounded-3xl border border-white/10 bg-white/[0.045] shadow-2xl shadow-black/20 backdrop-blur-xl">

                    <div class="border-b border-white/10 px-6 py-5">

                        <h3 class="text-lg font-bold">
                            Pickup Summary
                        </h3>

                        <p class="mt-1 text-sm text-slate-400">
                            Details of the waste collection request.
                        </p>

                    </div>


                    <div class="grid gap-px bg-white/10 sm:grid-cols-2">

                        <div class="bg-slate-950/60 p-5">

                            <p class="text-[11px] font-semibold uppercase tracking-wider text-slate-500">
                                Waste Type
                            </p>

                            @foreach($pickupRequest->items as $item)

                                <p class="mt-2 font-semibold text-white">
                                    {{ $item->wasteCategory?->name ?? 'Not specified' }}
                                </p>

                            @endforeach

                        </div>


                        <div class="bg-slate-950/60 p-5">

                            <p class="text-[11px] font-semibold uppercase tracking-wider text-slate-500">
                                Quantity
                            </p>

                            @foreach($pickupRequest->items as $item)

                                <p class="mt-2 font-semibold text-white">
                                    {{ $item->quantity }}
                                    {{ strtoupper($item->unit ?? 'kg') }}
                                </p>

                            @endforeach

                        </div>


                        <div class="bg-slate-950/60 p-5">

                            <p class="text-[11px] font-semibold uppercase tracking-wider text-slate-500">
                                Pickup Date
                            </p>

                            <p class="mt-2 font-semibold text-white">

                                {{ $pickupRequest->scheduled_at?->format('d F Y') }}

                            </p>

                        </div>


                        <div class="bg-slate-950/60 p-5">

                            <p class="text-[11px] font-semibold uppercase tracking-wider text-slate-500">
                                Pickup Time
                            </p>

                            <p class="mt-2 font-semibold text-white">

                                {{ $pickupRequest->scheduled_at?->format('h:i A') }}

                            </p>

                        </div>


                        <div class="bg-slate-950/60 p-5">

                            <p class="text-[11px] font-semibold uppercase tracking-wider text-slate-500">
                                Request Type
                            </p>

                            <p class="mt-2 font-semibold capitalize text-white">

                                {{ str_replace('_', ' ', $pickupRequest->request_type) }}

                            </p>

                            @if($pickupRequest->request_type === 'recurring')

                                <p class="mt-1 text-xs text-purple-300">

                                    {{ ucfirst($pickupRequest->recurrence_frequency ?? 'Recurring') }}

                                </p>

                            @endif

                        </div>


                        <div class="bg-slate-950/60 p-5">

                            <p class="text-[11px] font-semibold uppercase tracking-wider text-slate-500">
                                Created
                            </p>

                            <p class="mt-2 font-semibold text-white">

                                {{ $pickupRequest->created_at?->format('d M Y') }}

                            </p>

                        </div>

                    </div>

                </section>


                <!-- Location -->
                <section class="overflow-hidden rounded-3xl border border-white/10 bg-white/[0.045] shadow-2xl shadow-black/20 backdrop-blur-xl">

                    <div class="border-b border-white/10 px-6 py-5">

                        <div class="flex items-center gap-3">

                            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-cyan-400/10">

                                <svg class="h-5 w-5 text-cyan-300"
                                     fill="none"
                                     stroke="currentColor"
                                     stroke-width="1.8"
                                     viewBox="0 0 24 24">

                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          d="M12 21s7-5.1 7-12a7 7 0 10-14 0c0 6.9 7 12 7 12z"/>

                                    <circle cx="12"
                                            cy="9"
                                            r="2.5"/>

                                </svg>

                            </div>

                            <div>

                                <h3 class="font-bold">
                                    Pickup Location
                                </h3>

                                <p class="text-sm text-slate-400">
                                    Where the collector should collect the waste.
                                </p>

                                ```html
<!-- Collector GPS Tracking Map -->
<div class="mt-5 rounded-2xl border border-slate-700 bg-slate-900/70 p-4">

    <div class="mb-4 flex flex-wrap items-center justify-between gap-3">
        <div>
            <h4 class="font-semibold text-white">
                Live Collector Tracking
            </h4>
            <p class="mt-1 text-sm text-slate-400">
                View the latest reported collector location.
            </p>
        </div>

        <span
            id="collector-tracking-status"
            class="rounded-full bg-slate-800 px-3 py-1 text-xs text-slate-300"
            aria-live="polite"
        >
            Checking location...
        </span>
    </div>

    <div
        id="collector-tracking-map"
        class="w-full overflow-hidden rounded-xl bg-slate-800"
        style="height: 320px;"
        role="application"
        aria-label="Map showing the waste collector's reported location"
    ></div>

    <div class="mt-4 grid gap-3 sm:grid-cols-2">
        <div>
            <p class="text-xs text-slate-400">Collector</p>
            <p
                id="collector-tracking-name"
                class="mt-1 font-medium text-white"
            >
                Waiting for collector information
            </p>
        </div>

        <div>
            <p class="text-xs text-slate-400">Last GPS update</p>
            <p
                id="collector-tracking-updated"
                class="mt-1 text-sm text-white"
            >
                Not available yet
            </p>
        </div>
    </div>

    <p
        id="collector-tracking-message"
        class="mt-3 text-sm text-slate-400"
        aria-live="polite"
    >
        Loading the latest location...
    </p>

    <a
        id="collector-tracking-directions"
        href="#"
        target="_blank"
        rel="noopener noreferrer"
        class="mt-4 hidden inline-flex rounded-lg bg-emerald-600 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-500"
    >
        Open location in Google Maps
    </a>

            </div>
        <!-- End Collector GPS Tracking Map -->
            ```

                            </div>

                        </div>

                    </div>


                    @if($pickupRequest->address)

                        <div class="space-y-4 p-6">

                            <div>

                                <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">
                                    Location Name
                                </p>

                                <p class="mt-1 font-semibold text-white">
                                    {{ $pickupRequest->address->label }}
                                </p>

                            </div>


                            <div class="grid gap-4 sm:grid-cols-2">

                                <div>

                                    <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">
                                        Area
                                    </p>

                                    <p class="mt-1 text-sm text-slate-200">
                                        {{ $pickupRequest->address->area ?? 'Not provided' }}
                                    </p>

                                </div>


                                <div>

                                    <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">
                                        City
                                    </p>

                                    <p class="mt-1 text-sm text-slate-200">
                                        {{ $pickupRequest->address->city ?? 'Juba' }}
                                    </p>

                                </div>

                            </div>


                            <div>

                                <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">
                                    Building / Road / House Details
                                </p>

                                <p class="mt-1 text-sm leading-6 text-slate-200">
                                    {{ $pickupRequest->address->address_line }}
                                </p>

                            </div>


                            @if($pickupRequest->address->landmark)

                                <div>

                                    <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">
                                        Nearby Landmark
                                    </p>

                                    <p class="mt-1 text-sm leading-6 text-slate-200">
                                        {{ $pickupRequest->address->landmark }}
                                    </p>

                                </div>

                            @endif


                            @if($pickupRequest->address->directions)

                                <div class="rounded-2xl border border-cyan-400/10 bg-cyan-400/5 p-4">

                                    <p class="text-xs font-semibold uppercase tracking-wider text-cyan-300">
                                        Directions for Collector
                                    </p>

                                    <p class="mt-1 text-sm leading-6 text-slate-200">
                                        {{ $pickupRequest->address->directions }}
                                    </p>

                                </div>

                            @endif

                        </div>

                    @else

                        <div class="p-6 text-sm text-slate-400">
                            Pickup location information is unavailable.
                        </div>

                    @endif

                </section>


                <!-- Waste photo -->
                @if($pickupRequest->photo_path)

                    <section class="overflow-hidden rounded-3xl border border-white/10 bg-white/[0.045] shadow-2xl shadow-black/20 backdrop-blur-xl">

                        <div class="border-b border-white/10 px-6 py-5">

                            <h3 class="font-bold">
                                Waste Photo
                            </h3>

                            <p class="mt-1 text-sm text-slate-400">
                                Photo submitted with this pickup request.
                            </p>

                        </div>

                        <div class="p-6">

                            <img
                                src="{{ asset('storage/' . $pickupRequest->photo_path) }}"
                                alt="Waste submitted for pickup"
                                class="max-h-[500px] w-full rounded-2xl border border-white/10 object-cover"
                            >

                        </div>

                    </section>

                @endif


                <!-- Notes -->
                @if($pickupRequest->notes)

                    <section class="rounded-3xl border border-white/10 bg-white/[0.045] p-6 shadow-2xl shadow-black/20 backdrop-blur-xl">

                        <div class="flex gap-4">

                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-amber-400/10">

                                <svg class="h-5 w-5 text-amber-300"
                                     fill="none"
                                     stroke="currentColor"
                                     stroke-width="1.8"
                                     viewBox="0 0 24 24">

                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          d="M8 10h8M8 14h5"/>

                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          d="M19 4H5a2 2 0 00-2 2v10a2 2 0 002 2h3l4 3 4-3h3a2 2 0 002-2V6a2 2 0 00-2-2z"/>

                                </svg>

                            </div>

                            <div>

                                <h3 class="font-bold">
                                    Additional Notes
                                </h3>

                                <p class="mt-2 text-sm leading-6 text-slate-300">
                                    {{ $pickupRequest->notes }}
                                </p>

                            </div>

                        </div>

                    </section>

                @endif

            </div>


            <!-- Right / Summary -->
            <aside class="space-y-6">


                <!-- Fee -->
                <section class="overflow-hidden rounded-3xl border border-emerald-400/20 bg-emerald-400/[0.06] shadow-2xl shadow-black/20 backdrop-blur-xl">

                    <div class="border-b border-emerald-400/10 px-6 py-5">

                        <p class="text-xs font-semibold uppercase tracking-wider text-emerald-300">
                            Request Cost
                        </p>

                        <p class="mt-2 text-3xl font-bold text-white">

                            SSP {{ number_format((float) $pickupRequest->total_amount, 0) }}

                        </p>

                    </div>


                    <div class="space-y-4 p-6">

                        <div class="flex items-center justify-between text-sm">

                            <span class="text-slate-400">
                                Payment Status
                            </span>

                            <span class="font-semibold capitalize text-amber-300">
                                {{ str_replace('_', ' ', $pickupRequest->payment_status ?? 'pending') }}
                            </span>

                        </div>


                        <div class="flex items-center justify-between text-sm">

                            <span class="text-slate-400">
                                Payment Method
                            </span>

                            <span class="font-semibold text-slate-200">
                                {{ $pickupRequest->payment?->method
                                    ? ucwords(str_replace('_', ' ', $pickupRequest->payment->method))
                                    : 'Not selected' }}
                            </span>

                        </div>


                        <div class="border-t border-white/10 pt-4">

                            <p class="text-xs leading-5 text-slate-500">

                                Payment integration will be available in the next
                                payment module.

                            </p>

                        </div>

                    </div>

                </section>


                <!-- Request status -->
                <section class="rounded-3xl border border-white/10 bg-white/[0.045] p-6 shadow-2xl shadow-black/20 backdrop-blur-xl">

                    <h3 class="font-bold">
                        Request Status
                    </h3>


                    <div class="mt-6">

                        <div class="flex gap-4">

                            <div class="flex flex-col items-center">

                                <div class="flex h-9 w-9 items-center justify-center rounded-full bg-emerald-500/15 ring-1 ring-emerald-400/20">

                                    <span class="h-2.5 w-2.5 rounded-full bg-emerald-400"></span>

                                </div>

                                <div class="h-12 w-px bg-white/10"></div>

                            </div>


                            <div class="pb-6">

                                <p class="font-semibold text-white">
                                    Request Submitted
                                </p>

                                <p class="mt-1 text-xs leading-5 text-slate-500">
                                    Your pickup request has been successfully recorded.
                                </p>

                            </div>

                        </div>


                        <div class="flex gap-4">

                            <div class="flex flex-col items-center">

                                <div class="flex h-9 w-9 items-center justify-center rounded-full border border-amber-400/20 bg-amber-400/10">

                                    <span class="h-2.5 w-2.5 rounded-full bg-amber-400"></span>

                                </div>

                            </div>


                            <div>

                                <p class="font-semibold capitalize text-white">

                                    {{ str_replace('_', ' ', $pickupRequest->status ?? 'pending') }}

                                </p>

                                <p class="mt-1 text-xs leading-5 text-slate-500">

                                    The current request status.

                                </p>

                            </div>

                        </div>

                    </div>

                </section>


                <!-- Actions -->
                <section class="rounded-3xl border border-white/10 bg-white/[0.045] p-6 shadow-2xl shadow-black/20 backdrop-blur-xl">

                    <h3 class="font-bold">
                        Actions
                    </h3>


                    <div class="mt-4 space-y-3">

                        <a href="{{ route('resident.requests.index') }}"
                           class="flex w-full items-center justify-center rounded-xl border border-white/10 bg-white/5 px-4 py-3 text-sm font-semibold text-slate-200 transition hover:bg-white/10">

                            ← Back to My Requests

                        </a>


                        <a href="{{ route('resident.pickups.create') }}"
                           class="flex w-full items-center justify-center rounded-xl bg-emerald-500 px-4 py-3 text-sm font-bold text-white shadow-lg shadow-emerald-500/20 transition hover:bg-emerald-400">

                            + Create Another Request

                        </a>

                    </div>

                </section>

            </aside>

        </div>

    </main>
    <!-- Leaflet map JavaScript -->
<script
    src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
    integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
    crossorigin=""
></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const mapElement = document.getElementById('collector-tracking-map');

    // Do nothing if this page does not contain the tracking map.
    if (!mapElement || typeof L === 'undefined') {
        return;
    }

    const statusElement = document.getElementById('collector-tracking-status');
    const nameElement = document.getElementById('collector-tracking-name');
    const updatedElement = document.getElementById('collector-tracking-updated');
    const messageElement = document.getElementById('collector-tracking-message');
    const directionsElement = document.getElementById('collector-tracking-directions');

    // Laravel generates the correct tracking URL for this pickup request.
    const trackingUrl = @json(route('resident.requests.tracking', $pickupRequest->id));

    // Initial map centre: Juba. The map will move to the collector when found.
    const map = L.map(mapElement).setView([4.8594, 31.5713], 13);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors',
        maxZoom: 19
    }).addTo(map);

    let collectorMarker = null;
    let accuracyCircle = null;
    let lastLocationKey = null;
    let requestInProgress = false;

    function setStatus(text, className) {
        statusElement.textContent = text;
        statusElement.className =
            'rounded-full px-3 py-1 text-xs ' + className;
    }

    async function refreshCollectorLocation() {
        if (requestInProgress) return;

        requestInProgress = true;

        try {
            const response = await fetch(trackingUrl, {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                cache: 'no-store'
            });

            if (!response.ok) {
                throw new Error('Tracking request failed: ' + response.status);
            }

            const data = await response.json();

            if (!data.available) {
                setStatus(
                    'Location unavailable',
                    'bg-amber-900/60 text-amber-200'
                );

                messageElement.textContent = data.message ||
                    'The collector location is not available yet.';

                nameElement.textContent = data.collector || 'Not assigned';
                updatedElement.textContent = 'Not available';
                directionsElement.classList.add('hidden');

                return;
            }

            const latitude = Number(data.latitude);
            const longitude = Number(data.longitude);

            if (
                !Number.isFinite(latitude) ||
                !Number.isFinite(longitude) ||
                latitude < -90 || latitude > 90 ||
                longitude < -180 || longitude > 180
            ) {
                throw new Error('The server returned invalid coordinates.');
            }

            const position = [latitude, longitude];
            const accuracy = Number(data.accuracy);
            const validAccuracy = Number.isFinite(accuracy) && accuracy >= 0;

            const locationKey = [
                latitude,
                longitude,
                data.recorded_at || ''
            ].join('|');

            nameElement.textContent = data.collector || 'Assigned collector';

            if (data.recorded_at) {
                const recordedDate = new Date(data.recorded_at);
                const ageSeconds = (Date.now() - recordedDate.getTime()) / 1000;

                updatedElement.textContent =
                    Number.isNaN(recordedDate.getTime())
                        ? data.recorded_at
                        : recordedDate.toLocaleString();

                if (ageSeconds > 60) {
                    setStatus(
                        'GPS may be outdated',
                        'bg-amber-900/60 text-amber-200'
                    );

                    messageElement.textContent =
                        'The last reported location is more than a minute old. ' +
                        'The collector may not be sharing new GPS updates.';
                } else {
                    setStatus(
                        'Location recently updated',
                        'bg-emerald-900/60 text-emerald-200'
                    );

                    messageElement.textContent = validAccuracy
                        ? 'Reported GPS accuracy: approximately ' +
                          Math.round(accuracy) + ' metres.'
                        : 'The collector location has been received.';
                }
            } else {
                updatedElement.textContent = 'Timestamp unavailable';

                setStatus(
                    'Timestamp unavailable',
                    'bg-amber-900/60 text-amber-200'
                );

                messageElement.textContent =
                    'Coordinates received, but the update time is unknown.';
            }

            if (locationKey !== lastLocationKey) {
                if (!collectorMarker) {
                    collectorMarker = L.marker(position)
                        .addTo(map)
                        .bindPopup('Collector: ' + (data.collector || 'Assigned collector'));

                    map.setView(position, 16);
                } else {
                    collectorMarker.setLatLng(position);
                }

                if (validAccuracy) {
                    if (!accuracyCircle) {
                        accuracyCircle = L.circle(position, {
                            radius: accuracy,
                            color: '#059669',
                            fillColor: '#10b981',
                            fillOpacity: 0.12,
                            weight: 2
                        }).addTo(map);
                    } else {
                        accuracyCircle.setLatLng(position);
                        accuracyCircle.setRadius(accuracy);
                    }
                } else if (accuracyCircle) {
                    map.removeLayer(accuracyCircle);
                    accuracyCircle = null;
                }

                lastLocationKey = locationKey;
            }

            directionsElement.href =
                'https://www.google.com/maps/dir/?api=1&destination=' +
                encodeURIComponent(latitude + ',' + longitude);

            directionsElement.classList.remove('hidden');

            // Ensure the map displays correctly after layout rendering.
            map.invalidateSize();

        } catch (error) {
            console.error('Collector tracking error:', error);

            setStatus(
                'Connection problem',
                'bg-red-900/60 text-red-200'
            );

            messageElement.textContent =
                'Could not refresh the collector location. Check your connection and try again.';
        } finally {
            requestInProgress = false;
        }
    }

    // Load the first location, then check every 10 seconds.
    refreshCollectorLocation();
    window.setInterval(refreshCollectorLocation, 10000);

    // Help the map resize if the browser window changes.
    window.addEventListener('resize', function () {
        map.invalidateSize();
    });
});
</script>

</body>
</html>