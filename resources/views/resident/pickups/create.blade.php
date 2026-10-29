<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Request Waste Pickup | SmartWaste Juba Connect</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        * {
            font-family: 'Manrope', sans-serif;
        }

        body {
            background:
                linear-gradient(
                    135deg,
                    rgba(3, 44, 29, 0.90),
                    rgba(5, 91, 57, 0.72)
                ),
                url('/images/smartwaste-forest-bg.svg') center/cover fixed;
        }

        .glass {
            background: rgba(255, 255, 255, 0.93);
            backdrop-filter: blur(22px);
            -webkit-backdrop-filter: blur(22px);
            border: 1px solid rgba(255, 255, 255, 0.60);
            box-shadow: 0 20px 60px rgba(0, 35, 20, 0.20);
        }

        .glass-dark {
            background: rgba(8, 62, 39, 0.72);
            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);
            border: 1px solid rgba(255, 255, 255, 0.13);
        }

        .input-field {
            transition: all 0.2s ease;
        }

        .input-field:focus {
            outline: none;
            border-color: #16a34a;
            box-shadow: 0 0 0 4px rgba(22, 163, 74, 0.10);
        }

        .waste-option {
            transition: all 0.2s ease;
        }

        .waste-option:hover {
            transform: translateY(-2px);
        }

        .waste-option.selected {
            border-color: #16a34a;
            background: #f0fdf4;
            box-shadow: 0 8px 25px rgba(22, 163, 74, 0.12);
        }

        .upload-zone {
            transition: all 0.2s ease;
        }

        .upload-zone:hover {
            border-color: #16a34a;
            background: #f0fdf4;
        }

        .preview-image {
            object-fit: cover;
        }

        .sticky-summary {
            position: sticky;
            top: 24px;
        }

        @media (max-width: 1023px) {
            .sticky-summary {
                position: static;
            }
        }
    </style>

    <link
    rel="stylesheet"
    href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
/>

<style>
    #pickupLocationMap {
        width: 100%;
        height: 360px;
        min-height: 300px;
        border-radius: 16px;
        z-index: 1;
    }
</style>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

</head>

<body class="min-h-screen text-slate-800">

