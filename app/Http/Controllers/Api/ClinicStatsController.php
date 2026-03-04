<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Clinic;
use Illuminate\Http\JsonResponse;

class ClinicStatsController extends Controller
{
    public function index(): JsonResponse
    {
        $clinics = Clinic::query()->orderBy('name')->get()->map(fn (Clinic $c) => [
            'id' => $c->id,
            'name' => $c->name,
            'patient_number' => $c->patient_number,
            'current_serving' => $c->current_serving,
            'waiting' => $c->patient_number - $c->current_serving,
        ]);

        return response()->json($clinics);
    }

    public function show(Clinic $clinic): JsonResponse
    {
        return response()->json([
            'patient_number' => $clinic->patient_number,
            'current_serving' => $clinic->current_serving,
            'waiting' => $clinic->patient_number - $clinic->current_serving,
        ]);
    }
}
