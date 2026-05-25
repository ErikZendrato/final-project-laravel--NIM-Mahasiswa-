<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function index(): JsonResponse
    {
        $subscriptions = Subscription::with(['customer', 'service'])
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'data' => $subscriptions
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'service_id' => 'required|exists:services,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'status' => 'required|string|in:active,inactive,trial,isolir,dismantle'
        ]);

        $subscription = Subscription::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Subscription berhasil ditambahkan',
            'data' => $subscription
        ], 201);
    }

    public function show(int $id): JsonResponse
    {
        $subscription = Subscription::with(['customer', 'service'])->find($id);

        if (!$subscription) {
            return response()->json([
                'success' => false,
                'message' => 'Subscription tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $subscription
        ]);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $subscription = Subscription::find($id);

        if (!$subscription) {
            return response()->json([
                'success' => false,
                'message' => 'Subscription tidak ditemukan'
            ], 404);
        }

        $data = $request->validate([
            'customer_id' => 'sometimes|exists:customers,id',
            'service_id' => 'sometimes|exists:services,id',
            'start_date' => 'sometimes|date',
            'end_date' => 'sometimes|date|after_or_equal:start_date',
            'status' => 'sometimes|string|in:active,inactive,trial,isolir,dismantle'
        ]);

        $subscription->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Subscription berhasil diupdate',
            'data' => $subscription
        ]);
    }

    public function destroy(int $id): JsonResponse
    {
        $subscription = Subscription::find($id);

        if (!$subscription) {
            return response()->json([
                'success' => false,
                'message' => 'Subscription tidak ditemukan'
            ], 404);
        }

        $subscription->delete();

        return response()->json([
            'success' => true,
            'message' => 'Subscription berhasil dihapus'
        ]);
    }

    public function getByStatus($status): JsonResponse
    {
        $subscriptions = Subscription::with(['customer', 'service'])
            ->where('status', $status)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $subscriptions
        ], 200);
    }

    public function changeStatus(Request $request, $id): JsonResponse
    {
        $request->validate([
            'status' => 'required|string|in:active,inactive,trial,isolir,dismantle'
        ]);

        $subscription = Subscription::findOrFail($id);

        // Kalau sudah dismantle, status tidak bisa diubah lagi
        if ($subscription->status === 'dismantle') {
            return response()->json([
                'success' => false,
                'message' => 'Subscription yang sudah dismantle tidak bisa diubah lagi. Silakan buat data subscription baru.'
            ], 400);
        }

        $subscription->update([
            'status' => $request->status
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Status subscription berhasil diubah',
            'data' => $subscription
        ], 200);
    }
}