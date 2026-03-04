<?php

namespace App\Http\Controllers;

use App\Models\Clinic;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TrackController extends Controller
{
    public function __invoke(Request $request): View
    {
        $clinicId = $request->integer('clinic_id');
        $departmentId = $request->integer('department_id');
        $number = $request->integer('number');

        $clinic = null;
        $department = null;
        $ahead = 0;
        $currentServing = 0;
        $yourNumber = $number;

        if ($clinicId && $number) {
            $clinic = Clinic::find($clinicId);
            if ($clinic) {
                $currentServing = $clinic->current_serving;
                $ahead = $number > $currentServing ? $number - $currentServing : 0;
            }
        }

        if ($departmentId && $number) {
            $department = Department::find($departmentId);
            if ($department) {
                $currentServing = $department->current_serving;
                $ahead = $number > $currentServing ? $number - $currentServing : 0;
            }
        }

        return view('track', [
            'clinic' => $clinic,
            'department' => $department,
            'yourNumber' => $yourNumber,
            'currentServing' => $currentServing,
            'ahead' => $ahead,
        ]);
    }
}
