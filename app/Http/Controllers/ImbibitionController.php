<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\MonitoringHourly;
use Yajra\DataTables\DataTables;
use App\Models\MonitoringHourlySpot;

class ImbibitionController extends Controller
{
    public function index(Request $request)
    {
        if ($response = $this->checkIzin('akses_daftar_imbibisi')) {
            return $response;
        }

        if ($request->ajax()) {
            $spots = MonitoringHourlySpot::select(['id', 'name'])
                ->whereIn('id', [4,7,10])
                ->orderBy('id')
                ->get();
            $data = MonitoringHourly::with(['user']);
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('user', function ($row) {
                    return $row->user ? $row->user->name : '-';
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

        return view('imbibisi.index');
    }

    public function create()
    {
        if ($response = $this->checkIzin('akses_tambah_imbibisi')) {
            return $response;
        }

        $last_monitoring = MonitoringHourly::orderBy('id', 'desc')->skip(1)->first();
        return view('imbibisi.create', compact('last_monitoring'));
    }

    public function store(Request $request)
    {
        if ($response = $this->checkIzin('akses_tambah_imbibisi')) {
            return $response;
        }

        $createdAt = Carbon::parse($request->date)
            ->setHour($request->time)
            ->setMinute(0)
            ->setSecond(0);

        $data = $request->except(['date', 'time']);
        $data['user_id'] = auth()->id();
        $data['created_at'] = $createdAt;

        $lastMonitoring = MonitoringHourly::orderBy('created_at', 'desc')->first();
        $p1 = $lastMonitoring->p1 ?? 0;

        if ($p1 > 0) {
            $data['p8'] = ($request->p7 / $p1) * 100;
        } else {
            $data['p8'] = null;
        }

        MonitoringHourly::updateOrCreate(
            ['created_at' => $createdAt],
            $data
        );

        return redirect()
            ->route('imbibisi.index')
            ->with('success', 'Data berhasil disimpan.');
    }
}
