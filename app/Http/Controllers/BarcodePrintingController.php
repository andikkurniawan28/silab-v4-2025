<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Station;
use App\Models\Analysis;
use App\Models\Material;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class BarcodePrintingController extends Controller
{
    public function index($station_id){
        if ($response = $this->checkIzin('akses_cetak_barcode')) {
            return $response;
        }

        $materials = Material::select(['id', 'name'])
            ->where('station_id', $station_id)
            ->where('sampling_method', 'request')
            ->where('is_active', 1)
            ->orderBy('id')->get();
        $station = Station::whereId($station_id)->get()->last()->name;

        return view('barcode_printing.index', compact('materials', 'station', 'station_id'));
    }

    public function process(Request $request){
        if ($response = $this->checkIzin('akses_cetak_barcode')) {
            return $response;
        }

        $createdAt = Carbon::parse($request->date)
            ->setTimeFromTimeString($request->time);

        $sample = Analysis::create([
            'material_id' => $request->material_id,
            'user_id' => Auth()->user()->id,
            'created_at' => $createdAt,
        ]);
        return view('barcode_printing.show', compact('sample'));
    }

    public function reprint($analysis_id){
        if ($response = $this->checkIzin('akses_cetak_barcode')) {
            return $response;
        }

        $sample = Analysis::whereId($analysis_id)->get()->last();
        return view('barcode_printing.show', compact('sample'));
    }

    public function list(Request $request){
        if ($response = $this->checkIzin('akses_daftar_barcode')) {
            return $response;
        }

        if ($request->ajax()) {
            $data = Analysis::with('material', 'user');

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('material', function ($row) {
                    return $row->material ? $row->material->name : '-';
                })
                ->addColumn('user', function ($row) {
                    return $row->user ? $row->user->name : '-';
                })
                ->addColumn('created_at', function ($row) {
                    return $row->created_at
                        ? $row->created_at->format('d-m-Y H:i')
                        : '-';
                })
                ->addColumn('action', function ($row) {
                    $buttons = '<div class="btn-group" role="group">';
                    if (Auth()->user()->role->akses_edit_timestamp_barcode) {
                        $editTimestamp = route('barcode_printing.editTimestamp', $row->id);
                        $buttons .= '<a href="' . $editTimestamp . '" class="btn btn-sm btn-secondary">Edit Timestamp</a>';
                    }
                    if (Auth()->user()->role->akses_edit_material_barcode) {
                        $editMaterial = route('barcode_printing.editMaterial', $row->id);
                        $buttons .= '<a href="' . $editMaterial . '" class="btn btn-sm btn-success">Edit Material</a>';
                    }
                    if (Auth()->user()->role->akses_cetak_barcode) {
                        $reprintUrl = route('barcode_printing.reprint', $row->id);
                        $buttons .= '<a href="' . $reprintUrl . '" class="btn btn-sm btn-info">Cetak Ulang</a>';
                    }
                    if (Auth()->user()->role->akses_hapus_analisa) {
                        $deleteUrl = route('analyses.destroy', $row->id);
                        $buttons .= '
                            <form action="' . $deleteUrl . '" method="POST" onsubmit="return confirm(\'Hapus data ini?\')" style="display:inline-block;">
                                ' . csrf_field() . method_field('DELETE') . '
                                <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                            </form>
                        ';
                    }
                    $buttons .= '</div>';
                    return $buttons;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('barcode_printing.list');
    }

    public function editTimestamp($sample_id){
        if ($response = $this->checkIzin('akses_edit_timestamp_barcode')) {
            return $response;
        }

        $sample = Analysis::select(['id', 'created_at'])->whereId($sample_id)->get()->last();
        return view('barcode_printing.edit_timestamp', compact('sample'));
    }

    public function editTimestampProcess(Request $request, $sample_id){
        if ($response = $this->checkIzin('akses_edit_timestamp_barcode')) {
            return $response;
        }

        Analysis::whereId($sample_id)->update(['created_at' => $request->created_at]);
        return redirect()->route('barcode_printing.list')->with('success', 'Timestamp berhasil diupdate');
    }

    public function editMaterial($sample_id){
        if ($response = $this->checkIzin('akses_edit_material_barcode')) {
            return $response;
        }

        $materials = Material::select(['id', 'name'])
            ->where('sampling_method', 'request')
            ->where('is_active', 1)
            ->orderBy('id')->get();

        $sample = Analysis::select(['id', 'material_id'])->whereId($sample_id)->get()->last();
        return view('barcode_printing.edit_material', compact('materials', 'sample'));
    }

    public function editMaterialProcess(Request $request, $sample_id){
        if ($response = $this->checkIzin('akses_edit_material_barcode')) {
            return $response;
        }

        Analysis::whereId($sample_id)->update(['material_id' => $request->material_id]);
        return redirect()->route('barcode_printing.list')->with('success', 'Material berhasil diupdate');
    }
}
