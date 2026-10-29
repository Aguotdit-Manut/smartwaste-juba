<?php

namespace App\Http\Controllers\Collector;

use App\Http\Controllers\Controller;
use App\Models\CollectorLocation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LocationController extends Controller
{
    public function toggleAvailability(Request $request)
    {
        $collector = Auth::user();

        $validated = $request->validate([
            'online' => ['required', 'boolean'],
        ]);

        $isOnline = $validated['online'];

        $collector->update([
            'is_online' => $isOnline,
            'last_seen_at' => $isOnline ? now() : $collector->last_seen_at,
        ]);

        return response()->json([
            'success' => true,
            'is_online' => $collector->is_online,
            'last_seen_at' => $collector->last_seen_at?->toISOString(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'latitude' => ['required', 'numeric', 'between:-90,90'],
            'longitude' => ['required', 'numeric', 'between:-180,180'],
            'accuracy' => ['nullable', 'numeric', 'min:0'],
        ]);

        $collector = Auth::user();

        $location = CollectorLocation::create([
            'collector_id' => $collector->id,
            'latitude' => $validated['latitude'],
            'longitude' => $validated['longitude'],
            'accuracy' => $validated['accuracy'] ?? null,
            'recorded_at' => now(),
        ]);

        $collector->update([
            'is_online' => true,
            'last_seen_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Location updated successfully.',
            'location' => [
                'latitude' => $location->latitude,
                'longitude' => $location->longitude,
                'accuracy' => $location->accuracy,
                'recorded_at' => $location->recorded_at?->toISOString(),
            ],
        ]);
    }
}