<div class="min-h-screen">

    <!-- Top Navigation -->
    <header class="px-4 pt-4 sm:px-6 lg:px-10">
        <div class="mx-auto max-w-7xl glass-dark rounded-3xl px-4 py-3 sm:px-6">

            <div class="flex items-center justify-between">

                <a href="{{ route('resident.dashboard') }}"
                   class="flex items-center gap-3">

                    <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-white/15 border border-white/20">
                        <svg class="h-6 w-6 text-emerald-300"
                             fill="none"
                             stroke="currentColor"
                             stroke-width="1.8"
                             viewBox="0 0 24 24">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  d="M12 3v18M5 8c2.5 0 4.5 1.5 5.5 4M19 8c-2.5 0-4.5 1.5-5.5 4M7 17c1.5-2 3-3 5-3s3.5 1 5 3"/>
                        </svg>
                    </div>

                    <div>
                        <p class="text-sm font-extrabold text-white">
                            SmartWaste
                        </p>
                        <p class="text-[11px] text-emerald-200">
                            Juba Connect
                        </p>
                    </div>

                </a>

                <a href="{{ route('resident.dashboard') }}"
                   class="flex items-center gap-2 rounded-2xl bg-white/10 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-white/20">

                    <svg class="h-4 w-4"
                         fill="none"
                         stroke="currentColor"
                         stroke-width="2"
                         viewBox="0 0 24 24">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M15 19l-7-7 7-7"/>
                    </svg>

                    Dashboard
                </a>

            </div>
        </div>
    </header>


    <!-- Page Header -->
    <section class="px-4 pb-6 pt-8 sm:px-6 lg:px-10">

        <div class="mx-auto max-w-7xl">

            <div class="max-w-3xl">

                <div class="mb-4 inline-flex items-center gap-2 rounded-full bg-emerald-400/15 px-3 py-1.5 text-xs font-bold text-emerald-100 ring-1 ring-emerald-300/20">
                    <span class="h-2 w-2 rounded-full bg-emerald-300"></span>
                    Waste Collection
                </div>

                <h1 class="text-3xl font-extrabold tracking-tight text-white sm:text-4xl lg:text-5xl">
                    Request Waste Pickup
                </h1>

                <p class="mt-3 max-w-2xl text-sm leading-6 text-emerald-50/85 sm:text-base">
                    Tell us what you need collected, where to collect it,
                    and when you would like our waste collector to arrive.
                </p>

            </div>

        </div>
    </section>


    <!-- Main Content -->
    <main class="px-4 pb-12 sm:px-6 lg:px-10">

        <div class="mx-auto grid max-w-7xl gap-6 lg:grid-cols-[1fr_360px]">

            <!-- FORM -->
            <div class="glass rounded-[2rem] p-5 sm:p-7 lg:p-8">

                <form method="POST"
                      action="{{ route('resident.pickups.store') }}"
                      enctype="multipart/form-data"
                      id="pickupForm">

                    @csrf


                    <!-- Validation Errors -->
                    @if ($errors->any())
                        <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 p-4">

                            <div class="flex gap-3">

                                <svg class="mt-0.5 h-5 w-5 shrink-0 text-red-500"
                                     fill="none"
                                     stroke="currentColor"
                                     stroke-width="2"
                                     viewBox="0 0 24 24">
                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          d="M12 8v4m0 4h.01M10.29 3.86l-7.5 13A2 2 0 004.52 20h14.96a2 2 0 001.73-3.14l-7.5-13a2 2 0 00-3.42 0z"/>
                                </svg>

                                <div>
                                    <p class="font-bold text-red-700">
                                        Please check the following:
                                    </p>

                                    <ul class="mt-2 list-disc space-y-1 pl-5 text-sm text-red-600">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>

                            </div>
                        </div>
                    @endif


                    <!-- SECTION 1 -->
                    <div class="mb-8">

                        <div class="mb-5 flex items-start gap-4">

                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-2xl bg-emerald-100 text-emerald-700 font-extrabold">
                                01
                            </div>

                            <div>
                                <h2 class="text-lg font-extrabold text-slate-900">
                                    What are we collecting?
                                </h2>

                                <p class="mt-1 text-sm text-slate-500">
                                    Select the main type of waste you want collected.
                                </p>
                            </div>

                        </div>


                        <!-- Waste Categories -->
                        <div class="grid grid-cols-2 gap-3 sm:grid-cols-3">

                            @foreach ($wasteCategories as $category)

                                @php
                                    $icons = [
                                        'plastic' => '♻',
                                        'paper' => '▤',
                                        'metal' => '◈',
                                        'glass' => '◇',
                                        'organic-waste' => '♧',
                                        'general-waste' => '●',
                                    ];

                                    $icon = $icons[$category->slug] ?? '●';
                                @endphp

                                <label class="waste-option cursor-pointer">

                                    <input
                                        type="radio"
                                        name="waste_category_id"
                                        value="{{ $category->id }}"
                                        class="peer sr-only"
                                        required
                                        data-category="{{ $category->slug }}"
                                    >

                                    <div class="h-full rounded-2xl border-2 border-slate-100 bg-white p-4 peer-checked:border-emerald-500 peer-checked:bg-emerald-50">

                                        <div class="mb-3 flex h-11 w-11 items-center justify-center rounded-xl bg-emerald-100 text-xl text-emerald-700">
                                            {{ $icon }}
                                        </div>

                                        <p class="text-sm font-extrabold text-slate-900">
                                            {{ $category->name }}
                                        </p>

                                        @if ($category->description)
                                            <p class="mt-1 line-clamp-2 text-[11px] leading-4 text-slate-500">
                                                {{ $category->description }}
                                            </p>
                                        @endif

                                        @if ($category->is_recyclable)
                                            <span class="mt-3 inline-flex rounded-full bg-blue-50 px-2 py-1 text-[10px] font-bold text-blue-700">
                                                Recyclable
                                            </span>
                                        @elseif ($category->is_compostable)
                                            <span class="mt-3 inline-flex rounded-full bg-amber-50 px-2 py-1 text-[10px] font-bold text-amber-700">
                                                Compostable
                                            </span>
                                        @endif

                                    </div>

                                </label>

                            @endforeach

                        </div>

                    </div>


                    <!-- SECTION 2 -->
                    <div class="mb-8 border-t border-slate-100 pt-8">

                        <div class="mb-5 flex items-start gap-4">

                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-2xl bg-emerald-100 text-emerald-700 font-extrabold">
                                02
                            </div>

                            <div>
                                <h2 class="text-lg font-extrabold text-slate-900">
                                    How much waste?
                                </h2>

                                <p class="mt-1 text-sm text-slate-500">
                                    Enter your estimated waste quantity.
                                </p>
                            </div>

                        </div>


                        <div class="max-w-md">

                            <label for="quantity"
                                   class="mb-2 block text-sm font-bold text-slate-700">
                                Estimated quantity
                            </label>

                            <div class="relative">

                                <input
                                    type="number"
                                    name="quantity"
                                    id="quantity"
                                    value="{{ old('quantity', 5) }}"
                                    min="0.5"
                                    max="1000"
                                    step="0.5"
                                    required
                                    class="input-field w-full rounded-2xl border border-slate-200 bg-white px-5 py-4 pr-16 text-lg font-bold text-slate-900"
                                    placeholder="Enter quantity"
                                >

                                <span class="absolute right-5 top-1/2 -translate-y-1/2 text-sm font-bold text-slate-400">
                                    kg
                                </span>

                            </div>

                            <p class="mt-2 text-xs text-slate-400">
                                Minimum 0.5 kg. Maximum 1,000 kg.
                            </p>

                        </div>

                    </div>


                    <!-- SECTION 3 -->
                    <div class="mb-8 border-t border-slate-100 pt-8">

                        <div class="mb-5 flex items-start gap-4">

                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-2xl bg-emerald-100 text-emerald-700 font-extrabold">
                                03
                            </div>

                            <div>
                                <h2 class="text-lg font-extrabold text-slate-900">
                                    Add a waste photo
                                </h2>

                                <p class="mt-1 text-sm text-slate-500">
                                    A photo helps the collector understand the waste before arrival.
                                </p>
                            </div>

                        </div>


                        <label for="photo"
                               class="upload-zone block cursor-pointer rounded-3xl border-2 border-dashed border-slate-200 bg-slate-50 p-6 text-center">

                            <input
                                type="file"
                                name="photo"
                                id="photo"
                                accept="image/jpeg,image/png,image/webp"
                                class="sr-only"
                            >

                            <div id="uploadContent">

                                <div class="mx-auto mb-3 flex h-14 w-14 items-center justify-center rounded-2xl bg-emerald-100 text-emerald-700">

                                    <svg class="h-7 w-7"
                                         fill="none"
                                         stroke="currentColor"
                                         stroke-width="1.8"
                                         viewBox="0 0 24 24">
                                        <path stroke-linecap="round"
                                              stroke-linejoin="round"
                                              d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-8h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>

                                </div>

                                <p class="text-sm font-extrabold text-slate-800">
                                    Upload waste photo
                                </p>

                                <p class="mt-1 text-xs text-slate-400">
                                    JPG, PNG or WEBP · Maximum 5MB
                                </p>

                            </div>


                            <div id="photoPreview" class="hidden">

                                <img
                                    id="previewImage"
                                    class="mx-auto max-h-56 rounded-2xl preview-image"
                                    alt="Waste preview"
                                >

                                <p class="mt-3 text-xs font-bold text-emerald-700">
                                    Photo selected. Click to change.
                                </p>

                            </div>

                        </label>

                    </div>


