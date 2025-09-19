<?php

namespace App\Http\Controllers;

use App\Models\Analysis;
use App\Models\Material;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\ParameterMaterial;

class AnalisaKetelController extends Controller
{
    public function index(Request $request){
        if ($response = $this->checkIzin('akses_daftar_analisa_ketel')) {
            return $response;
        }

        if ($request->ajax()) {
            $materials = Material::select(['id'])->where('station_id', 9)->get();
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

        return view('analisa_ketel.index');
    }

    public function create(){
        if ($response = $this->checkIzin('akses_tambah_analisa_ketel')) {
            return $response;
        }
        $materials = Material::select(['id'])->where('station_id', 9)->get();
        $samples = Analysis::whereIn('material_id', $materials)
            ->where('is_verified', 0)
            ->get();
        $parameters = ParameterMaterial::query()
            ->select('parameter_id')
            ->distinct()
            ->with('parameter')
            ->whereHas('material', function ($q) {
                $q->where('station_id', 9);
            })
            ->get();
        return view('analisa_ketel.create', compact('samples', 'parameters'));
    }

    public function store(Request $request) {
        if ($response = $this->checkIzin('akses_tambah_analisa_ketel')) {
            return $response;
        }

        $analysis = Analysis::findOrFail($request->id);

        $updates = [];
        foreach ($request->all() as $key => $value) {
            if (preg_match('/^p(\d+)$/', $key, $matches)) {
                $paramId = $matches[1];
                $updates['p' . $paramId] = $value;
            }
        }

        $analysis->update($updates);

        return redirect()
            ->back()
            ->with('success', 'Data berhasil disimpan');
    }
}
