<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\MonitoringHourly;
use Yajra\DataTables\DataTables;
use App\Models\MonitoringHourlySpot;

class KelilingController extends Controller
{
    public function index(Request $request){
        if ($response = $this->checkIzin('akses_daftar_keliling_proses')) {
            return $response;
        }

        if ($request->ajax()) {
            $spots = MonitoringHourlySpot::select(['id', 'name'])
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

        return view('keliling_proses.index');
    }

    public function create(){
        if ($response = $this->checkIzin('akses_tambah_keliling_proses')) {
            return $response;
        }

        $spots = MonitoringHourlySpot::select(['id', 'name'])
                ->orderBy('id')
                ->get();
        return view('keliling_proses.create', compact('spots'));
    }

    public function store(Request $request)
    {
        if ($response = $this->checkIzin('akses_tambah_keliling_proses')) {
            return $response;
        }

        $request->validate([
            'date' => 'required|date',
            'time' => 'required|integer|min:0|max:23',
        ]);

        $createdAt = Carbon::parse($request->date)
            ->setHour($request->time)
            ->setMinute(0)
            ->setSecond(0);

        $data = $request->except(['date', 'time']);
        $data['user_id'] = auth()->id();
        $data['created_at'] = $createdAt;

        MonitoringHourly::updateOrCreate(
            ['created_at' => $createdAt],
            $data
        );

        return redirect()
            ->route('keliling_proses.index')
            ->with('success', 'Data berhasil disimpan.');
    }

}
