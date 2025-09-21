<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Flow;
use Yajra\DataTables\DataTables;
use App\Models\FlowSpot;

class ImbibitionController extends Controller
{
    public function index(Request $request)
    {
        if ($response = $this->checkIzin('akses_daftar_imbibisi')) {
            return $response;
        }

        if ($request->ajax()) {
            $spots = FlowSpot::select(['id', 'name'])
                ->whereId(1)
                ->get();
            $data = Flow::with(['user']);
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
                    $list .= '<li><strong>Tebu Tergiling</strong> : ' . e($row->sugar_cane ?? '-') . '</li>';
                    foreach ($spots as $spot) {
                        $flowCol = 'f' . $spot->id;
                        $persenCol = 'p' . $spot->id;
                        $flowVal = $row->{$flowCol} ?? '-';
                        $persenVal = $row->{$persenCol} ?? '-';
                        $list .= '<li><strong>Flow</strong> ' . e($spot->name) . ' : ' . e($flowVal) . '</li>';
                        $list .= '<li><strong>' . e($spot->name) . '%Tebu</strong> : ' . e($persenVal) . '</li>';
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

        $last_monitoring = Flow::orderBy('id', 'desc')->skip(1)->first();
        return view('imbibisi.create', compact('last_monitoring'));
    }

    public function store(Request $request)
    {
        if ($response = $this->checkIzin('akses_tambah_imbibisi')) {
            return $response;
        }

        $hour = str_pad($request->time, 2, '0', STR_PAD_LEFT);
        $formattedTime = $hour . ':00:00';

        $data = $request->all();
        $data['user_id'] = auth()->id();
        $data['time'] = $formattedTime;

        $lastMonitoring = Flow::where('f1', '!=', 'null')->orderBy('id', 'desc')->get()->last();
        $sugar_cane = $lastMonitoring->sugar_cane ?? 0;

        if ($sugar_cane > 0) {
            $data['p1'] = ($request->f1 / $sugar_cane) * 100;
        } else {
            $data['p1'] = null;
        }

        Flow::updateOrCreate(
            ['date' => $data['date'], 'time' => $data['time']],
            $data
        );

        return redirect()
            ->route('imbibisi.index')
            ->with('success', 'Data berhasil disimpan.');
    }
}
