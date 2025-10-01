<?php

namespace App\Http\Controllers;

use App\Models\Factor;
use App\Models\Analysis;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\ParameterMaterial;

class AnalisaSO2Controller extends Controller
{
    public function index(Request $request){
        if ($response = $this->checkIzin('akses_daftar_analisa_so2')) {
            return $response;
        }

        if ($request->ajax()) {
            $materials = ParameterMaterial::select(['material_id'])->where('parameter_id', 18)->get();
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
        return view('analisa_so2.index');
    }

    public function create(){
        if ($response = $this->checkIzin('akses_tambah_analisa_so2')) {
            return $response;
        }
        $materials = ParameterMaterial::select(['material_id'])->where('parameter_id', 18)->get();
        $samples = Analysis::with('material')->whereIn('material_id', $materials)->select(['id', 'material_id'])->whereNull('p18')->where('is_verified', 0)->get();
        $factor = Factor::where('name', 'Faktor Yodium')->get()->last()->value;
        return view('analisa_so2.create', compact('samples', 'factor'));
    }

    public function store(Request $request){
        if ($response = $this->checkIzin('akses_tambah_analisa_so2')) {
            return $response;
        }
        Analysis::whereId($request->id)->update(['p18' => $request->so2]);
        $data = json_encode($request);
        ActivityLog::log(Auth()->user()->id, "Input Analisa SO2 barcode {$request->id} {$data}.");
        return redirect()->back()->with('success', 'Data berhasil disimpan');
    }
}
