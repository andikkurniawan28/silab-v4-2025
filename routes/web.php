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
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ResultController;
use App\Http\Controllers\AriCardController;
use App\Http\Controllers\BagTestController;
use App\Http\Controllers\KawalanController;
use App\Http\Controllers\PosbrixController;
use App\Http\Controllers\StationController;
use App\Http\Controllers\VarietyController;
use App\Http\Controllers\AnalysisController;
use App\Http\Controllers\CoreCardController;
use App\Http\Controllers\FlowSpotController;
use App\Http\Controllers\ImpurityController;
use App\Http\Controllers\KelilingController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\MollasesController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ParameterController;
use App\Http\Controllers\AnalisaBJBController;
use App\Http\Controllers\AnalisaCaoController;
use App\Http\Controllers\AnalisaSO2Controller;
use App\Http\Controllers\CoreSampleController;
use App\Http\Controllers\EstimationController;
use App\Http\Controllers\ImbibitionController;
use App\Http\Controllers\AnalisaLainController;
use App\Http\Controllers\AnalisaKetelController;
use App\Http\Controllers\AriTimbanganController;
use App\Http\Controllers\PenilaianMbsController;
use App\Http\Controllers\SugarBaggingController;
use App\Http\Controllers\AnalisaBrixPolController;
use App\Http\Controllers\EstimationSpotController;
use App\Http\Controllers\AnalisaRendemenController;
use App\Http\Controllers\BarcodePrintingController;
use App\Http\Controllers\MonitoringHourlyController;
use App\Http\Controllers\StockTransactionController;
use App\Http\Controllers\MonitoringShiftlyController;
use App\Http\Controllers\AnalysisUnverifiedController;
use App\Http\Controllers\MonitoringHourlySpotController;
use App\Http\Controllers\AnalysisChangeRequestController;
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
Route::get('/data', [DashboardController::class, 'data'])->name('dashboard.data');
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
Route::resource('impurities', ImpurityController::class)->middleware(['auth']);
Route::resource('varieties', VarietyController::class)->middleware(['auth']);
Route::resource('kawalans', KawalanController::class)->middleware(['auth']);
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
Route::get('analisa_brix_pol', [AnalisaBrixPolController::class, 'index'])->name('analisa_brix_pol.index')->middleware(['auth']);
Route::get('analisa_brix_pol/create', [AnalisaBrixPolController::class, 'create'])->name('analisa_brix_pol.create')->middleware(['auth']);
Route::post('analisa_brix_pol/create', [AnalisaBrixPolController::class, 'store'])->name('analisa_brix_pol.store')->middleware(['auth']);
Route::get('analisa_rendemen', [AnalisaRendemenController::class, 'index'])->name('analisa_rendemen.index')->middleware(['auth']);
Route::get('analisa_rendemen/create', [AnalisaRendemenController::class, 'create'])->name('analisa_rendemen.create')->middleware(['auth']);
Route::post('analisa_rendemen/create', [AnalisaRendemenController::class, 'store'])->name('analisa_rendemen.store')->middleware(['auth']);
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
Route::get('analisa_lain', [AnalisaLainController::class, 'index'])->name('analisa_lain.index')->middleware(['auth']);
Route::get('analisa_lain/create', [AnalisaLainController::class, 'create'])->name('analisa_lain.create')->middleware(['auth']);
Route::post('analisa_lain/create', [AnalisaLainController::class, 'store'])->name('analisa_lain.store')->middleware(['auth']);
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
Route::resource('mollases', MollasesController::class)->middleware(['auth']);
Route::resource('bag_tests', BagTestController::class)->middleware(['auth']);
Route::resource('stock_transactions', StockTransactionController::class)->middleware(['auth']);
Route::get('stock_transaction_details', StockTransactionDetailController::class)->name('stock_transaction_details.index')->middleware(['auth']);
Route::resource('core_cards', CoreCardController::class)->middleware(['auth']);
Route::resource('ari_cards', AriCardController::class)->middleware(['auth']);
Route::resource('posbrixes', PosbrixController::class)->middleware(['auth']);
Route::resource('core_samples', CoreSampleController::class)->middleware(['auth']);
Route::resource('ari_timbangans', AriTimbanganController::class)->middleware(['auth']);
Route::resource('penilaian_mbss', PenilaianMbsController::class)->middleware(['auth']);

