<?php

namespace App\Http\Controllers;

use App\Models\Clinic;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TrackController extends Controller
{
    public function __invoke(Request $request): View
    {
        $clinicId = $request->integer('clinic_id');
        $number = $request->integer('number');

        $clinic = $clinicId && $number ? Clinic::find($clinicId) : null;
        $ahead = 0;
        $currentServing = 0;
        $yourNumber = $number;

        if ($clinic) {
            $currentServing = $clinic->current_serving;
            $ahead = $number > $currentServing ? $number - $currentServing : 0;
        }

        return view('track', [
            'clinic' => $clinic,
            'yourNumber' => $yourNumber,
            'currentServing' => $currentServing,
            'ahead' => $ahead,
        ]);
    }
}
