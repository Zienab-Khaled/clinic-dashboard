<?php

use App\Http\Controllers\StatisticsPrintController;
use App\Http\Controllers\TicketController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/admin');
});

Route::get('/ticket/{clinic}', [TicketController::class, 'show'])->name('ticket.show');

Route::middleware('auth')->group(function () {
    Route::get('/admin/statistics/print', StatisticsPrintController::class)->name('admin.statistics.print');
});
