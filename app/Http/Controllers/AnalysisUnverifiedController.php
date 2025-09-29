<?php

namespace App\Http\Controllers;

use App\Models\Analysis;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class AnalysisUnverifiedController extends Controller
{
    public function index(Request $request)
    {
        if ($response = $this->checkIzin('akses_verifikasi_mandor')) {
            return $response;
        }

        if ($request->ajax()) {
            $data = Analysis::where('is_verified', 0)->with(['material', 'user', 'analysisChangeRequest']);
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
                        $buttons .= '<a href="' . $editUrl . '" target="_blank" class="btn btn-sm btn-warning">Edit</a>';
                    }
                    if (Auth()->user()->role->akses_ajukan_revisi_analisa && !$row->analysisChangeRequest) {
                        $editUrl = route('analysisChangeRequest.propose', $row->id);
                        $buttons .= '<a href="' . $editUrl . '" class="btn btn-sm btn-danger">Ajukan Revisi</a>';
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

        return view('analysis_unverified.index');
    }

    public function process(Request $request)
    {
        if ($response = $this->checkIzin('akses_verifikasi_mandor')) {
            return $response;
        }

        $ids = $request->input('ids');

        if (empty($ids) || !is_array($ids)) {
            return redirect()->back()->with('failed', 'Tidak ada data yang dipilih');
        }

        try {
            Analysis::whereIn('id', $ids)->update([
                'is_verified' => 1,
            ]);
            return redirect()->back()->with('success', 'Data berhasil diverifikasi');
        } catch (\Exception $e) {
            return redirect()->back()->with('failed', $e->getMessage());
        }
    }
}
