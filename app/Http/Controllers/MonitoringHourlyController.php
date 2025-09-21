<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\MonitoringHourly;
use App\Models\MonitoringHourlySpot;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class MonitoringHourlyController extends Controller
{
    public function index(Request $request)
    {
        if ($response = $this->checkIzin('akses_daftar_monitoring_perjam')) {
            return $response;
        }

        if ($request->ajax()) {
            $data = MonitoringHourly::with(['user']);
            $spots = MonitoringHourlySpot::select(['id', 'name'])->orderBy('id')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('user', function ($row) {
                    return $row->user ? $row->user->name : '-';
                })
                ->addColumn('action', function ($row) {
                    $buttons = '<div class="btn-group" role="group">';
                    if (Auth()->user()->role->akses_edit_monitoring_perjam) {
                        $editUrl = route('monitoring_hourlies.edit', $row->id);
                        $buttons .= '<a href="' . $editUrl . '" class="btn btn-sm btn-warning">Edit</a>';
                    }
                    if (Auth()->user()->role->akses_hapus_monitoring_perjam) {
                        $deleteUrl = route('monitoring_hourlies.destroy', $row->id);
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
                ->addColumn('created_at', function ($row) {
                    return $row->created_at
                        ? $row->created_at->format('d-m-Y H:i')
                        : '-';
                })
                ->rawColumns(['action', 'result'])
                ->make(true);
        }

        return view('monitoring_hourlies.index');
    }

    public function create()
    {
        if ($response = $this->checkIzin('akses_edit_monitoring_perjam')) {
            return $response;
        }

        $spots = MonitoringHourlySpot::select(['id', 'name'])->orderBy('id')->get();
        return view('monitoring_hourlies.create', compact('spots'));
    }

    public function store(Request $request)
    {
        if ($response = $this->checkIzin('akses_tambah_monitoring_perjam')) {
            return $response;
        }

        $createdAt = Carbon::parse($request->date)
            ->setHour($request->time)
            ->setMinute(0)
            ->setSecond(0);

        $request->request->add(['created_at' => $createdAt, 'user_id' => Auth()->user()->id]);

        MonitoringHourly::create($request->except(['date', 'time']));

        return redirect()->route('monitoring_hourlies.index')->with('success', 'Monitoring Perjam berhasil diperbarui.');
    }

    public function edit(MonitoringHourly $monitoring_hourly)
    {
        if ($response = $this->checkIzin('akses_edit_monitoring_perjam')) {
            return $response;
        }

        $spots = MonitoringHourlySpot::select(['id', 'name'])->orderBy('id')->get();
        return view('monitoring_hourlies.edit', compact('monitoring_hourly', 'spots'));
    }

    public function update(Request $request, MonitoringHourly $monitoring_hourly)
    {
        if ($response = $this->checkIzin('akses_edit_monitoring_perjam')) {
            return $response;
        }

        $createdAt = Carbon::parse($request->date)
            ->setHour($request->time)
            ->setMinute(0)
            ->setSecond(0);

        $request->request->add(['created_at' => $createdAt]);

        $monitoring_hourly->update($request->except(['_token', '_method', 'date', 'time']));

        return redirect()->route('monitoring_hourlies.index')->with('success', 'Monitoring Perjam berhasil diperbarui.');
    }

    public function destroy(MonitoringHourly $monitoring_hourly)
    {
        if ($response = $this->checkIzin('akses_hapus_monitoring_perjam')) {
            return $response;
        }

        $monitoring_hourly->delete();
        return redirect()->route('monitoring_hourlies.index')->with('success', 'Monitoring Perjam berhasil dihapus.');
    }
}