<!-- SECTION 4 -->
<div class="mb-8 border-t border-slate-100 pt-8">

    <div class="mb-5 flex items-start gap-4">

        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-2xl bg-emerald-100 text-emerald-700 font-extrabold">
            04
        </div>

        <div>
            <h2 class="text-lg font-extrabold text-slate-900">
                Where should we collect?
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                Select your area and provide the exact location for our collector.
            </p>
        </div>

    </div>


    {{-- ADDRESS MODE --}}
    <div class="grid gap-3 sm:grid-cols-2 mb-5">

        {{-- Saved address --}}
        @if ($addresses->count())

            <label class="cursor-pointer">

                <input
                    type="radio"
                    name="address_mode"
                    value="saved"
                    class="peer sr-only"
                    {{ old('address_mode', 'saved') === 'saved' ? 'checked' : '' }}
                >

                <div class="rounded-2xl border-2 border-slate-200 bg-white p-4 transition
                            peer-checked:border-emerald-500
                            peer-checked:bg-emerald-50
                            hover:border-emerald-300">

                    <div class="flex items-center gap-3">

                        <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-emerald-100 text-emerald-700">

                            <svg class="h-5 w-5"
                                 fill="none"
                                 stroke="currentColor"
                                 stroke-width="1.8"
                                 viewBox="0 0 24 24">

                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="M3 10.5L12 3l9 7.5"/>

                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="M5.5 9.5V21h13V9.5"/>

                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="M9 21v-6h6v6"/>

                            </svg>

                        </div>

                        <div>

                            <p class="font-extrabold text-slate-900">
                                Saved Address
                            </p>

                            <p class="mt-0.5 text-xs text-slate-500">
                                Use a location saved previously.
                            </p>

                        </div>

                    </div>

                </div>

            </label>

        @endif


        {{-- New location --}}
        <label class="cursor-pointer">

            <input
                type="radio"
                name="address_mode"
                value="new"
                class="peer sr-only"
                {{ old('address_mode', !$addresses->count() ? 'new' : 'saved') === 'new' ? 'checked' : '' }}
            >

            <div class="rounded-2xl border-2 border-slate-200 bg-white p-4 transition
                        peer-checked:border-emerald-500
                        peer-checked:bg-emerald-50
                        hover:border-emerald-300">

                <div class="flex items-center gap-3">

                    <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-emerald-100 text-emerald-700">

                        <svg class="h-5 w-5"
                             fill="none"
                             stroke="currentColor"
                             stroke-width="1.8"
                             viewBox="0 0 24 24">

                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  d="M12 5v14M5 12h14"/>

                        </svg>

                    </div>

                    <div>

                        <p class="font-extrabold text-slate-900">
                            New Pickup Location
                        </p>

                        <p class="mt-0.5 text-xs text-slate-500">
                            Add your exact collection location.
                        </p>

                    </div>

                </div>

            </div>

        </label>

    </div>


    {{-- SAVED ADDRESSES --}}
    <div id="saved-address-section"
         class="{{ old('address_mode', $addresses->count() ? 'saved' : 'new') === 'saved' ? '' : 'hidden' }}">

        @if ($addresses->count())

            <div class="space-y-3">

                @foreach ($addresses as $address)

                    <label class="block cursor-pointer">

                        <input
                            type="radio"
                            name="address_id"
                            value="{{ $address->id }}"
                            class="peer sr-only"
                            {{ old('address_id', $addresses->firstWhere('is_default', true)?->id) == $address->id ? 'checked' : '' }}
                        >

                        <div class="rounded-2xl border-2 border-slate-100 bg-white p-4 transition
                                    peer-checked:border-emerald-500
                                    peer-checked:bg-emerald-50
                                    hover:border-emerald-200">

                            <div class="flex items-start gap-4">

                                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-emerald-100 text-emerald-700">

                                    <svg class="h-5 w-5"
                                         fill="none"
                                         stroke="currentColor"
                                         stroke-width="1.8"
                                         viewBox="0 0 24 24">

                                        <path stroke-linecap="round"
                                              stroke-linejoin="round"
                                              d="M12 21s8-4.5 8-10a8 8 0 10-16 0c0 5.5 8 10 8 10z"/>

                                        <circle cx="12"
                                                cy="11"
                                                r="2.5"/>

                                    </svg>

                                </div>

                                <div class="min-w-0 flex-1">

                                    <div class="flex flex-wrap items-center gap-2">

                                        <p class="font-extrabold text-slate-900">
                                            {{ $address->label }}
                                        </p>

                                        @if ($address->is_default)

                                            <span class="rounded-full bg-emerald-100 px-2 py-1 text-[10px] font-bold text-emerald-700">
                                                Default
                                            </span>

                                        @endif

                                    </div>

                                    <p class="mt-1 text-sm text-slate-600">
                                        {{ $address->address_line }}
                                    </p>

                                    @if ($address->landmark)

                                        <p class="mt-1 text-xs text-slate-500">
                                            <span class="font-bold">Landmark:</span>
                                            {{ $address->landmark }}
                                        </p>

                                    @endif

                                    @if ($address->directions)

                                        <p class="mt-1 text-xs text-slate-500">
                                            <span class="font-bold">Directions:</span>
                                            {{ $address->directions }}
                                        </p>

                                    @endif

                                    <p class="mt-1 text-xs text-slate-400">
                                        {{ $address->area ? $address->area . ', ' : '' }}{{ $address->city }}
                                    </p>

                                </div>

                            </div>

                        </div>

                    </label>

                @endforeach

            </div>

        @else

            <div class="rounded-2xl border border-amber-200 bg-amber-50 p-5">

                <p class="font-bold text-amber-800">
                    No saved pickup locations yet.
                </p>

                <p class="mt-1 text-sm text-amber-700">
                    Select "New Pickup Location" below to add one.
                </p>

            </div>

        @endif

    </div>


    {{-- NEW PICKUP LOCATION --}}
    <div id="new-address-section"
         class="{{ old('address_mode', $addresses->count() ? 'saved' : 'new') === 'new' ? '' : 'hidden' }} mt-5 rounded-3xl border border-emerald-100 bg-emerald-50/60 p-5">

        <div class="mb-5">

            <h3 class="font-extrabold text-slate-900">
                Add New Pickup Location
            </h3>

            <p class="mt-1 text-sm text-slate-500">
                Help the collector find you easily.
            </p>

        </div>


        <div class="grid gap-5 sm:grid-cols-2">


            {{-- Location name --}}
            <div>

                <label for="new_label"
                       class="mb-2 block text-sm font-bold text-slate-700">

                    Location Name
                    <span class="text-rose-500">*</span>

                </label>

                <input
                    type="text"
                    name="new_label"
                    id="new_label"
                    value="{{ old('new_label', 'Home') }}"
                    placeholder="e.g. Home, Office, Shop"
                    class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3.5 text-sm text-slate-900 outline-none transition focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10"
                >

            </div>


            {{-- Area --}}
            <div>

                <label for="new_area"
                       class="mb-2 block text-sm font-bold text-slate-700">

                    Area / Neighborhood
                    <span class="text-rose-500">*</span>

                </label>

                <select
                    name="new_area"
                    id="new_area"
                    class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3.5 text-sm text-slate-900 outline-none transition focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10"
                >

                    <option value="">
                        Select your area
                    </option>

                    @foreach (config('juba_areas', []) as $group => $areas)

                        <optgroup label="{{ $group }}">

                            @foreach ($areas as $area)

                                <option
                                    value="{{ $area }}"
                                    {{ old('new_area') === $area ? 'selected' : '' }}
                                >
                                    {{ $area }}
                                </option>

                            @endforeach

                        </optgroup>

                    @endforeach

                </select>

                <p class="mt-2 text-xs text-slate-400">
                    Select your neighborhood or residential area.
                </p>

            </div>


            {{-- Exact location --}}
            <div class="sm:col-span-2">

                <label for="new_address_line"
                       class="mb-2 block text-sm font-bold text-slate-700">

                    Exact Pickup Location
                    <span class="text-rose-500">*</span>

                </label>

                <textarea
                    name="new_address_line"
                    id="new_address_line"
                    rows="3"
                    placeholder="Example: House 24, Block B, along the main road..."
                    class="w-full resize-none rounded-2xl border border-slate-200 bg-white px-4 py-3.5 text-sm text-slate-900 outline-none transition focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10"
                >{{ old('new_address_line') }}</textarea>

                <p class="mt-2 text-xs text-slate-400">
                    Enter the house, compound, shop, office, block, road number, or exact location.
                </p>

            </div>


            {{-- Landmark --}}
            <div>

                <label for="new_landmark"
                       class="mb-2 block text-sm font-bold text-slate-700">

                    Nearby Building / Landmark

                </label>

                <input
                    type="text"
                    name="new_landmark"
                    id="new_landmark"
                    value="{{ old('new_landmark') }}"
                    placeholder="e.g. Near Juba Teaching Hospital"
                    class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3.5 text-sm text-slate-900 outline-none transition focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10"
                >

                <p class="mt-2 text-xs text-slate-400">
                    Building, school, market, hospital, church, hotel, etc.
                </p>

            </div>


            {{-- City --}}
            <div>

                <label for="new_city"
                       class="mb-2 block text-sm font-bold text-slate-700">

                    City

                </label>

                <input
                    type="text"
                    name="new_city"
                    id="new_city"
                    value="{{ old('new_city', 'Juba') }}"
                    class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3.5 text-sm text-slate-900 outline-none transition focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10"
                >

            </div>


            {{-- Directions --}}
            <div class="sm:col-span-2">

                <label for="new_directions"
                       class="mb-2 block text-sm font-bold text-slate-700">

                    Road / Additional Directions

                </label>

                <textarea
                    name="new_directions"
                    id="new_directions"
                    rows="3"
                    placeholder="Example: Along Road 3, next to the blue shop, opposite the school..."
                    class="w-full resize-none rounded-2xl border border-slate-200 bg-white px-4 py-3.5 text-sm text-slate-900 outline-none transition focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10"
                >{{ old('new_directions') }}</textarea>

                <p class="mt-2 text-xs text-slate-400">
                    Give the collector clear directions to the pickup point.
                </p>

            </div>

            {{-- Map picker for the exact pickup point --}}
