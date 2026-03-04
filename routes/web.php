<?php

use App\Http\Controllers\Api\ClinicStatsController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\DisplayController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\StatisticsPrintController;
use App\Http\Controllers\TicketController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/admin');
});

Route::get('/ticket/{clinic}', [TicketController::class, 'show'])->name('ticket.show');

Route::get('/api/clinics/{clinic}', [ClinicStatsController::class, 'show'])->name('api.clinics.show');
Route::get('/staff', [StaffController::class, 'index'])->name('staff');
Route::get('/doctor', [DoctorController::class, 'index'])->name('doctor.index');
Route::post('/doctor/{clinic}/next', [DoctorController::class, 'next'])->name('doctor.next');
Route::get('/display', DisplayController::class)->name('display');

Route::middleware('auth')->group(function () {
    Route::get('/admin/statistics/print', StatisticsPrintController::class)->name('admin.statistics.print');
});
