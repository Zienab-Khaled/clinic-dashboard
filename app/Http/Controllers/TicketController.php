<?php

namespace App\Http\Controllers;

use App\Models\Clinic;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function show(Clinic $clinic)
    {
        $ticketNumber = $clinic->generateTicketNumber();
        $hospitalName = 'مستشفى الملك عبد العزيز التخصصي بالجوف';

        $now = now()->locale('ar');

        $trackUrl = url()->route('track', [
            'clinic_id' => $clinic->id,
            'number' => $ticketNumber,
        ]);

        return view('ticket', [
            'clinicId' => $clinic->id,
            'clinicName' => $clinic->name,
            'ticketNumber' => $ticketNumber,
            'trackUrl' => $trackUrl,
            'date' => $now->translatedFormat('l، d F Y'),
            'time' => $now->format('h:i:s') . ' ' . ($now->format('A') === 'AM' ? 'ص' : 'م'),
            'hospitalName' => $hospitalName,
        ]);
    }
}
