<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\PickupRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        return match ($user->role) {
            'resident' => redirect()->route('resident.dashboard'),
            'collector' => redirect()->route('collector.dashboard'),
            'hub' => redirect()->route('hub.dashboard'),
            'admin' => redirect()->route('admin.dashboard'),
            default => abort(403, 'Invalid account role.'),
        };
    }

    public function resident(): View
    {
        $user = Auth::user();

        $totalRequests = PickupRequest::where('resident_id', $user->id)->count();

        $activeRequests = PickupRequest::where('resident_id', $user->id)
            ->whereIn('status', [
                'pending',
                'assigned',
                'on_the_way',
                'arrived',
                'collecting',
            ])
            ->count();

        $completedRequests = PickupRequest::where('resident_id', $user->id)
            ->where('status', 'completed')
            ->count();

        $latestRequests = PickupRequest::with('address')
            ->where('resident_id', $user->id)
            ->latest()
            ->take(3)
            ->get();

        $defaultAddress = Address::where('user_id', $user->id)
            ->where('is_default', true)
            ->first();

        if (!$defaultAddress) {
            $defaultAddress = Address::where('user_id', $user->id)
                ->latest()
                ->first();
        }

        return view('resident.dashboard', [
            'user' => $user,
            'totalRequests' => $totalRequests,
            'activeRequests' => $activeRequests,
            'completedRequests' => $completedRequests,
            'latestRequests' => $latestRequests,
            'defaultAddress' => $defaultAddress,
            'ecoPoints' => 0,
        ]);
    }

    public function collector(): View
    {
        return view('dashboard', [
            'role' => 'collector',
            'roleTitle' => 'Collector Dashboard',
        ]);
    }

    public function hub(): View
    {
        return view('dashboard', [
            'role' => 'hub',
            'roleTitle' => 'Recycling Hub Dashboard',
        ]);
    }

    public function admin(): View
    {
        return view('dashboard', [
            'role' => 'admin',
            'roleTitle' => 'Administrator Dashboard',
        ]);
    }
}