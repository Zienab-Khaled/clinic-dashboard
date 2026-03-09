<?php

use App\Http\Controllers\Api\ClinicStatsController;
use App\Http\Controllers\Api\DepartmentStatsController;
use App\Http\Controllers\DepartmentStaffController;
use App\Http\Controllers\DepartmentTicketController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\DisplayController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\StatisticsPrintController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\TrackController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('landing');
})->name('home');

Route::get('/ticket/{clinic}', [TicketController::class, 'show'])->name('ticket.show');
Route::get('/ticket/department/{department}', [DepartmentTicketController::class, 'show'])->name('department.ticket.show');
Route::get('/track', TrackController::class)->name('track');

Route::get('/api/clinics', [ClinicStatsController::class, 'index'])->name('api.clinics.index');
Route::get('/api/clinics/{clinic}', [ClinicStatsController::class, 'show'])->name('api.clinics.show');
Route::get('/api/departments', [DepartmentStatsController::class, 'index'])->name('api.departments.index');
Route::get('/staff', [StaffController::class, 'index'])->name('staff');
Route::get('/department/{type}', [DepartmentStaffController::class, 'index'])->name('department.staff')->where('type', 'emergency|radiology|pharmacy|lab');
Route::post('/department/{type}/reset', [DepartmentStaffController::class, 'reset'])->name('department.reset')->where('type', 'emergency|radiology|pharmacy|lab');
Route::post('/department/{department}/next', [DepartmentStaffController::class, 'next'])->name('department.next')->where('department', '[0-9]+');
Route::get('/doctor', [DoctorController::class, 'index'])->name('doctor.index');
Route::post('/doctor/{clinic}/next', [DoctorController::class, 'next'])->name('doctor.next');
Route::get('/display', DisplayController::class)->name('display');

Route::middleware('auth')->group(function () {
    Route::get('/admin/statistics/print', StatisticsPrintController::class)->name('admin.statistics.print');
});
