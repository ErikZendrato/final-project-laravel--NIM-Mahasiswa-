<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Service;
use illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $status = $request->query('status');

        $query = Service::query();

        if ($status !== null) {
            if (!in_array($status, ['active', 'inactive'], true)) {
                return response()->json([
                    "success" => false,
                    "message" => "Validation failed",
                    "error" => [
                        'status' => "The selected status is invalid."
                    ]
                ], 400);
            }

            $query->where('status', $status === 'active');

        }

        $services = $query->latest()->get();

        return response()->json([
            "success" => true,
            "message" => "Services retrieved successfully",
            "data" => $services
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string'],
            'price' => ['required', 'integer', 'min:0'],
            'description' => ['nullable', 'string'],
            'status' => ['nullable', 'boolean'],
        ]);

        $data['status'] = $data['status'] ?? true;
        $service = Service::query()->create($data);

        return response()->json([
            "success" => true,
            "message" => "Service created successfully",
            "data" => $service
        ], 201);
    }

    public function show(int $service): JsonResponse
    {
        $service = Service::query()->find($service);

        if (!$service) {
            return response()->json([
                "success" => false,
                "message" => "Service not found",
                "error" => [],
            ], 404);
        }

        return response()->json([
            "success" => true,
            "message" => "Service retrieved successfully",
            "data" => $service
        ]);
    }

    public function update(Request $request, int $service): JsonResponse
    {
        $service = Service::query()->find($service);

        if (!$service) {
            return response()->json([
                "success" => false,
                "message" => "Service not found",
                "error" => [],
            ], 404);
        }

        $data = $request->validate([
            'name' => ['sometimes', 'string'],
            'price' => ['sometimes', 'integer', 'min:0'],
            'description' => ['nullable', 'string'],
            'status' => ['nullable', 'boolean'],
        ]);

        $service->update($data);

        return response()->json([
            "success" => true,
            "message" => "Service updated successfully",
            "data" => $service
        ]);
    }

    public function destroy(int $service): JsonResponse
    {
        $service = Service::query()->find($service);

        if (!$service) {
            return response()->json([
                "success" => false,
                "message" => "Service not found",
                "error" => [],
            ], 404);
        }

        if (class_exists('\App\Models\Subscription') && $service->subscriptions()->exists()) {
            return response()->json([
                "success" => false,
                "message" => "Service cannot be deleted because it has active subscriptions",
                "error" => [],
            ], 400);
        }

        $service->delete();

        return response()->json([
            "success" => true,
            "message" => "Service deleted successfully",
            "data" => null
        ]);
    }

    public function activate(int $service): JsonResponse
    {
        $service = Service::query()->find($service);

        if (!$service) {
            return response()->json([
                "success" => false,
                "message" => "Service not found",
                "error" => [],
            ], 404);
        }

        $service->update(['status' => true]);

        return response()->json([
            "success" => true,
            "message" => "Service activated successfully",
            "data" => $service
        ]);
    }

    public function deactivate(int $service): JsonResponse
    {
        $service = Service::query()->find($service);

        if (!$service) {
            return response()->json([
                "success" => false,
                "message" => "Service not found",
                "error" => [],
            ], 404);
        }

        $service->update(['status' => false]);

        return response()->json([
            "success" => true,
            "message" => "Service deactivated successfully",
            "data" => $service
        ]);
    }

    public function getByStatus($status)
    {
        $is_active = filter_var($status, FILTER_VALIDATE_BOOLEAN);
        $services = \App\Models\Service::where('status', $is_active)->get();

        return response()->json(['data' => $services], 200);
    }

    public function changeStatus(\Illuminate\Http\Request $request, $id)
    {
        $request->validate(['status' => 'required|boolean']);

        $service = \App\Models\Service::findOrFail($id);
        $service->update(['status' => $request->status]);

        return response()->json([
            'message' => 'Status service berhasil diubah',
            'data' => $service
        ], 200);
    }
}
