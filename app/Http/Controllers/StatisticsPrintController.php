<?php

namespace App\Http\Controllers;

use App\Models\Clinic;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StatisticsPrintController extends Controller
{
    public function __invoke(Request $request): View
    {
        $clinics = Clinic::query()->orderBy('name')->get();

        return view('statistics-print', [
            'clinics' => $clinics,
        ]);
    }
}
