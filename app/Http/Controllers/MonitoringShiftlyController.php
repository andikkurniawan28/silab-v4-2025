<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\MonitoringShiftly;
use App\Models\MonitoringShiftlySpot;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class MonitoringShiftlyController extends Controller
{
    public function index(Request $request)
    {
        if ($response = $this->checkIzin('akses_daftar_monitoring_pershift')) {
            return $response;
        }

        if ($request->ajax()) {
            $data = MonitoringShiftly::with(['user']);
            $spots = MonitoringShiftlySpot::select(['id', 'name'])->orderBy('id')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('user', function ($row) {
                    return $row->user ? $row->user->name : '-';
                })
                ->addColumn('action', function ($row) {
                    $buttons = '<div class="btn-group" role="group">';
                    if (Auth()->user()->role->akses_edit_monitoring_pershift) {
                        $editUrl = route('monitoring_shiftlies.edit', $row->id);
                        $buttons .= '<a href="' . $editUrl . '" class="btn btn-sm btn-warning">Edit</a>';
                    }
                    if (Auth()->user()->role->akses_hapus_monitoring_pershift) {
                        $deleteUrl = route('monitoring_shiftlies.destroy', $row->id);
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
                ->addColumn('result', function ($row) use ($spots) {
                    if ($spots->isEmpty()) {
                        return '-';
                    }
                    $list = '<ul class="mb-0 ps-3">';
                    foreach ($spots as $spot) {
                        $colName = 'p' . $spot->id;
                        $value   = $row->{$colName} ?? '-';
                        $list   .= '<li>' . e($spot->name) . ' : ' . e($value) . '</li>';
                    }
                    $list .= '</ul>';

                    return $list;
                })
                ->rawColumns(['action', 'result'])
                ->make(true);
        }

        return view('monitoring_shiftlies.index');
    }

    public function create()
    {
        if ($response = $this->checkIzin('akses_tambah_monitoring_pershift')) {
            return $response;
        }

        $spots = MonitoringShiftlySpot::select(['id', 'name'])->orderBy('id')->get();
        return view('monitoring_shiftlies.create', compact('spots'));
    }

    public function store(Request $request)
    {
        if ($response = $this->checkIzin('akses_tambah_monitoring_pershift')) {
            return $response;
        }

        $request->request->add(['user_id' => Auth()->user()->id]);
        MonitoringShiftly::create($request->all());

        return redirect()->route('monitoring_shiftlies.index')->with('success', 'Monitoring Pershift berhasil diperbarui.');
    }

    public function edit(MonitoringShiftly $monitoring_shiftly)
    {
        if ($response = $this->checkIzin('akses_edit_monitoring_pershift')) {
            return $response;
        }

        $spots = MonitoringShiftlySpot::select(['id', 'name'])->orderBy('id')->get();
        return view('monitoring_shiftlies.edit', compact('monitoring_shiftly', 'spots'));
    }

    public function update(Request $request, MonitoringShiftly $monitoring_shiftly)
    {
        if ($response = $this->checkIzin('akses_edit_monitoring_pershift')) {
            return $response;
        }

        $monitoring_shiftly->update($request->except(['_token', '_method']));

        return redirect()->route('monitoring_shiftlies.index')->with('success', 'Monitoring Pershift berhasil diperbarui.');
    }

    public function destroy(MonitoringShiftly $monitoring_shiftly)
    {
        if ($response = $this->checkIzin('akses_hapus_monitoring_pershift')) {
            return $response;
        }

        $monitoring_shiftly->delete();
        return redirect()->route('monitoring_shiftlies.index')->with('success', 'Monitoring Pershift berhasil dihapus.');
    }
}
