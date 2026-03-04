<?php

namespace App\Http\Controllers;

use App\Models\Clinic;
use Illuminate\View\View;

class DisplayController extends Controller
{
    public function __invoke(): View
    {
        $clinics = Clinic::query()->orderBy('name')->get();

        return view('display', compact('clinics'));
    }
}
