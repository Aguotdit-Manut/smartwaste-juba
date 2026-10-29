<?php

namespace App\Http\Controllers\Resident;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\PickupRequest;
use App\Models\WasteCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PickupRequestController extends Controller
{
    /**
     * Show the request waste pickup form.
     */
    public function create()
    {
        $user = Auth::user();

        $wasteCategories = WasteCategory::where('is_active', true)
            ->orderBy('name')
            ->get();

        $addresses = Address::where('user_id', $user->id)
            ->orderByDesc('is_default')
            ->orderBy('label')
            ->get();

        return view('resident.pickups.create', [
            'user' => $user,
            'wasteCategories' => $wasteCategories,
            'addresses' => $addresses,
        ]);
    }


    /**
     * Store a new pickup request.
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([

            /*
             * Waste details
             */
            'waste_category_id' => [
                'required',
                'exists:waste_categories,id',
            ],

            'quantity' => [
                'required',
                'numeric',
                'min:0.5',
                'max:1000',
            ],


            /*
             * Address selection
             */
            'address_mode' => [
                'required',
                'in:saved,new',
            ],

            'address_id' => [
                'nullable',
                'exists:addresses,id',
            ],


            /*
             * New address
             */
            'new_label' => [
                'required_if:address_mode,new',
                'nullable',
                'string',
                'max:100',
            ],

            'new_area' => [
                'required_if:address_mode,new',
                'nullable',
                'string',
                'max:150',
            ],

            'new_address_line' => [
                'required_if:address_mode,new',
                'nullable',
                'string',
                'max:500',
            ],

            'new_landmark' => [
                'nullable',
                'string',
                'max:200',
            ],

            'new_directions' => [
                'nullable',
                'string',
                'max:500',
            ],

            'new_city' => [
                'nullable',
                'string',
                'max:100',
            ],

            'new_latitude' => [
            'required_if:address_mode,new',
            'nullable',
            'numeric',
            'between:-90,90',
            ],

            'new_longitude' => [
            'required_if:address_mode,new',
            'nullable',
            'numeric',
            'between:-180,180',
            ],


            /*
             * Pickup schedule
             */
            'pickup_date' => [
                'required',
                'date',
                'after_or_equal:today',
            ],

            'pickup_time' => [
                'required',
                'date_format:H:i',
            ],

            'request_type' => [
                'required',
                'in:one_time,recurring',
            ],

            'recurrence_frequency' => [
                'nullable',
                'required_if:request_type,recurring',
                'in:weekly,biweekly,monthly',
            ],


            /*
             * Photo
             */
            'photo' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],


            /*
             * Notes
             */
            'notes' => [
                'nullable',
                'string',
                'max:1000',
            ],
        ]);


        /*
         * Resolve the pickup address.
         */
        if ($validated['address_mode'] === 'saved') {

            if (empty($validated['address_id'])) {

                return back()
                    ->withErrors([
                        'address_id' => 'Please select one of your saved pickup locations.',
                    ])
                    ->withInput();
            }

            /*
             * Security check:
             * The selected address must belong to this resident.
             */
            $address = Address::where('id', $validated['address_id'])
                ->where('user_id', $user->id)
                ->first();

            if (!$address) {

                return back()
                    ->withErrors([
                        'address_id' => 'The selected pickup address is not valid.',
                    ])
                    ->withInput();
            }

        } else {

            /*
             * Create a new pickup address.
             */
            $address = Address::create([
            'user_id' => $user->id,
            'label' => $validated['new_label'],
            'address_line' => $validated['new_address_line'],
            'area' => $validated['new_area'],
            'landmark' => $validated['new_landmark'] ?? null,
            'directions' => $validated['new_directions'] ?? null,
            'city' => $validated['new_city'] ?? 'Juba',
            'latitude' => $validated['new_latitude'],
            'longitude' => $validated['new_longitude'],
            'is_default' => false,
            ]);
        }


        /*
         * Get selected waste category.
         */
        $category = WasteCategory::where('id', $validated['waste_category_id'])
            ->where('is_active', true)
            ->firstOrFail();


        /*
         * Initial prototype fee calculation.
         *
         * These rates can later be moved into
         * an admin-managed pricing system.
         */
        $ratePerKg = match ($category->slug) {

            'plastic' => 250,

            'paper' => 220,

            'metal' => 300,

            'glass' => 250,

            'organic-waste' => 180,

            default => 200,
        };

        $baseFee = 1000;

        $totalAmount =
            $baseFee +
            ($validated['quantity'] * $ratePerKg);


        /*
         * Upload waste photo.
         */
        $photoPath = null;

        if ($request->hasFile('photo')) {

            $photoPath = $request
                ->file('photo')
                ->store('pickup-photos', 'public');
        }


        /*
         * Combine date and time.
         */
        $scheduledAt =
            $validated['pickup_date']
            . ' '
            . $validated['pickup_time'];


        /*
         * Create pickup request and pickup item
         * inside one database transaction.
         */
        $pickupRequest = DB::transaction(function () use (
            $user,
            $validated,
            $address,
            $scheduledAt,
            $totalAmount,
            $photoPath
        ) {

            $pickupRequest = PickupRequest::create([

                'resident_id' => $user->id,

                'address_id' => $address->id,

                'request_type' =>
                    $validated['request_type'],

                'recurrence_frequency' =>
                    $validated['recurrence_frequency'] ?? null,

                'scheduled_at' =>
                    $scheduledAt,

                'status' =>
                    'pending',

                'total_amount' =>
                    $totalAmount,

                'payment_status' =>
                    'pending',

                'photo_path' =>
                    $photoPath,

                'notes' =>
                    $validated['notes'] ?? null,
            ]);


            $pickupRequest->items()->create([

                'waste_category_id' =>
                    $validated['waste_category_id'],

                'quantity' =>
                    $validated['quantity'],

                'unit' =>
                    'kg',
            ]);


            return $pickupRequest;
        });


        /*
         * Go to review page.
         */
        return redirect()
            ->route(
                'resident.pickups.review',
                $pickupRequest
            )
            ->with(
                'success',
                'Your pickup request has been created.'
            );
    }


    /**
     * Show request review page.
     */
    public function review(PickupRequest $pickupRequest)
    {
        $this->authorizeResidentRequest($pickupRequest);

        $pickupRequest->load([
            'address',
            'items.wasteCategory',
        ]);

        return view('resident.pickups.review', [
            'pickupRequest' => $pickupRequest,
        ]);
    }


    /**
     * Make sure residents can only access
     * their own requests.
     */
    private function authorizeResidentRequest(
        PickupRequest $pickupRequest
    ): void {

        abort_unless(
            $pickupRequest->resident_id === Auth::id(),
            403
        );
    }
}