<div class="sm:col-span-2 mt-2">
    <label class="mb-2 block text-sm font-bold text-slate-700">
        Pin Your Exact Pickup Point
        <span class="text-rose-500">*</span>
    </label>

    <p class="mb-3 text-sm leading-6 text-slate-600">
        Click the map at the place where the collector should pick up your waste.
        You can zoom in and move the map to find the correct location.
    </p>

    <div
        id="pickupLocationMap"
        class="border border-slate-200 bg-slate-100"
        role="application"
        aria-label="Map for selecting the waste pickup location"
    ></div>

    <p
        id="pickupMapStatus"
        class="mt-3 text-sm font-semibold text-amber-700"
        aria-live="polite"
    >
        No pickup point selected yet. Click the map to place a pin.
    </p>

    <div class="mt-3 grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div>
            <label for="new_latitude" class="mb-1 block text-xs font-semibold text-slate-500">
                Latitude
            </label>
            <input
                type="text"
                name="new_latitude"
                id="new_latitude"
                value="{{ old('new_latitude') }}"
                readonly
                class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm"
            >
        </div>

        <div>
            <label for="new_longitude" class="mb-1 block text-xs font-semibold text-slate-500">
                Longitude
            </label>
            <input
                type="text"
                name="new_longitude"
                id="new_longitude"
                value="{{ old('new_longitude') }}"
                readonly
                class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm"
            >
        </div>
    </div>

    @error('new_latitude')
        <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
    @enderror

    @error('new_longitude')
        <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
    @enderror
    </div>
        </div>


        <div class="mt-5 flex items-start gap-3 rounded-2xl border border-emerald-100 bg-white/70 p-4">

            <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-emerald-100 text-emerald-700">

                <svg class="h-5 w-5"
                     fill="none"
                     stroke="currentColor"
                     stroke-width="1.8"
                     viewBox="0 0 24 24">

                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M5 12l4 4L19 6"/>

                </svg>

            </div>

            <div>

                <p class="text-sm font-bold text-slate-800">
                    This location will be saved to your profile
                </p>

                <p class="mt-1 text-xs leading-5 text-slate-500">
                    You can reuse this pickup location for future waste collection requests.
                </p>

            </div>

        </div>

    </div>


    {{-- Validation errors --}}
    @foreach ([
        'address_mode',
        'address_id',
        'new_label',
        'new_area',
        'new_address_line',
        'new_landmark',
        'new_directions'
    ] as $field)

        @error($field)

            <p class="mt-3 text-sm font-semibold text-rose-600">
                {{ $message }}
            </p>

        @enderror

    @endforeach

