<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Clinic;
use Illuminate\Http\JsonResponse;

class ClinicStatsController extends Controller
{
    public function show(Clinic $clinic): JsonResponse
    {
        return response()->json([
            'patient_number' => $clinic->patient_number,
            'current_serving' => $clinic->current_serving,
            'waiting' => $clinic->patient_number - $clinic->current_serving,
        ]);
    }
}
