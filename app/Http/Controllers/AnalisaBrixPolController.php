<?php

namespace App\Http\Controllers;

use App\Models\Factor;
use App\Models\Analysis;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\ParameterMaterial;

class AnalisaBrixPolController extends Controller
{
    public function index(Request $request){
        if ($response = $this->checkIzin('akses_daftar_analisa_brix_pol')) {
            return $response;
        }

        if ($request->ajax()) {
            $materials = ParameterMaterial::select(['material_id'])->whereIn('parameter_id', [1, 2, 3,4])->get();
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
                ->rawColumns(['action', 'status'])
                ->make(true);
        }
        return view('analisa_brix_pol.index');
    }

    public function create(){
        if ($response = $this->checkIzin('akses_tambah_analisa_brix_pol')) {
            return $response;
        }
        $materials = ParameterMaterial::select(['material_id'])->whereIn('parameter_id', [1, 2, 3,4])->get();
        $samples = Analysis::with('material')->whereIn('material_id', $materials)->select(['id', 'material_id'])->whereNull('p1')->whereNull('p2')->where('is_verified', 0)->get();
        return view('analisa_brix_pol.create', compact('samples'));
    }

    public function store(Request $request){
        if ($response = $this->checkIzin('akses_tambah_analisa_brix_pol')) {
            return $response;
        }
        Analysis::whereId($request->id)->update([
            'p1' => $request->p1,
            'p2' => $request->p2,
            'p3' => $request->p3,
            'p4' => $request->p4,
        ]);
        return redirect()->route('analisa_brix_pol.index')->with('success', 'Data berhasil disimpan');
    }
}