</div>


                    <!-- SECTION 5 -->
                    <div class="mb-8 border-t border-slate-100 pt-8">

                        <div class="mb-5 flex items-start gap-4">

                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-2xl bg-emerald-100 text-emerald-700 font-extrabold">
                                05
                            </div>

                            <div>
                                <h2 class="text-lg font-extrabold text-slate-900">
                                    When should we collect?
                                </h2>

                                <p class="mt-1 text-sm text-slate-500">
                                    Select your preferred collection date and time.
                                </p>
                            </div>

                        </div>


                        <div class="grid gap-4 sm:grid-cols-2">

                            <div>

                                <label for="pickup_date"
                                       class="mb-2 block text-sm font-bold text-slate-700">
                                    Pickup date
                                </label>

                                <input
                                    type="date"
                                    name="pickup_date"
                                    id="pickup_date"
                                    min="{{ now()->format('Y-m-d') }}"
                                    value="{{ old('pickup_date', now()->addDay()->format('Y-m-d')) }}"
                                    required
                                    class="input-field w-full rounded-2xl border border-slate-200 bg-white px-4 py-4 font-semibold text-slate-800"
                                >

                            </div>


                            <div>

                                <label for="pickup_time"
                                       class="mb-2 block text-sm font-bold text-slate-700">
                                    Pickup time
                                </label>

                                <select
                                    name="pickup_time"
                                    id="pickup_time"
                                    required
                                    class="input-field w-full rounded-2xl border border-slate-200 bg-white px-4 py-4 font-semibold text-slate-800"
                                >

                                    <option value="">Select time</option>

                                    <option value="08:00">08:00 AM</option>
                                    <option value="09:00">09:00 AM</option>
                                    <option value="10:00">10:00 AM</option>
                                    <option value="11:00">11:00 AM</option>
                                    <option value="12:00">12:00 PM</option>
                                    <option value="13:00">01:00 PM</option>
                                    <option value="14:00">02:00 PM</option>
                                    <option value="15:00">03:00 PM</option>
                                    <option value="16:00">04:00 PM</option>
                                    <option value="17:00">05:00 PM</option>

                                </select>

                            </div>

                        </div>

                    </div>


                    <!-- SECTION 6 -->
                    <div class="mb-8 border-t border-slate-100 pt-8">

                        <div class="mb-5 flex items-start gap-4">

                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-2xl bg-emerald-100 text-emerald-700 font-extrabold">
                                06
                            </div>

                            <div>
                                <h2 class="text-lg font-extrabold text-slate-900">
                                    Collection type
                                </h2>

                                <p class="mt-1 text-sm text-slate-500">
                                    Choose whether this is a one-time or recurring collection.
                                </p>
                            </div>

                        </div>


                        <div class="grid gap-3 sm:grid-cols-2">

                            <label class="cursor-pointer">

                                <input
                                    type="radio"
                                    name="request_type"
                                    value="one_time"
                                    class="peer sr-only"
                                    checked
                                >

                                <div class="rounded-2xl border-2 border-slate-100 bg-white p-5 peer-checked:border-emerald-500 peer-checked:bg-emerald-50">

                                    <div class="flex items-start gap-4">

                                        <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-emerald-100 text-emerald-700">

                                            <svg class="h-5 w-5"
                                                 fill="none"
                                                 stroke="currentColor"
                                                 stroke-width="1.8"
                                                 viewBox="0 0 24 24">
                                                <path stroke-linecap="round"
                                                      stroke-linejoin="round"
                                                      d="M8 7V3m8 4V3M4 11h16M5 21h14a1 1 0 001-1V7a1 1 0 00-1-1H5a1 1 0 00-1 1v13a1 1 0 001 1z"/>
                                            </svg>

                                        </div>

                                        <div>
                                            <p class="font-extrabold text-slate-900">
                                                One-time pickup
                                            </p>

                                            <p class="mt-1 text-xs leading-5 text-slate-500">
                                                Request collection for this occasion only.
                                            </p>
                                        </div>

                                    </div>

                                </div>

                            </label>


                            <label class="cursor-pointer">

                                <input
                                    type="radio"
                                    name="request_type"
                                    value="recurring"
                                    class="peer sr-only"
                                >

                                <div class="rounded-2xl border-2 border-slate-100 bg-white p-5 peer-checked:border-emerald-500 peer-checked:bg-emerald-50">

                                    <div class="flex items-start gap-4">

                                        <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-emerald-100 text-emerald-700">

                                            <svg class="h-5 w-5"
                                                 fill="none"
                                                 stroke="currentColor"
                                                 stroke-width="1.8"
                                                 viewBox="0 0 24 24">
                                                <path stroke-linecap="round"
                                                      stroke-linejoin="round"
                                                      d="M4 4v5h5M20 20v-5h-5M5.5 15a7 7 0 0011.8 2M18.5 9A7 7 0 006.7 7"/>
                                            </svg>

                                        </div>

                                        <div>
                                            <p class="font-extrabold text-slate-900">
                                                Recurring pickup
                                            </p>

                                            <p class="mt-1 text-xs leading-5 text-slate-500">
                                                Set up regular waste collection.
                                            </p>

                                        </div>

                                    </div>

                                </div>

                            </label>

                        </div>


                        <!-- Recurrence -->
                        <div id="recurrenceBox" class="mt-4 hidden">

                            <label for="recurrence_frequency"
                                   class="mb-2 block text-sm font-bold text-slate-700">
                                Collection frequency
                            </label>

                            <select
                                name="recurrence_frequency"
                                id="recurrence_frequency"
                                class="input-field w-full rounded-2xl border border-slate-200 bg-white px-4 py-4 font-semibold text-slate-800"
                            >
                                <option value="">Select frequency</option>
                                <option value="weekly">Every week</option>
                                <option value="biweekly">Every 2 weeks</option>
                                <option value="monthly">Every month</option>
                            </select>

                        </div>

                    </div>


                    <!-- NOTES -->
                    <div class="mb-8 border-t border-slate-100 pt-8">

                        <label for="notes"
                               class="mb-2 block text-sm font-bold text-slate-700">
                            Additional instructions
                            <span class="font-normal text-slate-400">
                                (optional)
                            </span>
                        </label>

                        <textarea
                            name="notes"
                            id="notes"
                            rows="4"
                            maxlength="1000"
                            class="input-field w-full resize-none rounded-2xl border border-slate-200 bg-white px-4 py-4 text-sm text-slate-800"
                            placeholder="For example: The waste is beside the gate..."
                        >{{ old('notes') }}</textarea>

                    </div>


                    <!-- Mobile Submit -->
                    <div class="lg:hidden">

                        <button
                            type="submit"
                            class="flex w-full items-center justify-center gap-2 rounded-2xl bg-emerald-600 px-6 py-4 text-sm font-extrabold text-white shadow-lg shadow-emerald-900/20 transition hover:bg-emerald-700 active:scale-[0.99]"
                        >
                            Continue to Review

                            <svg class="h-5 w-5"
                                 fill="none"
                                 stroke="currentColor"
                                 stroke-width="2"
                                 viewBox="0 0 24 24">
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="M5 12h14M13 6l6 6-6 6"/>
                            </svg>
                        </button>

                    </div>

                </form>

            </div>


            <!-- SUMMARY -->
            <aside class="sticky-summary">

                <div class="glass rounded-[2rem] p-5 sm:p-6">

                    <div class="mb-6">

                        <div class="flex items-center justify-between">

                            <div>
                                <p class="text-xs font-bold uppercase tracking-widest text-emerald-600">
                                    Estimated cost
                                </p>

                                <h2 class="mt-1 text-xl font-extrabold text-slate-900">
                                    Pickup Summary
                                </h2>
                            </div>

                            <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-emerald-100 text-emerald-700">

                                <svg class="h-5 w-5"
                                     fill="none"
                                     stroke="currentColor"
                                     stroke-width="1.8"
                                     viewBox="0 0 24 24">
                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-2 2a1 1 0 00.7 1.7h11.6M9 19a1 1 0 11-2 0m10 0a1 1 0 11-2 0"/>
                                </svg>

                            </div>

                        </div>

                    </div>


                    <div class="space-y-4">

                        <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                            <span class="text-sm text-slate-500">
                                Waste type
                            </span>

                            <span id="summaryCategory"
                                  class="max-w-[170px] text-right text-sm font-bold text-slate-800">
                                Not selected
                            </span>
                        </div>


                        <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                            <span class="text-sm text-slate-500">
                                Quantity
                            </span>

                            <span class="text-sm font-bold text-slate-800">
                                <span id="summaryQuantity">5</span> kg
                            </span>
                        </div>


                        <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                            <span class="text-sm text-slate-500">
                                Collection
                            </span>

                            <span id="summaryType"
                                  class="text-sm font-bold text-slate-800">
                                One-time
                            </span>
                        </div>


                        <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                            <span class="text-sm text-slate-500">
                                Pickup date
                            </span>

                            <span id="summaryDate"
                                  class="text-right text-sm font-bold text-slate-800">
                                Not selected
                            </span>
                        </div>


                        <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                            <span class="text-sm text-slate-500">
                                Pickup time
                            </span>

                            <span id="summaryTime"
                                  class="text-sm font-bold text-slate-800">
                                Not selected
                            </span>
                        </div>

                    </div>


                    <div class="mt-6 rounded-2xl bg-emerald-950 p-5 text-white">

                        <div class="flex items-center justify-between">

                            <span class="text-sm text-emerald-200">
                                Estimated fee
                            </span>

                            <span class="text-2xl font-extrabold">
                                SSP
                                <span id="summaryFee">2,000</span>
                            </span>

                        </div>

                        <p class="mt-2 text-[11px] leading-5 text-emerald-200/70">
                            Final amount will be confirmed before payment.
                        </p>

                    </div>


                    <div class="mt-5 hidden lg:block">

                        <button
                            type="submit"
                            form="pickupForm"
                            class="flex w-full items-center justify-center gap-2 rounded-2xl bg-emerald-600 px-6 py-4 text-sm font-extrabold text-white shadow-lg shadow-emerald-900/20 transition hover:bg-emerald-700 active:scale-[0.99]"
                        >
                            Continue to Review

                            <svg class="h-5 w-5"
                                 fill="none"
                                 stroke="currentColor"
                                 stroke-width="2"
                                 viewBox="0 0 24 24">
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="M5 12h14M13 6l6 6-6 6"/>
                            </svg>
                        </button>

                    </div>


                    <div class="mt-5 flex items-start gap-3 rounded-2xl bg-slate-50 p-4">

                        <svg class="mt-0.5 h-5 w-5 shrink-0 text-emerald-600"
                             fill="none"
                             stroke="currentColor"
                             stroke-width="1.8"
                             viewBox="0 0 24 24">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  d="M12 3l8 4v5c0 4.8-3.4 8.8-8 10-4.6-1.2-8-5.2-8-10V7l8-4z"/>
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  d="M9 12l2 2 4-4"/>
                        </svg>

                        <p class="text-[11px] leading-5 text-slate-500">
                            Your request is securely linked to your SmartWaste Juba Connect account.
                        </p>

                    </div>

                </div>

            </aside>

        </div>

    </main>

