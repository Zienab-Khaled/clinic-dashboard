<?php

namespace App\Http\Controllers;

use App\Models\Clinic;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DoctorController extends Controller
{
    public function index(Request $request): View
    {
        $clinics = Clinic::query()->orderBy('name')->get();
        $selected = $request->integer('clinic_id');
        $clinic = $selected ? Clinic::find($selected) : null;

        return view('doctor', [
            'clinics' => $clinics,
            'clinic' => $clinic,
        ]);
    }

    public function next(Request $request, Clinic $clinic): RedirectResponse|JsonResponse
    {
        $clinic->callNext();
        $clinic->refresh();

        if ($request->expectsJson()) {
            return response()->json([
                'patient_number' => $clinic->patient_number,
                'current_serving' => $clinic->current_serving,
            ]);
        }

        return redirect()->route('doctor.index', ['clinic_id' => $clinic->id]);
    }
}
