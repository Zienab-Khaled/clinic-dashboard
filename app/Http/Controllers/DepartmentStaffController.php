<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Service;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DepartmentStaffController extends Controller
{
    private const TYPE_LABELS = [
        'emergency' => 'الطوارئ',
        'radiology' => 'الأشعة',
        'pharmacy' => 'الصيدلية',
        'lab' => 'المختبر',
        'diabetes' => 'عيادات السكر',
    ];

    public function index(string $type): View
    {
        $departments = Department::query()
            ->where('type', $type)
            ->orderBy('name')
            ->get();

        $title = Service::query()->where('key', $type)->value('title') ?? self::TYPE_LABELS[$type] ?? $type;

        $service = Service::query()
            ->whereNull('parent_id')
            ->where('key', $type)
            ->where('active', true)
            ->first();
        $hasWaitingDisplay = $service?->has_waiting_display ?? false;

        return view('department-staff', [
            'departments' => $departments,
            'type' => $type,
            'title' => $title,
            'hasWaitingDisplay' => $hasWaitingDisplay,
        ]);
    }

    public function reset(Request $request, string $type): RedirectResponse
    {
        Department::query()
            ->where('type', $type)
            ->update(['patient_number' => 0, 'current_serving' => 0]);

        return redirect()->back()->with('message', 'تم إعادة تعيين الأرقام');
    }

}
