<?php

namespace App\Http\Controllers;

use App\Models\Factor;
use App\Models\Analysis;
use App\Models\Parameter;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\ParameterMaterial;

class AnalysisController extends Controller
{
    public function index(Request $request)
    {
        if ($response = $this->checkIzin('akses_daftar_analisa')) {
            return $response;
        }

        if ($request->ajax()) {
            $data = Analysis::with(['material', 'user']);
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
                ->addColumn('action', function ($row) {
                    $buttons = '<div class="btn-group" role="group">';
                    if (Auth()->user()->role->akses_edit_analisa) {
                        $editUrl = route('analyses.edit', $row->id);
                        $buttons .= '<a href="' . $editUrl . '" class="btn btn-sm btn-warning">Edit</a>';
                    }
                    $buttons .= '</div>';
                    return $buttons;
                })
                ->addColumn('created_at', function ($row) {
                    return $row->created_at
                        ? $row->created_at->format('d-m-Y H:i')
                        : '-';
                })
                ->rawColumns(['action', 'status', 'result'])
                ->make(true);
        }

        return view('analyses.index');
    }

    public function edit(Analysis $analysis)
    {
        if ($response = $this->checkIzin('akses_edit_analisa')) {
            return $response;
        }

        $factors = Factor::pluck('value', 'name');

        $parameters = ParameterMaterial::where('material_id', $analysis->material_id)
            ->with('parameter.unit')
            ->get();

        return view('analyses.edit', compact('factors', 'analysis', 'parameters'));
    }

    public function update(Request $request, Analysis $analysis)
    {
        if ($response = $this->checkIzin('akses_edit_analisa')) {
            return $response;
        }

        $request->validate([
            'volume'    => 'nullable|numeric',
            'pan'       => 'nullable|integer',
            'reef'      => 'nullable|integer',
            'nopol'     => 'nullable',
        ]);

        $analysis->volume = $request->input('volume');
        $analysis->pan = $request->input('pan');
        $analysis->reef = $request->input('reef');
        $analysis->nopol = $request->input('nopol');

        $parameters = ParameterMaterial::where('material_id', $analysis->material_id)->get();

        foreach ($parameters as $pm) {
            $colName = 'p' . $pm->parameter_id;
            if ($request->has($colName)) {
                $analysis->{$colName} = $request->input($colName);
            }
        }

        $analysis->save();

        ActivityLog::log(Auth()->user()->id, "Edit analisa barcode {$analysis->id}.");

        return redirect()->route('analyses.index')->with('success', 'Analisa berhasil diperbarui.');
    }

    public function destroy(Analysis $analysis)
    {
        if ($response = $this->checkIzin('akses_hapus_analisa')) {
            return $response;
        }

        ActivityLog::log(Auth()->user()->id, "Hapus analisa barcode {$analysis->id}.");

        $analysis->delete();

        return redirect()->back()->with('success', 'Analisa berhasil dihapus.');
    }
}
