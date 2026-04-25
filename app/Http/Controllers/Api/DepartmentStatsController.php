<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DepartmentStatsController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $type = $request->query('type');
        if (! $type) {
            return response()->json([]);
        }

        $departments = Department::query()
            ->where('type', $type)
            ->orderBy('name')
            ->get()
            ->map(fn (Department $d) => [
                'id' => $d->id,
                'name' => $d->name,
                'patient_number' => $d->patient_number,
                'current_serving' => $d->current_serving,
                'waiting' => $d->patient_number - $d->current_serving,
            ]);

        return response()->json($departments);
    }

    public function show(Department $department): JsonResponse
    {
        return response()->json([
            'id' => $department->id,
            'name' => $department->name,
            'patient_number' => $department->patient_number,
            'current_serving' => $department->current_serving,
            'waiting' => $department->patient_number - $department->current_serving,
        ]);
    }
}