Route::post('results/perstation/{station_id}', [ResultController::class, 'perStationData'])->name('results.perstation.data');
Route::get('results/perstation/{station_id}', [ResultController::class, 'perStation'])->name('results.perstation.index')->middleware(['auth']);
Route::post('results/permaterial/{material_id}', [ResultController::class, 'perMaterialData'])->name('results.permaterial.data');
Route::get('results/permaterial/{material_id}', [ResultController::class, 'perMaterial'])->name('results.permaterial.index')->middleware(['auth']);
Route::get('reports/analysis/{date}/{shift}', [ReportController::class, 'analysisData'])->name('reports.analysis.data');
Route::get('reports/analysis', [ReportController::class, 'analysis'])->name('reports.analysis.index')->middleware(['auth']);
Route::get('reports/process/{date}/{shift}', [ReportController::class, 'processData'])->name('reports.process.data');
Route::get('reports/process', [ReportController::class, 'process'])->name('reports.process.index')->middleware(['auth']);
Route::get('reports/posbrix/{date}/{shift}', [ReportController::class, 'posbrixData'])->name('reports.posbrix.data');
Route::get('reports/posbrix', [ReportController::class, 'posbrix'])->name('reports.posbrix.index')->middleware(['auth']);
Route::get('reports/coreSample/{date}/{shift}', [ReportController::class, 'coreSampleData'])->name('reports.coreSample.data');
Route::get('reports/coreSample', [ReportController::class, 'coreSample'])->name('reports.coreSample.index')->middleware(['auth']);
Route::get('reports/ariTimbangan/{date}/{shift}', [ReportController::class, 'ariTimbanganData'])->name('reports.ariTimbangan.data');
Route::get('reports/ariTimbangan', [ReportController::class, 'ariTimbangan'])->name('reports.ariTimbangan.index')->middleware(['auth']);
Route::get('reports/penilaianMbs/{date}/{shift}', [ReportController::class, 'penilaianMbsData'])->name('reports.penilaianMbs.data');
Route::get('reports/penilaianMbs', [ReportController::class, 'penilaianMbs'])->name('reports.penilaianMbs.index')->middleware(['auth']);
Route::post('reports/coa_tetes', [ReportController::class, 'coaTetesData'])->name('reports.coaTetes.data');
Route::get('reports/coa_tetes', [ReportController::class, 'coaTetes'])->name('reports.coaTetes.index')->middleware(['auth']);
Route::post('reports/coa_kapur', [ReportController::class, 'coaKapurData'])->name('reports.coaKapur.data');
Route::get('reports/coa_kapur', [ReportController::class, 'coaKapur'])->name('reports.coaKapur.index')->middleware(['auth']);
Route::post('reports/uji_karung', [ReportController::class, 'ujiKarungData'])->name('reports.ujiKarung.data');
Route::get('reports/uji_karung', [ReportController::class, 'ujiKarung'])->name('reports.ujiKarung.index')->middleware(['auth']);
Route::post('reports/mutasi_barang', [ReportController::class, 'mutasiBarangData'])->name('reports.mutasiBarang.data');
Route::get('reports/mutasi_barang', [ReportController::class, 'mutasiBarang'])->name('reports.mutasiBarang.index')->middleware(['auth']);
Route::get('analysis_change_request', [AnalysisChangeRequestController::class, 'index'])->name('analysisChangeRequest.index')->middleware(['auth']);
Route::get('analysis_change_request/{analysis}', [AnalysisChangeRequestController::class, 'edit'])->name('analysisChangeRequest.propose')->middleware(['auth']);
Route::post('analysis_change_request/{analysis}', [AnalysisChangeRequestController::class, 'process'])->name('analysisChangeRequest.process')->middleware(['auth']);
Route::get('analysis_change_request/close/{id}', [AnalysisChangeRequestController::class, 'close'])->name('analysisChangeRequest.close');
Route::get('analysis_change_request/closeAksesMobile/{id}', [AnalysisChangeRequestController::class, 'closeAksesMobile'])->name('analysisChangeRequest.closeAksesMobile');
