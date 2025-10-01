<?php

namespace App\Http\Controllers;

use App\Models\Factor;
use App\Models\Analysis;
use App\Models\Material;
use App\Models\Parameter;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\ParameterMaterial;

class AnalisaLainController extends Controller
{
    public function index(Request $request){
        if ($response = $this->checkIzin('akses_daftar_analisa_lain')) {
            return $response;
        }

        if ($request->ajax()) {
            $materials = Material::select(['id'])->get();
            $data = Analysis::whereIn('material_id', $materials)->with(['material', 'user']);
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('material', function ($row) {
                    return $row->material ? $row->material->name : '-';
                })
                ->addColumn('user', function ($row) {
                    return $row->user ? $row->user->name : '-';
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
                ->rawColumns(['action', 'status', 'result'])
                ->make(true);
        }
        return view('analisa_lain.index');
    }

    public function create(){
        if ($response = $this->checkIzin('akses_tambah_analisa_lain')) {
            return $response;
        }
        $materials = Material::select(['id'])->get();
        $samples = Analysis::with('material')->whereIn('material_id', $materials)->select(['id', 'material_id'])->where('is_verified', 0)->get();
        $parameters = Parameter::whereNotIn('id', [1, 2, 3, 4, 5, 8, 9, 10, 11, 17, 18, 19])->get();
        return view('analisa_lain.create', compact('samples', 'parameters'));
    }

    public function store(Request $request){
        if ($response = $this->checkIzin('akses_tambah_analisa_lain')) {
            return $response;
        }
        $analysis = Analysis::findOrFail($request->id);
        $parameters = Parameter::whereNotIn('id', [1, 2, 3, 4, 5, 8, 9, 10, 11, 17, 18, 19])->get();
        foreach($parameters as $p)
        {
            $fieldName = 'p' . $p->id;
            $analysis->$fieldName = $request->$fieldName;
        }
        $analysis->save();
        $data = json_encode($request);
        ActivityLog::log(Auth()->user()->id, "Input Analisa Lain barcode {$request->id} {$data}.");
        return redirect()->route('analisa_lain.index')->with('success', 'Data berhasil disimpan');
    }
}
