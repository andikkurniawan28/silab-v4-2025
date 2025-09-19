<?php

namespace App\Http\Controllers;

use App\Models\Factor;
use App\Models\Analysis;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\ParameterMaterial;

class AnalisaAmpasMetodePanasController extends Controller
{
    public function index(Request $request){
        if ($response = $this->checkIzin('akses_daftar_analisa_ampas_metode_panas')) {
            return $response;
        }

        if ($request->ajax()) {
            $materials = ParameterMaterial::select(['material_id'])->where('parameter_id', 9)->get();
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
                ->rawColumns(['action', 'status', 'result'])
                ->make(true);
        }

        return view('analisa_ampas_metode_panas.index');
    }

    public function create(){
        if ($response = $this->checkIzin('akses_tambah_analisa_ampas_metode_panas')) {
            return $response;
        }
        $materials = ParameterMaterial::select(['material_id'])->where('parameter_id', 9)->get();
        $samples = Analysis::whereIn('material_id', $materials)->select(['id', 'p3 as pol', 'p7 as kadar_air'])->whereNull('p9')->where('is_verified', 0)->get();
        $factor = Factor::where('name', 'Faktor Analisa Ampas Metode Panas')->get()->last()->value;
        return view('analisa_ampas_metode_panas.create', compact('samples', 'factor'));
    }

    public function store(Request $request){
        if ($response = $this->checkIzin('akses_tambah_analisa_ampas_metode_panas')) {
            return $response;
        }
        Analysis::whereId($request->id)->update([
            'p8' => $request->zat_kering,
            'p9' => $request->pol_ampas,
        ]);
        return redirect()->back()->with('success', 'Data berhasil disimpan');
    }
}
