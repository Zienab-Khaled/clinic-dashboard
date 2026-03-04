<?php

namespace App\Http\Controllers;

use App\Models\Clinic;
use Illuminate\View\View;

class StaffController extends Controller
{
    public function index(): View
    {
        $clinics = Clinic::query()->orderBy('name')->get();

        return view('staff', compact('clinics'));
    }
}
