<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    /**
     * Display subscriptions
     */
    public function index(Request $request): JsonResponse
    {
        $status = $request->query('status');

        $query = Subscription::query()
            ->with(['customer', 'service']);

        if ($status !== null) {

            if (
                !in_array(
                    $status,
                    ['active', 'inactive', 'trial', 'isolir', 'dismantle'],
                    true
                )
            ) {

                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => [
                        'status' => [
                            'The selected status is invalid.'
                        ],
                    ],
                ], 422);
            }

            $query->where('status', $status);
        }

        $subscriptions = $query->latest()->get();

        return response()->json([
            'success' => true,
            'message' => 'Subscriptions retrieved successfully',
            'data' => $subscriptions,
        ]);
    }

    /**
     * Store subscription
     */
    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'customer_id' => ['required', 'exists:customers,id'],
            'service_id' => ['required', 'exists:services,id'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date'],
            'status' => [
                'required',
                'in:active,inactive,trial,isolir,dismantle'
            ],
        ]);

        $subscription = Subscription::query()->create($data);

        return response()->json([
            'success' => true,
            'message' => 'Subscription created successfully',
            'data' => $subscription,
        ], 201);
    }

    /**
     * Show single subscription
     */
    public function show(int $subscription): JsonResponse
    {
        $subscription = Subscription::query()
            ->with(['customer', 'service'])
            ->find($subscription);

        if (!$subscription) {

            return response()->json([
                'success' => false,
                'message' => 'Subscription not found',
                'errors' => [],
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Subscription retrieved successfully',
            'data' => $subscription,
        ]);
    }

    /**
     * Change subscription status
     */
    public function changeStatus(
        Request $request,
        int $subscription
    ): JsonResponse {

        $subscription = Subscription::query()->find($subscription);

        if (!$subscription) {

            return response()->json([
                'success' => false,
                'message' => 'Subscription not found',
                'errors' => [],
            ], 404);
        }

        $data = $request->validate([
            'status' => [
                'required',
                'in:active,inactive,trial,isolir,dismantle'
            ],
        ]);

        $subscription->update([
            'status' => $data['status']
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Subscription status updated successfully',
            'data' => $subscription,
        ]);
    }
}