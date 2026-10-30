<?php

use App\Http\Controllers\LaporTuntasController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LaporTuntasController::class, 'welcome'])->name('welcome');
Route::get('/lokasi-belum-aktif', [LaporTuntasController::class, 'locationDenied'])->name('location.denied');
Route::get('/peta', [LaporTuntasController::class, 'map'])->name('reports.map');
Route::get('/laporan/buat', [LaporTuntasController::class, 'createReport'])->name('reports.create');
Route::post('/laporan', [LaporTuntasController::class, 'storeReport'])->name('reports.store');
Route::get('/tiket/{ticketId}', [LaporTuntasController::class, 'receipt'])->name('reports.receipt');
Route::get('/lacak-tiket', [LaporTuntasController::class, 'track'])->name('tickets.track');
Route::post('/lacak-tiket', [LaporTuntasController::class, 'lookup'])->name('tickets.lookup');
Route::get('/laporan/{ticketId}', [LaporTuntasController::class, 'reportDetail'])->name('reports.show');

Route::prefix('petugas')->name('staff.')->group(function (): void {
    Route::get('/login', [LaporTuntasController::class, 'staffLogin'])->name('login');
    Route::post('/login', [LaporTuntasController::class, 'authenticateStaff'])->name('authenticate');
    Route::get('/', [LaporTuntasController::class, 'staffDashboard'])->name('dashboard');
    Route::patch('/laporan/{ticketId}', [LaporTuntasController::class, 'updateReportStatus'])->name('reports.update');
    Route::post('/logout', [LaporTuntasController::class, 'logoutStaff'])->name('logout');
});
