<?php

namespace App\Http\Controllers\Collector;

use App\Http\Controllers\Controller;
use App\Models\PickupRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobController extends Controller
{
    public function index()
    {
        $collectorId = Auth::id();

        $jobs = PickupRequest::where('collector_id', $collectorId)
            ->with([
                'address',
                'items.wasteCategory',
                'resident',
            ])
            ->orderByRaw("
                CASE
                    WHEN status = 'pending' THEN 1
                    WHEN status IN ('assigned', 'accepted', 'on_the_way', 'in_progress') THEN 2
                    WHEN status IN ('collected') THEN 3
                    WHEN status IN ('completed', 'complete') THEN 4
                    ELSE 5
                END
            ")
            ->orderBy('scheduled_at')
            ->paginate(10);

        return view('collector.jobs.index', [
            'jobs' => $jobs,
        ]);
    }

    public function show(PickupRequest $pickupRequest)
    {
        $this->authorizeCollectorJob($pickupRequest);

        $pickupRequest->load([
            'address',
            'items.wasteCategory',
            'resident',
        ]);

        return view('collector.jobs.show', [
            'pickupRequest' => $pickupRequest,
        ]);
    }

    public function accept(PickupRequest $pickupRequest)
    {
        $this->authorizeCollectorJob($pickupRequest);

        if (!in_array($pickupRequest->status, ['pending', 'assigned'])) {
            return back()->with('error', 'This pickup cannot be accepted in its current status.');
        }

        $pickupRequest->update([
            'status' => 'accepted',
        ]);

        return back()->with('success', 'Pickup job accepted successfully.');
    }

    public function reject(PickupRequest $pickupRequest)
    {
        $this->authorizeCollectorJob($pickupRequest);

        if (!in_array($pickupRequest->status, ['pending', 'assigned'])) {
            return back()->with('error', 'This pickup cannot be rejected in its current status.');
        }

        $pickupRequest->update([
            'status' => 'rejected',
            'collector_id' => null,
        ]);

        return redirect()
            ->route('collector.jobs.index')
            ->with('success', 'Pickup job rejected.');
    }

    public function start(PickupRequest $pickupRequest)
    {
        $this->authorizeCollectorJob($pickupRequest);

        if ($pickupRequest->status !== 'accepted') {
            return back()->with('error', 'You must accept the pickup before starting it.');
        }

        $pickupRequest->update([
            'status' => 'on_the_way',
        ]);

        return back()->with('success', 'Job started. You are now on the way.');
    }

    public function collect(PickupRequest $pickupRequest)
    {
        $this->authorizeCollectorJob($pickupRequest);

        if ($pickupRequest->status !== 'on_the_way') {
            return back()->with('error', 'The job must be marked as on the way first.');
        }

        $pickupRequest->update([
            'status' => 'collected',
        ]);

        return back()->with('success', 'Waste marked as collected.');
    }

    public function complete(PickupRequest $pickupRequest)
    {
        $this->authorizeCollectorJob($pickupRequest);

        if ($pickupRequest->status !== 'collected') {
            return back()->with('error', 'The waste must be marked as collected first.');
        }

        $pickupRequest->update([
            'status' => 'completed',
        ]);

        return back()->with('success', 'Pickup job completed successfully.');
    }

    private function authorizeCollectorJob(PickupRequest $pickupRequest): void
    {
        abort_unless(
            $pickupRequest->collector_id === Auth::id(),
            403
        );
    }
}