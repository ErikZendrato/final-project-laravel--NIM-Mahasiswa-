<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(): JsonResponse
    {
        $customers = Customer::latest()->get();

        return response()->json([
            'success' => true,
            'data' => $customers
        ]);
    }

    // AMBIL NEXT CUSTOMER ID
    public function getNextCustomerId(): JsonResponse
    {
        $lastCustomer = Customer::latest('id')->first();

        $nextNumber = $lastCustomer
            ? (int) substr($lastCustomer->customer_id, 5) + 1
            : 1;

        // FORMAT: CUST-001
        $nextId = 'CUST-' . str_pad((string) $nextNumber, 3, '0', STR_PAD_LEFT);

        return response()->json([
            'success' => true,
            'customer_id' => $nextId
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $lastCustomer = Customer::latest('id')->first();

        $nextNumber = $lastCustomer
            ? (int) substr($lastCustomer->customer_id, 5) + 1
            : 1;

        // FORMAT: CUST-001
        $nextId = 'CUST-' . str_pad((string) $nextNumber, 3, '0', STR_PAD_LEFT);

        $data = $request->validate([
            'name' => 'required|string',
            'email' => 'nullable|email|unique:customers',
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
            'status' => 'nullable|boolean',
        ]);

        $data['customer_id'] = $nextId;

        $customer = Customer::create($data);

        return response()->json([
            'success' => true,
            'data' => $customer
        ], 201);
    }

    public function show(int $id): JsonResponse
    {
        $customer = Customer::find($id);

        if (!$customer) {
            return response()->json([
                'success' => false,
                'message' => 'Not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $customer
        ]);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $customer = Customer::find($id);

        if (!$customer) {
            return response()->json([
                'success' => false,
                'message' => 'Not found'
            ], 404);
        }

        $data = $request->validate([
            'name' => 'sometimes|string',
            'email' => 'nullable|email|unique:customers,email,' . $id,
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
            'status' => 'nullable|boolean',
        ]);

        $customer->update($data);

        return response()->json([
            'success' => true,
            'data' => $customer
        ]);
    }

    public function destroy(int $id): JsonResponse
    {
        $customer = Customer::find($id);

        if (!$customer) {
            return response()->json([
                'success' => false,
                'message' => 'Not found'
            ], 404);
        }

        $customer->delete();

        return response()->json([
            'success' => true,
            'message' => 'Deleted'
        ]);
    }

    public function getByStatus($status)
    {
        $is_active = filter_var($status, FILTER_VALIDATE_BOOLEAN);

        $customers = Customer::where('status', $is_active)->get();

        return response()->json([
            'data' => $customers
        ], 200);
    }

    public function changeStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|boolean'
        ]);

        $customer = Customer::findOrFail($id);

        $customer->update([
            'status' => $request->status
        ]);

        return response()->json([
            'message' => 'Status customer berhasil diubah',
            'data' => $customer
        ], 200);
    }
}