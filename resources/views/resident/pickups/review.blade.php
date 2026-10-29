<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        Review Pickup Request | SmartWaste Juba Connect
    </title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap"
        rel="stylesheet"
    >

    <style>
        body {
            font-family: 'Manrope', sans-serif;
        }
    </style>
</head>

<body class="min-h-screen bg-slate-950">

<div class="min-h-screen bg-gradient-to-br from-slate-950 via-emerald-950 to-slate-900">

    {{-- Navigation --}}
    <nav class="border-b border-white/10 bg-black/20 backdrop-blur-xl">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-5 sm:px-6 lg:px-8">

            <a
                href="{{ route('resident.dashboard') }}"
                class="flex items-center gap-3"
            >

                <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-emerald-500 shadow-lg shadow-emerald-500/20">
                    <span class="text-xl">♻</span>
                </div>

                <div>
                    <p class="text-base font-extrabold text-white">
                        SmartWaste
                    </p>

                    <p class="text-xs font-medium text-emerald-300">
                        Juba Connect
                    </p>
                </div>

            </a>

            <div class="hidden text-right sm:block">
                <p class="text-sm font-semibold text-white">
                    Review Request
                </p>

                <p class="text-xs text-slate-400">
                    Before payment
                </p>
            </div>

        </div>
    </nav>


    {{-- Main --}}
    <main class="mx-auto max-w-7xl px-4 py-8 sm:px-6 sm:py-10 lg:px-8">

        {{-- Back --}}
        <a
            href="{{ route('resident.pickups.create') }}"
            class="mb-6 inline-flex items-center gap-2 text-sm font-semibold text-emerald-300 transition hover:text-emerald-200"
        >
            ← Back to Pickup Request
        </a>


        {{-- Page Header --}}
        <div class="mb-8">

            <p class="text-sm font-bold uppercase tracking-[0.2em] text-emerald-400">
                SmartWaste Juba Connect
            </p>

            <h1 class="mt-2 text-3xl font-extrabold tracking-tight text-white sm:text-4xl">
                Review Your Pickup
            </h1>

            <p class="mt-3 max-w-2xl text-sm leading-6 text-slate-400 sm:text-base">
                Check your pickup details carefully before proceeding to payment.
            </p>

        </div>


        {{-- Success --}}
        @if(session('success'))

            <div class="mb-6 rounded-2xl border border-emerald-400/20 bg-emerald-500/10 p-4 backdrop-blur-xl">

                <div class="flex items-start gap-3">

                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-emerald-500 text-white">
                        ✓
                    </div>

                    <div>
                        <p class="font-bold text-emerald-300">
                            Pickup request created
                        </p>

                        <p class="mt-1 text-sm text-emerald-200/80">
                            Your request has been successfully saved.
                        </p>
                    </div>

                </div>

            </div>

        @endif


        <div class="grid gap-6 lg:grid-cols-3">


            {{-- LEFT SIDE --}}
            <div class="space-y-6 lg:col-span-2">


                {{-- Request Overview --}}
                <section class="overflow-hidden rounded-3xl border border-white/10 bg-white/[0.06] shadow-2xl backdrop-blur-xl">

                    <div class="border-b border-white/10 px-6 py-5">

                        <div class="flex flex-wrap items-center justify-between gap-4">

                            <div>

                                <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">
                                    Pickup Request
                                </p>

                                <h2 class="mt-1 text-xl font-extrabold text-white">
                                    #SWJ-{{ str_pad($pickupRequest->id, 5, '0', STR_PAD_LEFT) }}
                                </h2>

                            </div>

                            <span class="rounded-full bg-amber-400/10 px-4 py-2 text-xs font-bold capitalize text-amber-300">
                                {{ str_replace('_', ' ', $pickupRequest->status) }}
                            </span>

                        </div>

                    </div>


                    <div class="grid gap-4 p-6 sm:grid-cols-2">


                        {{-- Waste --}}
                        <div class="rounded-2xl border border-white/10 bg-black/20 p-5">

                            <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">
                                Waste Type
                            </p>

                            <p class="mt-2 text-lg font-bold text-white">
                                {{ $pickupRequest->items->first()?->wasteCategory?->name ?? 'Not specified' }}
                            </p>

                        </div>


                        {{-- Quantity --}}
                        <div class="rounded-2xl border border-white/10 bg-black/20 p-5">

                            <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">
                                Quantity
                            </p>

                            <p class="mt-2 text-lg font-bold text-white">
                                {{ number_format($pickupRequest->items->first()?->quantity ?? 0, 2) }}
                                {{ $pickupRequest->items->first()?->unit ?? 'kg' }}
                            </p>

                        </div>


                        {{-- Date --}}
                        <div class="rounded-2xl border border-white/10 bg-black/20 p-5">

                            <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">
                                Pickup Date
                            </p>

                            <p class="mt-2 text-lg font-bold text-white">
                                {{ \Carbon\Carbon::parse($pickupRequest->scheduled_at)->format('d F Y') }}
                            </p>

                        </div>


                        {{-- Time --}}
                        <div class="rounded-2xl border border-white/10 bg-black/20 p-5">

                            <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">
                                Pickup Time
                            </p>

                            <p class="mt-2 text-lg font-bold text-white">
                                {{ \Carbon\Carbon::parse($pickupRequest->scheduled_at)->format('g:i A') }}
                            </p>

                        </div>


                        {{-- Request Type --}}
                        <div class="rounded-2xl border border-white/10 bg-black/20 p-5">

                            <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">
                                Request Type
                            </p>

                            <p class="mt-2 text-lg font-bold capitalize text-white">
                                {{ str_replace('_', ' ', $pickupRequest->request_type) }}
                            </p>

                            @if($pickupRequest->recurrence_frequency)

                                <p class="mt-1 text-xs text-slate-400">
                                    {{ ucfirst($pickupRequest->recurrence_frequency) }}
                                </p>

                            @endif

                        </div>


                        {{-- Payment Status --}}
                        <div class="rounded-2xl border border-white/10 bg-black/20 p-5">

                            <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">
                                Payment Status
                            </p>

                            <p class="mt-2 text-lg font-bold capitalize text-white">
                                {{ str_replace('_', ' ', $pickupRequest->payment_status) }}
                            </p>

                        </div>

                    </div>

                </section>


                {{-- Pickup Location --}}
                <section class="overflow-hidden rounded-3xl border border-white/10 bg-white/[0.06] shadow-2xl backdrop-blur-xl">

                    <div class="border-b border-white/10 px-6 py-5">

                        <p class="text-xs font-semibold uppercase tracking-wider text-emerald-400">
                            Collection Point
                        </p>

                        <h2 class="mt-1 text-xl font-extrabold text-white">
                            Pickup Location
                        </h2>

                    </div>


                    <div class="space-y-6 p-6">


                        {{-- Location name --}}
                        <div>

                            <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">
                                Location Name
                            </p>

                            <p class="mt-2 font-bold text-white">
                                {{ $pickupRequest->address->label ?? 'Pickup Location' }}
                            </p>

                        </div>


                        <div class="grid gap-5 sm:grid-cols-2">

                            <div>

                                <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">
                                    Area
                                </p>

                                <p class="mt-2 font-semibold text-white">
                                    {{ $pickupRequest->address->area ?? 'Not specified' }}
                                </p>

                            </div>


                            <div>

                                <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">
                                    City
                                </p>

                                <p class="mt-2 font-semibold text-white">
                                    {{ $pickupRequest->address->city ?? 'Juba' }}
                                </p>

                            </div>

                        </div>


                        {{-- Address --}}
                        <div>

                            <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">
                                House / Building / Address
                            </p>

                            <p class="mt-2 leading-6 text-slate-200">
                                {{ $pickupRequest->address->address_line ?? 'Not specified' }}
                            </p>

                        </div>


                        {{-- Landmark --}}
                        @if($pickupRequest->address->landmark)

                            <div>

                                <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">
                                    Nearby Landmark
                                </p>

                                <p class="mt-2 leading-6 text-slate-200">
                                    {{ $pickupRequest->address->landmark }}
                                </p>

                            </div>

                        @endif


                        {{-- Directions --}}
                        @if($pickupRequest->address->directions)

                            <div>

                                <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">
                                    Directions
                                </p>

                                <p class="mt-2 leading-6 text-slate-200">
                                    {{ $pickupRequest->address->directions }}
                                </p>

                            </div>

                        @endif

                    </div>

                </section>


                {{-- Waste Photo --}}
                @if($pickupRequest->photo_path)

                    <section class="overflow-hidden rounded-3xl border border-white/10 bg-white/[0.06] shadow-2xl backdrop-blur-xl">

                        <div class="border-b border-white/10 px-6 py-5">

                            <p class="text-xs font-semibold uppercase tracking-wider text-emerald-400">
                                Evidence
                            </p>

                            <h2 class="mt-1 text-xl font-extrabold text-white">
                                Waste Photo
                            </h2>

                        </div>

                        <div class="p-6">

                            <img
                                src="{{ asset('storage/' . $pickupRequest->photo_path) }}"
                                alt="Waste photo"
                                class="max-h-[420px] w-full rounded-2xl object-cover"
                            >

                        </div>

                    </section>

                @endif


                {{-- Notes --}}
                @if($pickupRequest->notes)

                    <section class="rounded-3xl border border-white/10 bg-white/[0.06] p-6 shadow-2xl backdrop-blur-xl">

                        <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">
                            Additional Notes
                        </p>

                        <p class="mt-3 leading-7 text-slate-200">
                            {{ $pickupRequest->notes }}
                        </p>

                    </section>

                @endif


            </div>


            {{-- RIGHT SIDE --}}
            <aside class="lg:col-span-1">

                <div class="sticky top-6 overflow-hidden rounded-3xl border border-emerald-400/20 bg-white/[0.07] shadow-2xl backdrop-blur-xl">


                    {{-- Amount --}}
                    <div class="bg-gradient-to-br from-emerald-600 to-green-700 px-6 py-7">

                        <p class="text-sm font-semibold text-emerald-100">
                            Estimated Pickup Fee
                        </p>

                        <p class="mt-2 text-4xl font-extrabold text-white">
                            {{ number_format($pickupRequest->total_amount, 2) }}

                            <span class="text-base font-semibold">
                                SSP
                            </span>
                        </p>

                    </div>


                    <div class="space-y-6 p-6">


                        {{-- Summary --}}
                        <div class="space-y-4">

                            <div class="flex items-center justify-between gap-4">

                                <span class="text-sm text-slate-400">
                                    Base fee
                                </span>

                                <span class="font-semibold text-white">
                                    1,000 SSP
                                </span>

                            </div>


                            <div class="flex items-center justify-between gap-4">

                                <span class="text-sm text-slate-400">
                                    Quantity
                                </span>

                                <span class="font-semibold text-white">
                                    {{ number_format($pickupRequest->items->first()?->quantity ?? 0, 2) }} kg
                                </span>

                            </div>


                            <div class="border-t border-white/10 pt-5">

                                <div class="flex items-center justify-between gap-4">

                                    <span class="font-bold text-slate-200">
                                        Total
                                    </span>

                                    <span class="text-xl font-extrabold text-emerald-400">
                                        {{ number_format($pickupRequest->total_amount, 2) }} SSP
                                    </span>

                                </div>

                            </div>

                        </div>


                        {{-- Payment Button --}}
                        <button
                            type="button"
                            disabled
                            class="w-full cursor-not-allowed rounded-2xl bg-slate-700 px-5 py-4 font-bold text-slate-400"
                        >
                            Proceed to Payment
                        </button>


                        <p class="text-center text-xs leading-5 text-slate-500">
                            Payment will be enabled after the review step is confirmed.
                        </p>


                        {{-- Saved --}}
                        <div class="rounded-2xl border border-emerald-400/20 bg-emerald-500/10 p-4">

                            <div class="flex gap-3">

                                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-emerald-500 text-white">
                                    ✓
                                </div>

                                <div>

                                    <p class="text-sm font-bold text-emerald-300">
                                        Request Saved
                                    </p>

                                    <p class="mt-1 text-xs leading-5 text-emerald-200/70">
                                        Your pickup request has been securely stored in the SmartWaste Juba database.
                                    </p>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </aside>

        </div>

    </main>

</div>

</body>
</html>