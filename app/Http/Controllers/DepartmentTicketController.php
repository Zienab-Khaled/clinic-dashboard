<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\View\View;

class DepartmentTicketController extends Controller
{
    public function show(Department $department): View
    {
        $ticketNumber = $department->generateTicketNumber();
        $hospitalName = setting('hospital_name', 'مستشفى الملك عبد العزيز التخصصي بالجوف');
        $now = now()->locale('ar');

        $trackUrl = url()->route('track', [
            'department_id' => $department->id,
            'number' => $ticketNumber,
        ]);

        $backUrl = url('/department/' . $department->type);

        return view('ticket-department', [
            'department' => $department,
            'departmentId' => $department->id,
            'departmentName' => $department->name,
            'ticketNumber' => $ticketNumber,
            'trackUrl' => $trackUrl,
            'date' => $now->translatedFormat('l، d F Y'),
            'time' => $now->format('h:i:s') . ' ' . ($now->format('A') === 'AM' ? 'ص' : 'م'),
            'hospitalName' => $hospitalName,
            'backUrl' => $backUrl,
        ]);
    }
}
