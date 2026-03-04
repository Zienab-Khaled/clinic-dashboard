<?php

namespace App\Http\Controllers;

use App\Models\Clinic;
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

    public function next(Clinic $clinic): RedirectResponse
    {
        $clinic->callNext();

        return redirect()->route('doctor.index', ['clinic_id' => $clinic->id]);
    }
}