</div>


<script>

    /*
     * Waste category summary
     */
    const categoryInputs = document.querySelectorAll(
        'input[name="waste_category_id"]'
    );

    const categorySummary = document.getElementById(
        'summaryCategory'
    );

    categoryInputs.forEach(input => {

        input.addEventListener('change', function () {

            const label = this.closest('label');

            const name = label
                .querySelector('p.font-extrabold')
                ?.textContent
                .trim();

            categorySummary.textContent = name || 'Selected';

            calculateFee();

        });

    });


    /*
     * Quantity
     */
    const quantityInput = document.getElementById('quantity');
    const quantitySummary = document.getElementById('summaryQuantity');

    quantityInput.addEventListener('input', function () {

        quantitySummary.textContent =
            this.value || '0';

        calculateFee();

    });


    /*
     * Pickup date
     */
    const dateInput = document.getElementById('pickup_date');
    const dateSummary = document.getElementById('summaryDate');

    dateInput.addEventListener('change', function () {

        if (!this.value) {
            dateSummary.textContent = 'Not selected';
            return;
        }

        const date = new Date(this.value + 'T00:00:00');

        dateSummary.textContent = date.toLocaleDateString(
            'en-US',
            {
                month: 'short',
                day: 'numeric',
                year: 'numeric'
            }
        );

    });


    /*
     * Pickup time
     */
    const timeInput = document.getElementById('pickup_time');
    const timeSummary = document.getElementById('summaryTime');

    timeInput.addEventListener('change', function () {

        if (!this.value) {
            timeSummary.textContent = 'Not selected';
            return;
        }

        const [hour, minute] = this.value.split(':');

        const date = new Date();

        date.setHours(
            Number(hour),
            Number(minute)
        );

        timeSummary.textContent =
            date.toLocaleTimeString(
                'en-US',
                {
                    hour: 'numeric',
                    minute: '2-digit'
                }
            );

    });


    /*
     * Collection type
     */
    const requestTypeInputs = document.querySelectorAll(
        'input[name="request_type"]'
    );

    const summaryType = document.getElementById(
        'summaryType'
    );

    const recurrenceBox = document.getElementById(
        'recurrenceBox'
    );

    const recurrenceSelect = document.getElementById(
        'recurrence_frequency'
    );

    requestTypeInputs.forEach(input => {

        input.addEventListener('change', function () {

            if (this.value === 'recurring') {

                recurrenceBox.classList.remove('hidden');

                recurrenceSelect.required = true;

                summaryType.textContent =
                    'Recurring';

            } else {

                recurrenceBox.classList.add('hidden');

                recurrenceSelect.required = false;

                recurrenceSelect.value = '';

                summaryType.textContent =
                    'One-time';
            }

        });

    });


    /*
     * Photo preview
     */
    const photoInput = document.getElementById('photo');
    const uploadContent = document.getElementById('uploadContent');
    const photoPreview = document.getElementById('photoPreview');
    const previewImage = document.getElementById('previewImage');

    photoInput.addEventListener('change', function () {

        const file = this.files[0];

        if (!file) {
            return;
        }

        if (file.size > 5 * 1024 * 1024) {

            alert('The selected photo is larger than 5MB.');

            this.value = '';

            return;
        }

        const reader = new FileReader();

        reader.onload = function (event) {

            previewImage.src =
                event.target.result;

            uploadContent.classList.add(
                'hidden'
            );

            photoPreview.classList.remove(
                'hidden'
            );

        };

        reader.readAsDataURL(file);

    });


    /*
     * Fee calculation
     *
     * These are prototype rates.
     * The backend remains the final authority.
     */
    function calculateFee() {

        const selectedCategory =
            document.querySelector(
                'input[name="waste_category_id"]:checked'
            );

        const quantity =
            parseFloat(quantityInput.value) || 0;

        let rate = 200;

        if (selectedCategory) {

            switch (selectedCategory.dataset.category) {

                case 'plastic':
                    rate = 250;
                    break;

                case 'paper':
                    rate = 220;
                    break;

                case 'metal':
                    rate = 300;
                    break;

                case 'glass':
                    rate = 250;
                    break;

                case 'organic-waste':
                    rate = 180;
                    break;

                default:
                    rate = 200;
            }

        }

        const baseFee = 1000;

        const total =
            baseFee + (quantity * rate);

        document.getElementById(
            'summaryFee'
        ).textContent =
            Math.round(total).toLocaleString();

    }

    /*
 * Pickup location map
 */
