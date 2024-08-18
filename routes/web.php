<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\BiometricDeviceController;
use App\Http\Controllers\CheckController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\ScheduleController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('attended/{user_id}', [AttendanceController::class, 'attended'])->name('attended');
Route::get('attended-before/{user_id}', [AttendanceController::class, 'attendedBefore'])->name('attendedBefore');

Auth::routes(['register' => false, 'reset' => false]);

Route::group(['middleware' => ['auth', 'Role'], 'roles' => ['admin']], function () {
    Route::resource('/employees', EmployeeController::class);
    Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance');

    Route::get('/latetime', [AttendanceController::class, 'indexLatetime'])->name('indexLatetime');
    Route::get('/leave', [LeaveController::class, 'index'])->name('leave');
    Route::get('/overtime', [LeaveController::class, 'indexOvertime'])->name('indexOvertime');

    Route::get('/admin', [AdminController::class, 'index'])->name('admin');

    Route::resource('/schedule', ScheduleController::class);

    Route::get('/check', [CheckController::class, 'index'])->name('check');
    Route::get('/sheet-report', [CheckController::class, 'sheetReport'])->name('sheet-report');
    Route::post('check-store', [CheckController::class, 'CheckStore'])->name('check_store');

    // Fingerprint Devices
    Route::resource('/finger_device', BiometricDeviceController::class);
    Route::delete('finger_device/destroy', [BiometricDeviceController::class, 'massDestroy'])->name('finger_device.massDestroy');
    Route::get('finger_device/{fingerDevice}/employees/add', [BiometricDeviceController::class, 'addEmployee'])->name('finger_device.add.employee');
    Route::get('finger_device/{fingerDevice}/get/attendance', [BiometricDeviceController::class, 'getAttendance'])->name('finger_device.get.attendance');

    // Temp Clear Attendance route
    Route::get('finger_device/clear/attendance', function () {
        $midnight = \Carbon\Carbon::createFromTime(23, 50, 00);
        $diff = now()->diffInMinutes($midnight);
        dispatch(new ClearAttendanceJob())->delay(now()->addMinutes($diff));
        toast("Attendance Clearance Queue will run at 11:50 P.M!", "success");

        return back();
    })->name('finger_device.clear.attendance');
});
Route::post('/employees/view-pdf',[EmployeeController::class, 'viewPDF'])->name('employees.viewPdf');
Route::post('/employees/download-pdf',[EmployeeController::class, 'downloadPDF'])->name('employees.downloadPDF');
// Fallback route
// Route::get('{any}', [App\Http\Controllers\VeltrixController::class, 'index']);
