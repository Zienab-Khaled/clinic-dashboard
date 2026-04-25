<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Service;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DepartmentDoctorController extends Controller
{
    public function index(Request $request, string $type): View
    {
        $departments = Department::query()->where('type', $type)->orderBy('name')->get();
        $selected = $request->integer('department_id');
        $department = $selected ? Department::where('id', $selected)->where('type', $type)->first() : null;
        
        $title = Service::query()->where('key', $type)->value('title') ?? $type;

        return view('department-doctor', [
            'departments' => $departments,
            'department' => $department,
            'type' => $type,
            'title' => $title,
        ]);
    }

    public function next(Request $request, Department $department): RedirectResponse|JsonResponse
    {
        $department->callNext();
        $department->refresh();

        if ($request->expectsJson()) {
            return response()->json([
                'patient_number' => $department->patient_number,
                'current_serving' => $department->current_serving,
            ]);
        }

        return redirect()->route('department.doctor.index', [
            'type' => $department->type, 
            'department_id' => $department->id
        ]);
    }
}
