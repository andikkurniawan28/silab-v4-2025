<?php

namespace App\Http\Controllers;

use App\Models\Factor;
use App\Models\Analysis;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\ParameterMaterial;

class AnalisaAmpasMetodeDinginController extends Controller
{
    public function index(Request $request){
        if ($response = $this->checkIzin('akses_daftar_analisa_ampas_metode_dingin')) {
            return $response;
        }

        if ($request->ajax()) {
            $materials = ParameterMaterial::select(['material_id'])->where('parameter_id', 10)->get();
            $data = Analysis::whereIn('material_id', $materials)->with(['material', 'user']);
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('material', function ($row) {
                    return $row->material ? $row->material->name : '-';
                })
                ->addColumn('user', function ($row) {
                    return $row->user ? $row->user->name : '-';
                })
                ->addColumn('result', function ($row) {
                    $parameters = $row->material->parameters ?? collect();
                    if ($parameters->isEmpty()) {
                        return '-';
                    }
                    $list = '<ul class="mb-0 ps-3">';
                    foreach ($parameters as $param) {
                        $colName = 'p' . $param->id;
                        $value   = $row->{$colName} ?? '-';
                        $list .= '<li>' . e($param->name);
                        if ($param->unit) {
                            $list .= '<sub>(' . e($param->unit->name) . ')</sub>';
                        }
                        $list .= ' : ' . e($value) . '</li>';
                    }
                    $list .= '</ul>';
                    return $list;
                })
                ->addColumn('status', function ($row) {
                    return $row->is_verified
                        ? '<span class="badge bg-success text-white">Telah Diverifikasi</span>'
                        : '<span class="badge bg-danger text-white">Belum Diverifikasi</span>';
                })
                ->addColumn('created_at', function ($row) {
                    return $row->created_at
                        ? $row->created_at->format('d-m-Y H:i')
                        : '-';
                })
                ->rawColumns(['action', 'status', 'result'])
                ->make(true);
        }

        return view('analisa_ampas_metode_dingin.index');
    }

    public function create(){
        if ($response = $this->checkIzin('akses_tambah_analisa_ampas_metode_dingin')) {
            return $response;
        }
        $materials = ParameterMaterial::select(['material_id'])->where('parameter_id', 9)->get();
        $samples = Analysis::with(['material'])->whereIn('material_id', $materials)->select(['id', 'p3 as pol', 'p7 as kadar_air', 'material_id'])->whereNull('p9')->where('is_verified', 0)->get();
        $factor = Factor::where('name', 'Faktor Analisa Ampas Metode Panas')->get()->last()->value;
        return view('analisa_ampas_metode_dingin.create', compact('samples', 'factor'));
    }

    public function store(Request $request){
        if ($response = $this->checkIzin('akses_tambah_analisa_ampas_metode_dingin')) {
            return $response;
        }
        Analysis::whereId($request->id)->update([
            'p8' => $request->zat_kering,
            'p10' => $request->pol_ampas,
        ]);
        $data = json_encode($request);
        ActivityLog::log(Auth()->user()->id, "Input Analisa Ampas Metode John Payne barcode {$request->id} {$data}.");
        return redirect()->back()->with('success', 'Data berhasil disimpan');
    }
}
