<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AttendanceHistoryController;
use App\Http\Controllers\DepartementController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('absensi.index');
});

// absensi
Route::get('/absensi', [AttendanceController::class, 'index'])->name('absensi.show');
Route::get('/api/get-employee/{employee_id}', [AttendanceController::class, 'getEmployee']);
Route::post('/absensi/masuk', [AttendanceController::class, 'clockIn'])->name('absensi.masuk');
Route::post('/absensi/keluar', [AttendanceController::class, 'clockOut'])->name('absensi.keluar');

// history
Route::get('history', [AttendanceHistoryController::class, 'index'])->name('absensi.history');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // departement
    Route::get('/departement', [DepartementController::class, 'index'])->name('departement.show');
    Route::post('/departement', [DepartementController::class, 'store'])->name('departement.store');
    Route::put('/departement/{id}', [DepartementController::class, 'update'])->name('departement.update');
    Route::delete('/departement/{id}', [DepartementController::class, 'destroy'])->name('departement.destroy');

    // employee
    Route::get('/employee', [EmployeeController::class, 'index'])->name('employee.show');
    Route::get('/employee/create', [EmployeeController::class, 'create'])->name('employee.create');
    Route::post('/employee', [EmployeeController::class, 'store'])->name('employee.store');
    Route::put('/employee/{id}', [EmployeeController::class, 'update'])->name('employee.update');
    Route::delete('/employee/{id}', [EmployeeController::class, 'destroy'])->name('employee.destroy');
});

require __DIR__ . '/auth.php';