const pickupMapElement = document.getElementById('pickupLocationMap');

if (pickupMapElement && typeof L !== 'undefined') {
    const latitudeInput = document.getElementById('new_latitude');
    const longitudeInput = document.getElementById('new_longitude');
    const mapStatus = document.getElementById('pickupMapStatus');
    const pickupForm = document.getElementById('pickupForm');

    // Initial map view only; this is not the resident's selected address.
    const jubaCenter = [4.8594, 31.5713];

    const pickupMap = L.map('pickupLocationMap').setView(jubaCenter, 12);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(pickupMap);

    let pickupMarker = null;

    function selectPickupPoint(latitude, longitude) {
        latitudeInput.value = Number(latitude).toFixed(7);
        longitudeInput.value = Number(longitude).toFixed(7);

        if (pickupMarker) {
            pickupMarker.setLatLng([latitude, longitude]);
        } else {
            pickupMarker = L.marker([latitude, longitude]).addTo(pickupMap);
        }

        pickupMarker.bindPopup('Selected waste pickup point').openPopup();

        mapStatus.textContent =
            'Pickup point selected. Check that the pin is at the correct location.';
        mapStatus.classList.remove('text-amber-700');
        mapStatus.classList.add('text-emerald-700');
    }

    // Restore a previously selected point after a validation error.
    const oldLatitude = parseFloat(latitudeInput.value);
    const oldLongitude = parseFloat(longitudeInput.value);

    if (
        latitudeInput.value.trim() !== '' &&
        longitudeInput.value.trim() !== '' &&
        Number.isFinite(oldLatitude) &&
        Number.isFinite(oldLongitude) &&
        oldLatitude >= -90 &&
        oldLatitude <= 90 &&
        oldLongitude >= -180 &&
        oldLongitude <= 180
    ) {
        pickupMap.setView([oldLatitude, oldLongitude], 16);
        selectPickupPoint(oldLatitude, oldLongitude);
    }

    pickupMap.on('click', function (event) {
        selectPickupPoint(event.latlng.lat, event.latlng.lng);
    });

    // Leaflet needs a size refresh when its section becomes visible.
    function refreshPickupMap() {
        window.setTimeout(function () {
            pickupMap.invalidateSize();
        }, 250);
    }

    document.querySelectorAll('input[name="address_mode"]').forEach(function (input) {
        input.addEventListener('change', refreshPickupMap);
    });

    // Prevent submitting a new address without selecting a map point.
    if (pickupForm) {
        pickupForm.addEventListener('submit', function (event) {
            const selectedAddressMode = document.querySelector(
                'input[name="address_mode"]:checked'
            );

            if (
                selectedAddressMode &&
                selectedAddressMode.value === 'new' &&
                (!latitudeInput.value.trim() || !longitudeInput.value.trim())
            ) {
                event.preventDefault();

                mapStatus.textContent =
                    'Please click the map to select your exact pickup point before submitting.';
                mapStatus.classList.remove('text-emerald-700');
                mapStatus.classList.add('text-amber-700');

                document.getElementById('new-address-section').scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });

                refreshPickupMap();
            }
        });
    }

    refreshPickupMap();
}

    /*
     * Initial calculation
     */
    calculateFee();

</script>

</body>
</html>