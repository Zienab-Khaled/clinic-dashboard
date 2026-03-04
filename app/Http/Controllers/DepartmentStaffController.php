<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DepartmentStaffController extends Controller
{
    private const TYPE_LABELS = [
        'radiology' => 'الأشعة',
        'pharmacy' => 'الصيدلية',
        'lab' => 'المختبر',
    ];

    public function index(string $type): View
    {
        $departments = Department::query()
            ->where('type', $type)
            ->orderBy('name')
            ->get();

        $title = self::TYPE_LABELS[$type] ?? $type;

        return view('department-staff', [
            'departments' => $departments,
            'type' => $type,
            'title' => $title,
        ]);
    }

    public function reset(Request $request, string $type): RedirectResponse
    {
        Department::query()
            ->where('type', $type)
            ->update(['patient_number' => 0, 'current_serving' => 0]);

        return redirect()->back()->with('message', 'تم إعادة تعيين الأرقام');
    }

    public function next(Department $department): RedirectResponse
    {
        $department->callNext();
        return redirect()->back();
    }
}
