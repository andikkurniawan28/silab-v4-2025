<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BarcodePrintingController;
use App\Http\Controllers\EstimationSpotController;
use App\Http\Controllers\FactorController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StationController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\ParameterController;
use App\Http\Controllers\MonitoringHourlySpotController;
use App\Http\Controllers\MonitoringShiftlySpotController;
use App\Http\Controllers\RegionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'loginProcess'])->name('login_process');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/changePassword', [AuthController::class, 'changePassword'])->name('changePassword');
Route::post('/changePassword', [AuthController::class, 'changePasswordProcess'])->name('changePasswordProcess');
Route::get('/login/captcha/refresh', function (Request $request) {
    $a = rand(1, 9);
    $b = rand(1, 9);
    $answer = $a + $b;
    session(['captcha_answer' => $answer]);
    return response()->json([
        'question' => "$a + $b = ?"
    ]);
})->name('login.captcha.refresh');
Route::get('/', function () {
    return view('welcome');
})->name('dashboard.index')->middleware(['auth']);
Route::resource('roles', RoleController::class)->middleware(['auth']);
Route::resource('users', UserController::class)->middleware(['auth']);
Route::resource('stations', StationController::class)->middleware(['auth']);
Route::resource('units', UnitController::class)->middleware(['auth']);
Route::resource('parameters', ParameterController::class)->middleware(['auth']);
Route::resource('materials', MaterialController::class)->middleware(['auth']);
Route::resource('monitoring_hourly_spots', MonitoringHourlySpotController::class)->middleware(['auth']);
Route::resource('monitoring_shiftly_spots', MonitoringShiftlySpotController::class)->middleware(['auth']);
Route::resource('estimation_spots', EstimationSpotController::class)->middleware(['auth']);
Route::resource('items', ItemController::class)->middleware(['auth']);
Route::resource('regions', RegionController::class)->middleware(['auth']);
Route::resource('factors', FactorController::class)->middleware(['auth']);
Route::get('barcode_printing/{station_id}', [BarcodePrintingController::class, 'index'])->name('barcode_printing.index')->middleware(['auth']);
Route::post('barcode_printing', [BarcodePrintingController::class, 'process'])->name('barcode_printing.process')->middleware(['auth']);
Route::get('barcode_printing', [BarcodePrintingController::class, 'list'])->name('barcode_printing.list')->middleware(['auth']);
Route::get('barcode_printing/reprint/{analysis_id}', [BarcodePrintingController::class, 'reprint'])->name('barcode_printing.reprint')->middleware(['auth']);
Route::get('barcode_printing/editTimestamp/{analysis_id}', [BarcodePrintingController::class, 'editTimestamp'])->name('barcode_printing.editTimestamp')->middleware(['auth']);
Route::get('barcode_printing/editMaterial/{analysis_id}', [BarcodePrintingController::class, 'editMaterial'])->name('barcode_printing.editMaterial')->middleware(['auth']);
Route::post('barcode_printing/editTimestamp/{analysis_id}', [BarcodePrintingController::class, 'editTimestampProcess'])->name('barcode_printing.editTimestampProcess')->middleware(['auth']);
Route::post('barcode_printing/editMaterial/{analysis_id}', [BarcodePrintingController::class, 'editMaterialProcess'])->name('barcode_printing.editMaterialProcess')->middleware(['auth']);
