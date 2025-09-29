<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Models\Factor;
use App\Models\Analysis;
use App\Models\Parameter;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\ParameterMaterial;
use Illuminate\Support\Facades\DB;
use App\Models\AnalysisChangeRequest;

class AnalysisChangeRequestController extends Controller
{

    public function index(Request $request)
    {
        if ($response = $this->checkIzin('akses_daftar_revisi_analisa')) {
            return $response;
        }

        if ($request->ajax()) {
            $data = AnalysisChangeRequest::with(['material', 'user', 'analysis']);
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('material', function ($row) {
                    return $row->material ? $row->material->name : '-';
                })
                ->addColumn('user', function ($row) {
                    return $row->user ? $row->user->name : '-';
                })
                ->addColumn('pemohon', function ($row) {
                    return $row->analysis->user ? $row->analysis->user->name : '-';
                })
                ->addColumn('before', function ($row) {
                    $parameters = $row->material->parameters ?? collect();
                    if ($parameters->isEmpty()) {
                        return '-';
                    }
                    $list = '<ul class="mb-0 ps-3">';
                    foreach ($parameters as $param) {
                        $colName = 'p' . $param->id . '_old';
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
                ->addColumn('after', function ($row) {
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
                    return $row->status
                        ? '<span class="badge bg-success text-white">Disetujui</span>'
                        : '<span class="badge bg-danger text-white">Belum Diproses</span>';
                })
                ->addColumn('action', function ($row) {
                    if($row->status != 1){
                        $buttons = '<div class="btn-group" role="group">';
                        if (Auth()->user()->role->akses_setujui_revisi_analisa && $row->user_id == Auth()->user()->id) {
                            $editUrl = route('analysisChangeRequest.close', $row->id);
                            $buttons .= '<a href="' . $editUrl . '" class="btn btn-sm btn-success" target="_blank">Setujui</a>';
                        }
                        $buttons .= '</div>';
                        return $buttons;
                    }
                })
                ->addColumn('created_at', function ($row) {
                    return $row->created_at
                        ? $row->created_at->format('d-m-Y H:i')
                        : '-';
                })
                ->rawColumns(['action', 'before', 'after', 'status'])
                ->make(true);
        }

        return view('analysis_change_requests.index');
    }

    public function edit(Analysis $analysis)
    {
        if ($response = $this->checkIzin('akses_ajukan_revisi_analisa')) {
            return $response;
        }

        $factors = Factor::pluck('value', 'name');

        $parameters = ParameterMaterial::where('material_id', $analysis->material_id)
            ->with('parameter.unit')
            ->get();

        $roles = Role::where('akses_setujui_revisi_analisa', 1)->select(['id'])->get();
        $users = User::whereIn('role_id', $roles)->select(['id', 'name'])->get();

        return view('analysis_change_requests.edit', compact('factors', 'analysis', 'parameters', 'users'));
    }

    public function process(Request $request)
    {
        if ($response = $this->checkIzin('akses_ajukan_revisi_analisa')) {
            return $response;
        }

        AnalysisChangeRequest::create($request->all());
        // Nanti disini kirim tele

        return redirect()->route('analysisChangeRequest.index')->with('success', 'Revisi berhasil diajukan');
    }

    public function close($id)
    {
        if ($response = $this->checkIzin('akses_setujui_revisi_analisa')) {
            return $response;
        }

        $changeRequest = AnalysisChangeRequest::findOrFail($id);
        $analysis = $changeRequest->analysis;

        DB::transaction(function () use ($changeRequest, $analysis) {

            $parameters = Parameter::select(['id'])->orderBy('id')->get();

            // Salin semua field p1 sampai p10 dari changeRequest ke analysis
            foreach($parameters as $i){
                $field = 'p' . $i->id;
                if (!empty($changeRequest->$field) || $changeRequest->$field === 0 || $changeRequest->$field === '0') {
                    $analysis->$field = $changeRequest->$field;
                }
            }

            // Update status change request
            $changeRequest->status = 1;

            $analysis->save();
            $changeRequest->save();
        });

        return redirect()->route('analysisChangeRequest.index')->with('success', 'Revisi berhasil disetujui');
    }

    public function closeAksesMobile($id)
    {
        if ($response = $this->checkIzin('akses_setujui_revisi_analisa')) {
            return $response;
        }

        $changeRequest = AnalysisChangeRequest::findOrFail($id);
        $analysis = $changeRequest->analysis;

        DB::transaction(function () use ($changeRequest, $analysis) {

            $parameters = Parameter::select(['id'])->orderBy('id')->get();

            // Salin semua field p1 sampai p10 dari changeRequest ke analysis
            foreach($parameters as $i){
                $field = 'p' . $i->id;
                if (!empty($changeRequest->$field) || $changeRequest->$field === 0 || $changeRequest->$field === '0') {
                    $analysis->$field = $changeRequest->$field;
                }
            }

            // Update status change request
            $changeRequest->status = 1;

            $analysis->save();
            $changeRequest->save();
        });

        return 'Revisi berhasil disetujui';
    }
}
