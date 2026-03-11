<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Service;
use Illuminate\Support\Str;
use Illuminate\View\View;

class DepartmentDisplayController extends Controller
{
    public function __invoke(string $type): View
    {
        $departments = Department::query()
            ->where('type', $type)
            ->orderBy('name')
            ->get();

        $service = Service::query()->where('key', $type)->first();
        $departmentTitle = $service?->title ?? $type;
        $departmentTitleEn = $service
            ? Str::title(str_replace(['-', '_'], ' ', $service->key))
            : Str::title(str_replace(['-', '_'], ' ', $type));

        return view('department-display', [
            'departments' => $departments,
            'type' => $type,
            'departmentTitle' => $departmentTitle,
            'departmentTitleEn' => $departmentTitleEn,
        ]);
    }
}

