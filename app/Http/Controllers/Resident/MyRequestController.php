<?php

namespace App\Http\Controllers\Resident;

use App\Http\Controllers\Controller;
use App\Models\CollectorLocation;
use App\Models\PickupRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class MyRequestController extends Controller
{
    /**
     * Display the authenticated resident's pickup requests.
     */
    public function index()
    {
        $requests = PickupRequest::with([
            'address',
            'items.wasteCategory',
        ])
            ->where('resident_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('resident.requests.index', [
            'requests' => $requests,
        ]);
    }

    /**
     * Display a single pickup request.
     */
    public function show(PickupRequest $pickupRequest)
    {
        abort_unless(
            (int) $pickupRequest->resident_id === (int) Auth::id(),
            403
        );

        $pickupRequest->load([
            'address',
            'items.wasteCategory',
            'collector',
            'payment',
        ]);

        return view('resident.requests.show', [
            'pickupRequest' => $pickupRequest,
        ]);
    }

    /**
     * Return the latest GPS location of the collector
     * assigned to this resident's pickup request.
     */
    public function tracking(
        PickupRequest $pickupRequest
    ): JsonResponse {
        abort_unless(
            (int) $pickupRequest->resident_id === (int) Auth::id(),
            403
        );

        if (!$pickupRequest->collector_id) {
            return response()->json([
                'available' => false,
                'message' => 'A collector has not been assigned yet.',
            ]);
        }

        $location = CollectorLocation::where(
            'collector_id',
            $pickupRequest->collector_id
        )
            ->latest('recorded_at')
            ->first();

        if (!$location) {
            return response()->json([
                'available' => false,
                'message' => 'The collector has not shared a GPS location yet.',
            ]);
        }

        return response()->json([
            'available' => true,
            'collector' => $pickupRequest->collector?->name,
            'latitude' => (float) $location->latitude,
            'longitude' => (float) $location->longitude,
            'accuracy' => $location->accuracy !== null
                ? (float) $location->accuracy
                : null,
            'recorded_at' => $location->recorded_at?->toIso8601String(),
        ]);
    }
}
