<?php

namespace App\Http\Controllers\Collector;

use App\Http\Controllers\Controller;
use App\Models\PickupRequest;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $collectorId = Auth::id();

        $baseQuery = PickupRequest::where('collector_id', $collectorId);

        $totalJobs = (clone $baseQuery)->count();

        $pendingJobs = (clone $baseQuery)
            ->where('status', 'pending')
            ->count();

        $activeJobs = (clone $baseQuery)
            ->whereIn('status', [
                'accepted',
                'assigned',
                'confirmed',
                'in_progress',
                'on_the_way',
                'collected',
            ])
            ->count();

        $completedJobs = (clone $baseQuery)
            ->whereIn('status', [
                'completed',
                'complete',
            ])
            ->count();

        $todayJobs = (clone $baseQuery)
            ->whereDate('scheduled_at', today())
            ->count();

        $upcomingJobs = (clone $baseQuery)
            ->where('scheduled_at', '>=', now())
            ->whereNotIn('status', [
                'completed',
                'complete',
                'cancelled',
                'canceled',
                'rejected',
            ])
            ->with([
                'address',
                'items.wasteCategory',
                'resident',
            ])
            ->orderBy('scheduled_at')
            ->take(5)
            ->get();

        $recentCompletedJobs = (clone $baseQuery)
            ->whereIn('status', [
                'completed',
                'complete',
            ])
            ->with([
                'address',
                'items.wasteCategory',
            ])
            ->latest('updated_at')
            ->take(5)
            ->get();

        $totalEarnings = (clone $baseQuery)
            ->whereIn('status', [
                'completed',
                'complete',
            ])
            ->sum('total_amount');

        return view('collector.dashboard', [
            'collector' => Auth::user(),
            'totalJobs' => $totalJobs,
            'pendingJobs' => $pendingJobs,
            'activeJobs' => $activeJobs,
            'completedJobs' => $completedJobs,
            'todayJobs' => $todayJobs,
            'upcomingJobs' => $upcomingJobs,
            'recentCompletedJobs' => $recentCompletedJobs,
            'totalEarnings' => $totalEarnings,
        ]);
    }
}