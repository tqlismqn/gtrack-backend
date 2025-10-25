<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DriverController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Driver::with(['documents']);

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'ILIKE', "%{$search}%")
                  ->orWhere('last_name', 'ILIKE', "%{$search}%")
                  ->orWhere('email', 'ILIKE', "%{$search}%");

                if (is_numeric($search)) {
                    $q->orWhere('internal_number', (int) $search);
                }
            });
        }

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        $perPage = $request->input('per_page', 15);
        $drivers = $query->paginate($perPage);

        return response()->json($drivers);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'birth_date' => 'required|date',
            'citizenship' => 'required|string|size:2',
            'email' => 'required|email|unique:drivers,email',
            'phone' => 'required|string|max:20',
        ]);

        $driver = Driver::create($validated);

        return response()->json($driver, 201);
    }

    public function show(Driver $driver): JsonResponse
    {
        $driver->load(['documents', 'comments.author']);

        return response()->json($driver);
    }

    public function update(Request $request, Driver $driver): JsonResponse
    {
        $validated = $request->validate([
            'first_name' => 'sometimes|string|max:255',
            'last_name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:drivers,email,' . $driver->id,
        ]);

        $driver->update($validated);

        return response()->json($driver);
    }

    public function destroy(Driver $driver): JsonResponse
    {
        $driver->delete();

        return response()->json(null, 204);
    }
}
