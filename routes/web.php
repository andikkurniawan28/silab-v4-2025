<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FactorController;
use App\Http\Controllers\FlowNMController;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\BagTestController;
use App\Http\Controllers\StationController;
use App\Http\Controllers\AnalysisController;
use App\Http\Controllers\FlowSpotController;
use App\Http\Controllers\KelilingController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\ParameterController;
use App\Http\Controllers\AnalisaBJBController;
use App\Http\Controllers\AnalisaCaoController;
use App\Http\Controllers\AnalisaSO2Controller;
use App\Http\Controllers\EstimationController;
use App\Http\Controllers\ImbibitionController;
use App\Http\Controllers\AnalisaKetelController;
use App\Http\Controllers\SugarBaggingController;
use App\Http\Controllers\EstimationSpotController;
use App\Http\Controllers\BarcodePrintingController;
use App\Http\Controllers\MonitoringHourlyController;
use App\Http\Controllers\StockTransactionController;
use App\Http\Controllers\MonitoringShiftlyController;
use App\Http\Controllers\AnalysisUnverifiedController;
use App\Http\Controllers\MonitoringHourlySpotController;
use App\Http\Controllers\MonitoringShiftlySpotController;
use App\Http\Controllers\StockTransactionDetailController;
use App\Http\Controllers\AnalisaAmpasMetodePanasController;
use App\Http\Controllers\AnalisaAmpasMetodeDinginController;

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
Route::resource('flow_spots', FlowSpotController::class)->middleware(['auth']);
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
Route::resource('analyses', AnalysisController::class)->middleware(['auth']);
Route::get('analysis_unverified', [AnalysisUnverifiedController::class, 'index'])->name('analysis_unverified.index')->middleware(['auth']);
Route::post('analysis_unverified/process', [AnalysisUnverifiedController::class, 'process'])->name('analysis_unverified.process')->middleware(['auth']);
Route::get('analisa_ampas_metode_panas', [AnalisaAmpasMetodePanasController::class, 'index'])->name('analisa_ampas_metode_panas.index')->middleware(['auth']);
Route::get('analisa_ampas_metode_panas/create', [AnalisaAmpasMetodePanasController::class, 'create'])->name('analisa_ampas_metode_panas.create')->middleware(['auth']);
Route::post('analisa_ampas_metode_panas/create', [AnalisaAmpasMetodePanasController::class, 'store'])->name('analisa_ampas_metode_panas.store')->middleware(['auth']);
Route::get('analisa_ampas_metode_dingin', [AnalisaAmpasMetodeDinginController::class, 'index'])->name('analisa_ampas_metode_dingin.index')->middleware(['auth']);
Route::get('analisa_ampas_metode_dingin/create', [AnalisaAmpasMetodeDinginController::class, 'create'])->name('analisa_ampas_metode_dingin.create')->middleware(['auth']);
Route::post('analisa_ampas_metode_dingin/create', [AnalisaAmpasMetodeDinginController::class, 'store'])->name('analisa_ampas_metode_dingin.store')->middleware(['auth']);
Route::get('analisa_ketel', [AnalisaKetelController::class, 'index'])->name('analisa_ketel.index')->middleware(['auth']);
Route::get('analisa_ketel/create', [AnalisaKetelController::class, 'create'])->name('analisa_ketel.create')->middleware(['auth']);
Route::post('analisa_ketel/create', [AnalisaKetelController::class, 'store'])->name('analisa_ketel.store')->middleware(['auth']);
Route::get('analisa_so2', [AnalisaSO2Controller::class, 'index'])->name('analisa_so2.index')->middleware(['auth']);
Route::get('analisa_so2/create', [AnalisaSO2Controller::class, 'create'])->name('analisa_so2.create')->middleware(['auth']);
Route::post('analisa_so2/create', [AnalisaSO2Controller::class, 'store'])->name('analisa_so2.store')->middleware(['auth']);
Route::get('analisa_cao', [AnalisaCaoController::class, 'index'])->name('analisa_cao.index')->middleware(['auth']);
Route::get('analisa_cao/create', [AnalisaCaoController::class, 'create'])->name('analisa_cao.create')->middleware(['auth']);
Route::post('analisa_cao/create', [AnalisaCaoController::class, 'store'])->name('analisa_cao.store')->middleware(['auth']);
Route::get('analisa_bjb', [AnalisaBJBController::class, 'index'])->name('analisa_bjb.index')->middleware(['auth']);
Route::get('analisa_bjb/create', [AnalisaBJBController::class, 'create'])->name('analisa_bjb.create')->middleware(['auth']);
Route::post('analisa_bjb/create', [AnalisaBJBController::class, 'store'])->name('analisa_bjb.store')->middleware(['auth']);
Route::get('flow_nm', [FlowNMController::class, 'index'])->name('flow_nm.index')->middleware(['auth']);
Route::get('flow_nm/create', [FlowNMController::class, 'create'])->name('flow_nm.create')->middleware(['auth']);
Route::post('flow_nm/create', [FlowNMController::class, 'store'])->name('flow_nm.store')->middleware(['auth']);
Route::delete('flow_nm/{id}', [FlowNMController::class, 'destroy'])->name('flow_nm.destroy')->middleware(['auth']);
Route::get('flow_nm/{id}/edit', [FlowNMController::class, 'edit'])->name('flow_nm.edit')->middleware(['auth']);
Route::put('flow_nm/{id}', [FlowNMController::class, 'update'])->name('flow_nm.update')->middleware(['auth']);
// Route::get('keliling_proses', [KelilingController::class, 'index'])->name('keliling_proses.index')->middleware(['auth']);
// Route::get('keliling_proses/create', [KelilingController::class, 'create'])->name('keliling_proses.create')->middleware(['auth']);
// Route::post('keliling_proses/create', [KelilingController::class, 'store'])->name('keliling_proses.store')->middleware(['auth']);

Route::resource('imbibisi', ImbibitionController::class)->middleware(['auth']);
Route::resource('monitoring_hourlies', MonitoringHourlyController::class)->middleware(['auth']);
Route::resource('monitoring_shiftlies', MonitoringShiftlyController::class)->middleware(['auth']);
Route::resource('estimations', EstimationController::class)->middleware(['auth']);
Route::resource('sugar_baggings', SugarBaggingController::class)->middleware(['auth']);
Route::resource('bag_tests', BagTestController::class)->middleware(['auth']);
Route::resource('stock_transactions', StockTransactionController::class)->middleware(['auth']);
Route::get('stock_transaction_details', StockTransactionDetailController::class)->name('stock_transaction_details.index')->middleware(['auth']);
